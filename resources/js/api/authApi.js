import axios from '../lib/axios.js';

export function loginWithPassword(identification, password, rememberMe) {
    return axios.post('auth/sign-in', {
        identification,
        password,
        remember_me: rememberMe,
    });
}

export function logout() {
    return axios.post('auth/sign-out');
}

export function register(
    username,
    email,
    password,
    firstName,
    lastName,
    phoneNumber,
    dateOfBirth
) {
    return axios.post('auth/sign-up', {
        username,
        email,
        password,
        first_name: firstName,
        last_name: lastName,
        phone_number: phoneNumber,
        date_of_birth: dateOfBirth,
        authentication_method: 'password',
        role: 'user',
    });
}

export function checkAuth() {
    return axios.get('auth/check');
}
