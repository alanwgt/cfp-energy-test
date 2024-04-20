import axios from '../lib/axios.js';

export const getUsers = () => axios.get('users');
