import axios from '../lib/axios.js';
import { handleDateProp } from '../utils/date.js';

export const fetchUsers = props => {
    const params = {};
    if (props.page) {
        params.page = props.page;
    }

    if (props.filters && Object.keys(props.filters).length) {
        params.filters = encodeURIComponent(JSON.stringify(props.filters));
    }

    return axios.get('users', {
        params,
    });
};

export const fetchUser = ({ id }) => axios.get(`users/${id}`);

export const fetchProfile = () =>
    axios.get('users/me').then(data => {
        console.log(data);
        const t = handleDateProp(data, 'data.data.date_of_birth');
        console.log(data);
        return t;
    });

export const createUser = data => axios.post('users', data);

export const updateUser = ({ id, ...data }) => axios.patch(`users/${id}`, data);
