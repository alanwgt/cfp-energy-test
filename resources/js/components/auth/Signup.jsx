import Box from '@mui/material/Box';

import { useAuth } from '../../context/AuthContext.jsx';
import ManageUser from '../user/ManageUser.jsx';

export default function Signup() {
    const { register } = useAuth();

    return (
        <Box sx={{ mt: 1 }}>
            <ManageUser
                onSuccess={values =>
                    register(
                        values.username,
                        values.email,
                        values.password,
                        values.firstName,
                        values.lastName,
                        values.phoneNumber,
                        values.dateOfBirth
                    )
                }
            />
        </Box>
    );
}
