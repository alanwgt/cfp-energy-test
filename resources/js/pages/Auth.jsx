import { useEffect, useState } from 'react';

import Box from '@mui/material/Box';
import Grid from '@mui/material/Grid';
import Link from '@mui/material/Link';
import Paper from '@mui/material/Paper';
import Typography from '@mui/material/Typography';

import Login from '../components/auth/Login.jsx';
import Signup from '../components/auth/Signup.jsx';

export default function Auth() {
    const [showLogin, setShowLogin] = useState(true);

    useEffect(() => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('signup')) {
            setShowLogin(false);
        }
    }, []);

    return (
        <Grid container component='main' sx={{ height: '100vh' }}>
            <Grid
                item
                xs={false}
                sm={4}
                md={7}
                sx={{
                    backgroundImage:
                        'url(/images/ryan-grice-oWoMJ4A1fyc-unsplash.jpg)',
                    backgroundRepeat: 'no-repeat',
                    backgroundColor: t =>
                        t.palette.mode === 'light'
                            ? t.palette.grey[50]
                            : t.palette.grey[900],
                    backgroundSize: 'cover',
                    backgroundPosition: 'right',
                }}
            ></Grid>
            <Grid
                item
                xs={12}
                sm={8}
                md={5}
                component={Paper}
                elevation={6}
                square
            >
                <Box
                    sx={{
                        my: 8,
                        mx: 4,
                        display: 'flex',
                        flexDirection: 'column',
                        alignItems: 'center',
                    }}
                >
                    <Box sx={{ mb: 2 }}>
                        <img src='images/cfp.svg' alt='CFP Logo' />
                    </Box>
                    <Typography component='h1' variant='h3'>
                        {showLogin ? 'Sign in' : 'Sign up'}
                    </Typography>
                    <Box sx={{ mt: 3, width: '100%' }}>
                        {showLogin ? <Login /> : <Signup />}
                    </Box>
                    <Grid container sx={{ mt: 1 }}>
                        <Grid item xs>
                            {showLogin && (
                                <Link href='#' variant='body2'>
                                    Forgot password?
                                </Link>
                            )}
                        </Grid>
                        <Grid item>
                            <Link
                                component='button'
                                variant='body2'
                                onClick={() => {
                                    setShowLogin(show => !show);
                                }}
                            >
                                {showLogin
                                    ? "Don't have an account? Sign Up"
                                    : 'Already have an account? Sign In'}
                            </Link>
                        </Grid>
                    </Grid>
                </Box>
            </Grid>
        </Grid>
    );
}
