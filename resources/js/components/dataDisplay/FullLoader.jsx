import { CircularProgress } from '@mui/material';
import Box from '@mui/material/Box';

export default function FullLoader({ fullScreen, size = 50 }) {
    return (
        <Box
            sx={theme => ({
                display: 'flex',
                justifyContent: 'center',
                alignItems: 'center',
                width: '100%',
                height: '100%',
                backgroundColor: theme.palette.primary.main,
                ...(fullScreen && {
                    position: 'fixed',
                    top: 0,
                    left: 0,
                    zIndex: 9999,
                }),
            })}
        >
            <CircularProgress size={size} color='secondary' />
        </Box>
    );
}
