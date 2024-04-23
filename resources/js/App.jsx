import { Suspense } from 'react';

import '@fontsource/roboto/300.css';
import '@fontsource/roboto/400.css';
import '@fontsource/roboto/500.css';
import '@fontsource/roboto/700.css';
import CssBaseline from '@mui/material/CssBaseline';
import { ThemeProvider } from '@mui/material/styles';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDateFns } from '@mui/x-date-pickers/AdapterDateFnsV3';
import {
    QueryClientProvider,
    QueryErrorResetBoundary,
} from '@tanstack/react-query';
import { ConfirmProvider } from 'material-ui-confirm';
import { SnackbarProvider } from 'notistack';
import { ErrorBoundary } from 'react-error-boundary';
import { BrowserRouter } from 'react-router-dom';

import AuthLock from './components/auth/AuthLock.jsx';
import Exception from './components/feedback/Exception.jsx';
import Loading from './components/feedback/Loading.jsx';
import { Shell } from './components/layout/Shell.jsx';
import { AuthProvider } from './context/AuthContext.jsx';
import materialTheme from './lib/materialTheme.js';
import queryClient from './lib/queryClient.js';
import Routes from './routes/index.jsx';

export default function App() {
    return (
        <LocalizationProvider dateAdapter={AdapterDateFns}>
            <ThemeProvider theme={materialTheme}>
                <CssBaseline />
                <SnackbarProvider />
                <BrowserRouter>
                    <QueryErrorResetBoundary>
                        {({ reset }) => (
                            <ErrorBoundary
                                onReset={reset}
                                fallbackRender={Exception}
                            >
                                <ConfirmProvider>
                                    <Suspense fallback={<Loading />}>
                                        <AuthProvider>
                                            <AuthLock>
                                                <QueryClientProvider
                                                    client={queryClient}
                                                >
                                                    <Shell>
                                                        <Routes />
                                                    </Shell>
                                                </QueryClientProvider>
                                            </AuthLock>
                                        </AuthProvider>
                                    </Suspense>
                                </ConfirmProvider>
                            </ErrorBoundary>
                        )}
                    </QueryErrorResetBoundary>
                </BrowserRouter>
            </ThemeProvider>
        </LocalizationProvider>
    );
}
