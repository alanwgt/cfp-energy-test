import { useMemo } from 'react';

import { DeleteForever, Edit, Visibility } from '@mui/icons-material';
import { IconButton, Stack, Tooltip } from '@mui/material';
import { DataGrid } from '@mui/x-data-grid';
import { useMutation } from '@tanstack/react-query';
import { useConfirm } from 'material-ui-confirm';
import { Link } from 'react-router-dom';

import { deleteUser, fetchUsers } from '../api/usersApi.js';
import withRemotePaginated from '../components/hocs/withRemotePaginated.jsx';
import Page from '../components/layout/Page.jsx';
import queryClient from '../lib/queryClient.js';
import toast from '../lib/toast.js';
import { QUERY_KEYS } from '../utils/queryKeys.js';

function ListUsersPage({ data }) {
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
            { field: 'id', headerName: 'ID', width: 50 },
            { field: 'first_name', headerName: 'First Name' },
            { field: 'username', headerName: 'Username', width: 150 },
            { field: 'email', headerName: 'Email', flex: 1 },
            {
                field: 'actions',
                headerName: 'Actions',
                sortable: false,
                width: 150,
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

    return (
        <Page title='Users' breadcrumbs={[{ to: '/users', label: 'Users' }]}>
            <DataGrid
                columns={columns}
                rows={data.data}
                paginationMode='client'
                hideFooter
                hideFooterPagination
            />
        </Page>
    );
}

export default withRemotePaginated(fetchUsers, QUERY_KEYS.USERS)(ListUsersPage);
