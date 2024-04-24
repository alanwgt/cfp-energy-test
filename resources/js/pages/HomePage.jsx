import { DataGrid } from '@mui/x-data-grid';

import { fetchLoginAttempts } from '../api/usersApi.js';
import withRemotePaginated from '../components/hocs/withRemotePaginated.jsx';
import Page from '../components/layout/Page.jsx';
import { useAuth } from '../context/AuthContext.jsx';
import { QUERY_KEYS } from '../utils/queryKeys.js';

function HomePage() {
    const { user } = useAuth();
    const columns = [
        { field: 'ip_address', headerName: 'IP Address', flex: 1 },
        { field: 'user_agent', headerName: 'User Agent', flex: 1 },
        { field: 'attempted_at', headerName: 'Attempted At', flex: 1 },
        { field: 'succeeded', headerName: 'Succeeded', type: 'boolean' },
    ];

    const Component = withRemotePaginated(
        fetchLoginAttempts(user.id),
        QUERY_KEYS.LOGIN_ATTEMPTS
    )(({ data, isLoading }) => (
        <Page title='Login Attempts'>
            <DataGrid
                columns={columns}
                rows={data.data}
                loading={isLoading}
                hideFooter
                hideFooterPagination
                disableRowSelectionOnClick
                disableColumnSorting
                disableColumnFilter
            />
        </Page>
    ));

    return <Component />;
}

export default HomePage;
