import { DeleteForever, Edit, Visibility } from '@mui/icons-material';
import { IconButton, Stack, Tooltip } from '@mui/material';
import { DataGrid } from '@mui/x-data-grid';

import { getUsers } from '../api/usersApi.js';
import withRemotePaginated from '../components/hocs/withRemotePaginated.jsx';
import Page from '../components/layout/Page.jsx';
import { QUERY_KEYS } from '../utils/queryKeys.js';

const columns = [
    { field: 'id', headerName: 'ID', width: 50 },
    { field: 'first_name', headerName: 'First Name' },
    { field: 'username', headerName: 'Username', width: 150 },
    { field: 'email', headerName: 'Email', flex: 1 },
    {
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
                    <IconButton aria-label='view' color='primary' size='small'>
                        <Visibility />
                    </IconButton>
                </Tooltip>
                <Tooltip title='Edit' arrow>
                    <IconButton aria-label='edit' size='small'>
                        <Edit />
                    </IconButton>
                </Tooltip>
                <Tooltip title='Delete' arrow>
                    <IconButton aria-label='delete' color='error' size='small'>
                        <DeleteForever />
                    </IconButton>
                </Tooltip>
            </Stack>
        ),
    },
];

function ListUsersPage({ data }) {
    return (
        <Page title='Users'>
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

export default withRemotePaginated(getUsers, QUERY_KEYS.USERS)(ListUsersPage);
