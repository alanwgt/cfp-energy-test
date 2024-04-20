import { CircularProgress, Stack } from '@mui/material';

export default function Loading({ size = 24 }) {
    return (
        <Stack direction='row' justifyContent='center' alignItems='center'>
            <CircularProgress size={size} />
        </Stack>
    );
}
