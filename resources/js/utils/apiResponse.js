export function parseApiErrors(error) {
    if (!error.response) {
        return error.message || 'An unknown error occurred.';
    }

    const apiMessage = error.response.data.message;
    if (typeof apiMessage === 'string') {
        return apiMessage;
    }

    return handleBackendMessage(apiMessage);
}

export function handleBackendMessage(message) {
    if (typeof message === 'string') {
        return message;
    }

    const msgs = [];
    Object.entries(message).forEach(([key, val]) => {
        let innerMsg = `${key}: `;
        if (Array.isArray(val)) {
            innerMsg += val.join(', ');
        } else {
            innerMsg += val;
        }

        msgs.push(innerMsg);
    });

    return msgs.join('; ');
}
