import { enqueueSnackbar } from 'notistack';

export default {
    error: message => enqueueSnackbar(message, { variant: 'error' }),
};
