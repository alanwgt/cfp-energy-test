import { enqueueSnackbar } from 'notistack';

import { handleBackendMessage } from '../utils/apiResponse.js';

export default {
    error: message =>
        enqueueSnackbar(handleBackendMessage(message), { variant: 'error' }),
};
