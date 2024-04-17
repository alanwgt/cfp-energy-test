import { CircularProgress } from '@mui/material';
import Button from '@mui/material/Button';

export default function LoadingButton({ children, loading, ...rest }) {
    return (
        <Button
            {...rest}
            disabled={loading}
            sx={{
                display: 'flex',
                alignItems: 'center',
                '& > *': {
                    marginRight: '1rem',
                },
            }}
        >
            {loading && <CircularProgress size='1rem' color='inherit' />}
            {children}
        </Button>
    );
}
