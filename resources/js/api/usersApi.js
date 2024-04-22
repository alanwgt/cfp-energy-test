import axios from '../lib/axios.js';

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
