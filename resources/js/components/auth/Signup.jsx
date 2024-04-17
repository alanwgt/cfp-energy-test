import Box from '@mui/material/Box';

import { useAuth } from '../../context/AuthContext.jsx';
import CreateUser from '../user/CreateUser.jsx';

export default function Signup() {
    const { register } = useAuth();

    return (
        <Box sx={{ mt: 1 }}>
            <CreateUser
                onCreate={values =>
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
