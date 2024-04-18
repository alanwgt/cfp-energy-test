import axios from '../lib/axios.js';

export const loginWithPassword = (identification, password, rememberMe) =>
    axios.post('auth/sign-in', {
        identification,
        password,
        remember_me: rememberMe,
    });

export const logout = () => axios.post('auth/sign-out');

export const register = (
    username,
    email,
    password,
    firstName,
    lastName,
    phoneNumber,
    dateOfBirth
) =>
    axios.post('auth/sign-up', {
        username,
        email,
        password,
        first_name: firstName,
        last_name: lastName,
        phone_number: phoneNumber,
        date_of_birth: dateOfBirth,
    });

export const checkAuth = () => axios.get('auth/check');
