import { useCallback, useMemo } from 'react';

import { DeleteForever, Edit, Visibility } from '@mui/icons-material';
import { IconButton, Stack, Tooltip } from '@mui/material';
import {
    DataGrid,
    GridToolbar,
    getGridStringOperators,
} from '@mui/x-data-grid';
import { useMutation } from '@tanstack/react-query';
import { useConfirm } from 'material-ui-confirm';
import { Link } from 'react-router-dom';

import { deleteUser, fetchUsers } from '../api/usersApi.js';
import withRemotePaginated from '../components/hocs/withRemotePaginated.jsx';
import Page from '../components/layout/Page.jsx';
import queryClient from '../lib/queryClient.js';
import toast from '../lib/toast.js';
import { QUERY_KEYS } from '../utils/queryKeys.js';

const filterOperators = getGridStringOperators().filter(
    operator =>
        operator.value === 'equals' ||
        operator.value === 'contains' ||
        operator.value === 'startsWith' ||
        operator.value === 'endsWith'
);

function ListUsersPage({ data, isLoading, filters, setFilters }) {
    const confirm = useConfirm();
    const mutation = useMutation({
        mutationFn: id => deleteUser({ id }),
        onSuccess: () => {
            queryClient.invalidateQueries({
                queryKey: QUERY_KEYS.USERS,
            });
        },
    });
    const columns = useMemo(
        () => [
            { field: 'id', headerName: 'ID', width: 50, filterOperators },
            { field: 'first_name', headerName: 'First Name', filterOperators },
            {
                field: 'username',
                headerName: 'Username',
                width: 150,
                filterOperators,
            },
            { field: 'email', headerName: 'Email', flex: 1, filterOperators },
            {
                field: 'actions',
                headerName: 'Actions',
                sortable: false,
                width: 150,
                type: 'actions',
                filterable: false,
                renderCell: ({ row }) => (
                    <Stack
                        direction='row'
                        gap={0}
                        justifyContent='center'
                        alignItems='center'
                        height='100%'
                    >
                        <Tooltip title='View' arrow>
                            <IconButton
                                aria-label='view'
                                color='primary'
                                size='small'
                                component={Link}
                                to={`/users/${row.id}`}
                            >
                                <Visibility />
                            </IconButton>
                        </Tooltip>
                        <Tooltip title='Edit' arrow>
                            <IconButton
                                aria-label='edit'
                                size='small'
                                component={Link}
                                to={`/users/${row.id}/edit`}
                            >
                                <Edit />
                            </IconButton>
                        </Tooltip>
                        <Tooltip title='Delete' arrow>
                            <IconButton
                                aria-label='delete'
                                color='error'
                                size='small'
                                onClick={() =>
                                    confirm({
                                        title: 'Delete User',
                                        description:
                                            'Are you sure you want to delete this user?',
                                        confirmationText: 'Delete',
                                    }).then(() =>
                                        mutation.mutate(row.id, {
                                            onSuccess: () =>
                                                toast.success('User deleted'),
                                        })
                                    )
                                }
                            >
                                <DeleteForever />
                            </IconButton>
                        </Tooltip>
                    </Stack>
                ),
            },
        ],
        [confirm, mutation]
    );

    const handleSortChange = useCallback(sortModel => {
        if (!sortModel.length) {
            if (filters.sort_order) {
                setFilters(({ sort_order, sort_by, ...otherFilters }) => ({
                    ...otherFilters,
                }));
            }
            return;
        }

        const { field, sort } = sortModel[0];

        setFilters(filters => ({
            ...filters,
            sort_by: field,
            sort_order: sort,
        }));
    }, []);

    const handleFilterChange = useCallback(filterModel => {
        const { quickFilterValues: quickFilter, items } = filterModel;
        const localFilters = { ...filters };

        for (const key in localFilters) {
            if (!items.find(item => item.field === key)) {
                delete localFilters[key];
            }
        }

        if (!quickFilter.length) {
            delete localFilters.quick_filter;
        } else {
            localFilters.quick_filter = quickFilter[0];
        }

        setFilters({
            ...localFilters,
            ...items.reduce((acc, item) => {
                const { field, operator, value } = item;
                return {
                    ...acc,
                    [field]: {
                        operator,
                        value,
                    },
                };
            }, {}),
        });
    }, []);

    return (
        <Page title='Users' breadcrumbs={[{ to: '/users', label: 'Users' }]}>
            <DataGrid
                columns={columns}
                rows={data.data}
                paginationMode='server'
                sortingMode='server'
                filterMode='server'
                hideFooter
                hideFooterPagination
                disableRowSelectionOnClick
                loading={isLoading}
                onSortModelChange={handleSortChange}
                onFilterModelChange={handleFilterChange}
                rowCount={data.meta?.total ?? 0}
                slots={{
                    toolbar: GridToolbar,
                }}
                slotProps={{
                    toolbar: {
                        csvOptions: { disableToolbarButton: true },
                        printOptions: { disableToolbarButton: true },
                        showQuickFilter: true,
                        quickFilterProps: { debounceMs: 250 },
                    },
                }}
                filterDebounceMs={250}
            />
        </Page>
    );
}

export default withRemotePaginated(fetchUsers, QUERY_KEYS.USERS)(ListUsersPage);
