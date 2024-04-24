import Box from '@mui/material/Box';

import { useAuth } from '../../context/AuthContext.jsx';
import ManageUser from '../user/ManageUser.jsx';

export default function Signup() {
    const { register } = useAuth();

    return (
        <Box sx={{ mt: 1 }}>
            <ManageUser
                mutationFn={values =>
                    register(
                        values.username,
                        values.email,
                        values.password,
                        values.first_name,
                        values.last_name,
                        values.phone_number,
                        values.date_of_birth
                    )
                }
            />
        </Box>
    );
}
