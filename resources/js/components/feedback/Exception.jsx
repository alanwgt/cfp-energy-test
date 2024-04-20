import { Alert, AlertTitle, Stack } from '@mui/material';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';
import { Link } from 'react-router-dom';

import { parseApiErrors } from '../../utils/apiResponse.js';

export default function Exception({ error, resetErrorBoundary }) {
    return (
        <Alert variant='standard' severity='error'>
            <AlertTitle>Oh #*%@$!</AlertTitle>
            <Typography>
                The last request resulted in: <strong>{error.message}</strong>
            </Typography>
            <Typography color='red'>
                <strong>{parseApiErrors(error)}</strong>
            </Typography>
            {resetErrorBoundary && (
                <Stack direction='row' sx={{ mt: 1 }} gap={1}>
                    <Button onClick={resetErrorBoundary} color='error'>
                        Try again
                    </Button>
                    <Button component={Link} to='/' variant='contained'>
                        Take me home
                    </Button>
                </Stack>
            )}
        </Alert>
    );
}
