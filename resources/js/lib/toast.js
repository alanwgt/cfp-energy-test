import { enqueueSnackbar } from 'notistack';

const handleBackendMessage = message => {
    console.log(message);
    if (typeof message === 'string') {
        return message;
    }

    // TODO:
    const msgs = [];
    Object.entries(message).forEach((key, val) => {
        let innerMsg = `${key}: `;
        if (Array.isArray(val)) {
            innerMsg += val.join(', ');
        } else {
            innerMsg += val;
        }

        msgs.push(innerMsg);
    });

    return msgs.join('; ');
};

export default {
    error: message =>
        enqueueSnackbar(handleBackendMessage(message), { variant: 'error' }),
};
