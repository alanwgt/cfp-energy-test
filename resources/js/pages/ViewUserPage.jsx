import { Cancel, Check } from '@mui/icons-material';
import { Card, CardContent, Stack } from '@mui/material';
import Typography from '@mui/material/Typography';
import Grid2 from '@mui/material/Unstable_Grid2';
import { useMutation } from '@tanstack/react-query';
import { useConfirm } from 'material-ui-confirm';
import { Link, useNavigate } from 'react-router-dom';

import { deleteUser, fetchUser } from '../api/usersApi.js';
import withRemoteData from '../components/hocs/withRemoteData.jsx';
import Page from '../components/layout/Page.jsx';
import queryClient from '../lib/queryClient.js';
import toast from '../lib/toast.js';
import { QUERY_KEYS } from '../utils/queryKeys.js';

function UserInfo({ title, children }) {
    return (
        <Grid2 md={6} xs={12}>
            <Card variant='outlined'>
                <CardContent>
                    <Stack>
                        <Typography variant='h6'>{title}</Typography>
                        <Typography variant='body1'>{children}</Typography>
                    </Stack>
                </CardContent>
            </Card>
        </Grid2>
    );
}

function ViewUserPage({ data: user }) {
    const confirm = useConfirm();
    const navigate = useNavigate();
    const mutation = useMutation({
        mutationFn: id => deleteUser({ id }),
        onSuccess: () => {
            queryClient.invalidateQueries({
                queryKey: QUERY_KEYS.USERS,
            });
        },
    });

    return (
        <Page
            title={`${user.first_name} ${user.last_name}`}
            breadcrumbs={[
                { to: '/users', label: 'Users' },
                { label: user.username },
            ]}
            actions={[
                {
                    label: 'Edit',
                    to: `/users/${user.id}/edit`,
                    component: Link,
                },
                {
                    label: 'Delete',
                    to: `/users/${user.id}/delete`,
                    color: 'error',
                    onClick: () =>
                        confirm({
                            title: 'Delete User',
                            description:
                                'Are you sure you want to delete this user?',
                            confirmationText: 'Delete',
                        }).then(() =>
                            mutation.mutate(user.id, {
                                onSuccess: () => {
                                    toast.success('User deleted');
                                    navigate('/users');
                                },
                            })
                        ),
                },
            ]}
        >
            <Grid2 container spacing={2}>
                <UserInfo title='First Name'>{user.first_name}</UserInfo>
                <UserInfo title='Last Name'>{user.last_name}</UserInfo>
                <UserInfo title='Username'>{user.username}</UserInfo>
                <UserInfo title='Email'>{user.email}</UserInfo>
                <UserInfo title='Mobile'>{user.phone_number}</UserInfo>
                <UserInfo title='Role'>{user.role}</UserInfo>
                <UserInfo title='ID'>{user.id}</UserInfo>
                <UserInfo title='Email verified'>
                    {user.verified ? (
                        <Check sx={{ color: 'green' }} />
                    ) : (
                        <Cancel sx={{ color: 'red' }} />
                    )}
                </UserInfo>
            </Grid2>
        </Page>
    );
}

export default withRemoteData(fetchUser, QUERY_KEYS.USERS)(ViewUserPage);
