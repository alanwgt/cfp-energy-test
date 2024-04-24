import { fetchUser } from '../api/usersApi.js';
import withRemoteData from '../components/hocs/withRemoteData.jsx';
import Page from '../components/layout/Page.jsx';
import ManageUser from '../components/user/ManageUser.jsx';
import queryClient from '../lib/queryClient.js';
import { QUERY_KEYS } from '../utils/queryKeys.js';

function ManageUserPage({ data: user }) {
    return (
        <Page
            title={user.username}
            breadcrumbs={[
                { label: 'Users', to: '/users' },
                { label: user.username, to: `/users/${user.id}` },
                { label: 'Edit' },
            ]}
        >
            <ManageUser
                initialValues={{ ...user }}
                onSuccess={() => {
                    queryClient.invalidateQueries({
                        queryKey: [...QUERY_KEYS.MANAGE_USER, '' + user.id],
                    });
                    queryClient.invalidateQueries({
                        queryKey: QUERY_KEYS.USERS,
                    });
                }}
            />
        </Page>
    );
}

export default withRemoteData(
    fetchUser,
    QUERY_KEYS.MANAGE_USER
)(ManageUserPage);