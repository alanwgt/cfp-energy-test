import { Cancel, Check } from '@mui/icons-material';
import { Card, CardContent, Stack } from '@mui/material';
import Typography from '@mui/material/Typography';
import Grid2 from '@mui/material/Unstable_Grid2';

import { fetchUser } from '../api/usersApi.js';
import withRemoteData from '../components/hocs/withRemoteData.jsx';
import Page from '../components/layout/Page.jsx';
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
    return (
        <Page
            title='View User'
            breadcrumbs={[
                { to: '/users', label: 'Users' },
                { label: user.username },
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

export default withRemoteData(fetchUser, QUERY_KEYS.USERS, true)(ViewUserPage);
