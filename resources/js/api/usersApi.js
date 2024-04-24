import axios from '../lib/axios.js';
import { handleDateProp } from '../utils/date.js';

export function fetchUsers(props) {
    const params = {};
    if (props.page) {
        params.page = props.page;
    }

    const { filters } = props;
    const { quick_filter, sort_order, sort_by, ...otherFilters } = filters;
    if (sort_order && sort_by) {
        params.sort_order = sort_order;
        params.sort_by = sort_by;
    }

    if (quick_filter) {
        params.quick_filter = quick_filter;
    }

    if (otherFilters && Object.keys(otherFilters).length) {
        params.filters = [];
        Object.keys(otherFilters).forEach(key => {
            const filter = otherFilters[key];
            if (!filter.value) {
                return;
            }

            params.filters.push({
                field: key,
                operator: filter.operator,
                value: filter.value,
            });
        });
    }

    return axios.get('users', {
        params,
    });
}

export function fetchUser({ id }) {
    return axios
        .get(`users/${id}`)
        .then(data => handleDateProp(data, 'data.data.date_of_birth'));
}

export function fetchProfile() {
    return axios
        .get('users/me')
        .then(data => handleDateProp(data, 'data.data.date_of_birth'));
}

export function createUser(data) {
    return axios.post('users', data);
}

export function updateUser({ id, ...data }) {
    return axios.patch(`users/${id}`, data);
}

export function deleteUser({ id }) {
    return axios.delete(`users/${id}`);
}

export function fetchLoginAttempts(userId) {
    return function (props) {
        const params = {};
        if (props.page) {
            params.page = props.page;
        }

        return axios.get(`users/${userId}/login-attempts`, {
            params,
        });
    };
}
