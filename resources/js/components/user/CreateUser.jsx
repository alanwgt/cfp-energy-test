import { useState } from 'react';

import { Visibility, VisibilityOff } from '@mui/icons-material';
import { IconButton, InputAdornment, Stack, TextField } from '@mui/material';
import { DatePicker } from '@mui/x-date-pickers';
import { useFormik } from 'formik';
import * as Yup from 'yup';

import LoadingButton from '../inputs/LoadingButton.jsx';

const initialState = {
    username: '',
    email: '',
    password: '',
    firstName: '',
    lastName: '',
    phoneNumber: '',
    dateOfBirth: '',
};

const signupSchema = Yup.object().shape({
    username: Yup.string().min(3).required().label('Username'),
    email: Yup.string().email().required().label('Email Address'),
    password: Yup.string().min(8).required().label('Password'),
    firstName: Yup.string().min(3).required().label('First Name'),
    lastName: Yup.string().min(3).required().label('Last Name'),
    phoneNumber: Yup.string().required().label('Phone Number'),
    dateOfBirth: Yup.date().required().label('Date of Birth'),
});

export default function CreateUser({ onCreate }) {
    const [showPassword, setShowPassword] = useState(false);
    const formik = useFormik({
        initialValues: initialState,
        validationSchema: signupSchema,
        onSubmit: (values, { setSubmitting }) => {
            onCreate(values).finally(() => setSubmitting(false));
        },
    });

    return (
        <form onSubmit={formik.handleSubmit}>
            <Stack spacing={2}>
                <TextField
                    label='Username'
                    name='username'
                    autoComplete='username'
                    required
                    fullWidth
                    value={formik.values.username}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.username &&
                        Boolean(formik.errors.username)
                    }
                    helperText={
                        formik.touched.username && formik.errors.username
                    }
                />
                <TextField
                    label='Email Address'
                    name='email'
                    autoComplete='email'
                    type='email'
                    required
                    fullWidth
                    value={formik.values.email}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={formik.touched.email && Boolean(formik.errors.email)}
                    helperText={formik.touched.email && formik.errors.email}
                />
                <TextField
                    name='password'
                    label='Password'
                    type={showPassword ? 'text' : 'password'}
                    autoComplete='new-password'
                    required
                    fullWidth
                    value={formik.values.password}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.password &&
                        Boolean(formik.errors.password)
                    }
                    helperText={
                        formik.touched.password && formik.errors.password
                    }
                    InputProps={{
                        endAdornment: (
                            <InputAdornment position='end'>
                                <IconButton
                                    tabIndex={-1}
                                    aria-label='toggle password visibility'
                                    onClick={() =>
                                        setShowPassword(show => !show)
                                    }
                                >
                                    {showPassword ? (
                                        <VisibilityOff />
                                    ) : (
                                        <Visibility />
                                    )}
                                </IconButton>
                            </InputAdornment>
                        ),
                    }}
                />
                <TextField
                    label='First Name'
                    name='firstName'
                    autoComplete='given-name'
                    required
                    fullWidth
                    value={formik.values.firstName}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.firstName &&
                        Boolean(formik.errors.firstName)
                    }
                    helperText={
                        formik.touched.firstName && formik.errors.firstName
                    }
                />
                <TextField
                    label='Last Name'
                    name='lastName'
                    autoComplete='family-name'
                    required
                    fullWidth
                    value={formik.values.lastName}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.lastName &&
                        Boolean(formik.errors.lastName)
                    }
                    helperText={
                        formik.touched.lastName && formik.errors.lastName
                    }
                />
                <TextField
                    label='Phone Number'
                    name='phoneNumber'
                    autoComplete='tel'
                    type='tel'
                    required
                    fullWidth
                    value={formik.values.phoneNumber}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.phoneNumber &&
                        Boolean(formik.errors.phoneNumber)
                    }
                    helperText={
                        formik.touched.phoneNumber && formik.errors.phoneNumber
                    }
                />
                <DatePicker
                    name='dateOfBirth'
                    label='Date of Birth'
                    required
                    fullWidth
                    slotProps={{ textField: { fullWidth: true } }}
                    value={formik.values.dateOfBirth}
                    onChange={value =>
                        formik.setFieldValue('dateOfBirth', value)
                    }
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.dateOfBirth &&
                        Boolean(formik.errors.dateOfBirth)
                    }
                    helperText={
                        formik.touched.dateOfBirth && formik.errors.dateOfBirth
                    }
                />
                <LoadingButton
                    loading={formik.isSubmitting}
                    type='submit'
                    fullWidth
                    variant='contained'
                    sx={{ mt: 3, mb: 2 }}
                >
                    Sign Up
                </LoadingButton>
            </Stack>
        </form>
    );
}
