import '@fontsource/roboto/300.css';
import '@fontsource/roboto/400.css';
import '@fontsource/roboto/500.css';
import '@fontsource/roboto/700.css';
import CssBaseline from '@mui/material/CssBaseline';
import { ThemeProvider } from '@mui/material/styles';
import { LocalizationProvider } from '@mui/x-date-pickers';
import { AdapterDateFns } from '@mui/x-date-pickers/AdapterDateFnsV3';
import { SnackbarProvider } from 'notistack';

import AuthLock from './components/auth/AuthLock.jsx';
import { Kernel } from './components/layout/Kernel.jsx';
import { AuthProvider } from './context/AuthContext.jsx';
import materialTheme from './lib/materialTheme.js';
import Routes from './routes/index.jsx';

export default function App() {
    return (
        <LocalizationProvider dateAdapter={AdapterDateFns}>
            <ThemeProvider theme={materialTheme}>
                <CssBaseline />
                <SnackbarProvider />
                <AuthProvider>
                    <AuthLock>
                        <Kernel>
                            <Routes />
                        </Kernel>
                    </AuthLock>
                </AuthProvider>
            </ThemeProvider>
        </LocalizationProvider>
    );
}
