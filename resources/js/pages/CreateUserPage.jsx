import { useNavigate } from 'react-router-dom';

import { createUser } from '../api/usersApi.js';
import Page from '../components/layout/Page.jsx';
import ManageUser from '../components/user/ManageUser.jsx';
import queryClient from '../lib/queryClient.js';
import { QUERY_KEYS } from '../utils/queryKeys.js';

export default function CreateUserPage({ data: user }) {
    const navigate = useNavigate();
    return (
        <Page
            title='New User'
            breadcrumbs={[{ label: 'Users', to: '/users' }, { label: 'New' }]}
        >
            <ManageUser
                mutationFn={values =>
                    createUser(values).then(({ data }) => {
                        queryClient.invalidateQueries({
                            queryKey: QUERY_KEYS.USERS,
                        });
                        navigate(`/users/${data.data.id}`);
                    })
                }
            />
        </Page>
    );
}
