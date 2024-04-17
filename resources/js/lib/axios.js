import axios from 'axios';

import { API_URL } from '../constants/index.js';

const instance = axios.create({
    baseURL: API_URL,
    withCredentials: true,
    withXSRFToken: true,
    headers: {
        'Content-Type': 'application/json',
    },
});

export default instance;
