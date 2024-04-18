import { createContext, useContext, useEffect, useState } from 'react';

import {
    loginWithPassword as authLoginWithPassword,
    register as authRegister,
    checkAuth,
} from '../api/authApi.js';
import FullLoader from '../components/dataDisplay/FullLoader.jsx';
import { INIT_CSRF_URL } from '../constants/index.js';
import axios from '../lib/axios.js';
import toast from '../lib/toast.js';

export const AuthContext = createContext({
    user: null,
    loginWithPassword: () => {},
    logout: () => {},
    register: () => {},
    isAuthenticated: false,
});

export const AuthProvider = ({ children }) => {
    const [isAuthenticated, setIsAuthenticated] = useState(null);
    const [isLoading, setIsLoading] = useState(true);
    const [user, setUser] = useState(null);

    useEffect(() => {
        axios.interceptors.response.use(
            response => response,
            error => {
                let errMsg = error.response?.data.message || error.message;
                if (error.response?.status === 401) {
                    setIsAuthenticated(false);
                    setUser(null);
                }

                if (
                    error.response?.config.url !== 'auth/check' ||
                    error.response?.config.method !== 'get'
                ) {
                    toast.error(errMsg);
                }

                return Promise.reject(error);
            }
        );

        // initialize CSRF token https://laravel.com/docs/10.x/sanctum#csrf-protection
        axios
            .get(INIT_CSRF_URL)
            .then(() => {
                // check if user is authenticated
                checkAuth()
                    .then(({ data }) => {
                        setUser(data.data);
                        setIsAuthenticated(true);
                    })
                    .catch(() => {
                        setIsAuthenticated(false);
                        setUser(null);
                    });
            })
            .then(() => {
                setIsLoading(false);
            });
    }, []);

    const loginWithPassword = (identification, password, rememberMe) =>
        authLoginWithPassword(identification, password, rememberMe).then(
            ({ data }) => {
                setUser(data.data);
                setIsAuthenticated(true);
            }
        );
    const logout = async () => {};
    const register = (
        username,
        email,
        password,
        firstName,
        lastName,
        phoneNumber,
        dateOfBirth
    ) => {
        return authRegister(
            username,
            email,
            password,
            firstName,
            lastName,
            phoneNumber,
            dateOfBirth
        ).then(({ data }) => {
            setUser(data.data);
            setIsAuthenticated(true);
        });
    };

    if (isLoading || isAuthenticated === null) {
        return <FullLoader fullScreen size={150} />;
    }

    return (
        <AuthContext.Provider
            value={{
                user,
                login: loginWithPassword,
                logout,
                register,
                isAuthenticated,
            }}
        >
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => useContext(AuthContext);
