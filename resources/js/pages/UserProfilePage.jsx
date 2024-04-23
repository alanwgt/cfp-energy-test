import { fetchProfile } from '../api/usersApi.js';
import withRemoteData from '../components/hocs/withRemoteData.jsx';
import Page from '../components/layout/Page.jsx';
import ManageUser from '../components/user/ManageUser.jsx';
import { useAuth } from '../context/AuthContext.jsx';
import { QUERY_KEYS } from '../utils/queryKeys.js';

function UserProfilePage({ data: profile }) {
    const { setUser } = useAuth();
    return (
        <Page title={profile.username} breadcrumbs={[{ label: 'Profile' }]}>
            <ManageUser
                initialValues={{ ...profile }}
                onSuccess={data => setUser(data)}
            />
        </Page>
    );
}

export default withRemoteData(
    fetchProfile,
    QUERY_KEYS.USER_PROFILE
)(UserProfilePage);
