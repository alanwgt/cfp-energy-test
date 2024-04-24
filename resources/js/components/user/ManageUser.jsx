import { useState } from 'react';

import { Visibility, VisibilityOff } from '@mui/icons-material';
import { IconButton, InputAdornment, TextField } from '@mui/material';
import Grid2 from '@mui/material/Unstable_Grid2';
import { DatePicker } from '@mui/x-date-pickers';
import { useMutation } from '@tanstack/react-query';
import { useFormik } from 'formik';
import * as Yup from 'yup';

import { createUser, updateUser } from '../../api/usersApi.js';
import toast from '../../lib/toast.js';
import LoadingButton from '../inputs/LoadingButton.jsx';

const initialState = {
    username: '',
    email: '',
    password: '',
    first_name: '',
    last_name: '',
    phone_number: '',
    date_of_birth: new Date(),
    authentication_method: 'password',
};

const signupSchema = Yup.object().shape({
    username: Yup.string().min(3).required().label('Username'),
    email: Yup.string().email().required().label('Email Address'),
    password: Yup.string()
        .min(8)
        .label('Password')
        .when('id', (id, schema) => (id ? schema : schema.required())),
    first_name: Yup.string().min(3).required().label('First Name'),
    last_name: Yup.string().min(3).required().label('Last Name'),
    phone_number: Yup.string().required().label('Phone Number'),
    date_of_birth: Yup.date().required().label('Date of Birth'),
});

function Cell({ children }) {
    return (
        <Grid2 xs={12} md={6}>
            {children}
        </Grid2>
    );
}

export default function ManageUser({ initialValues = null, mutationFn }) {
    const isInEditMode = Boolean(initialValues?.id);
    const [showPassword, setShowPassword] = useState(false);
    const mutation = useMutation({
        mutationFn,
        mutationKey: ['users', initialValues?.id],
    });
    const formik = useFormik({
        initialValues: initialValues || initialState,
        validationSchema: signupSchema,
        onSubmit: (values, { setSubmitting }) => {
            mutation.mutate(values, {
                onSettled: () => setSubmitting(false),
                onSuccess: () => {
                    toast.success('Success!');
                },
            });
        },
    });

    return (
        <form onSubmit={formik.handleSubmit}>
            <input
                type='hidden'
                name='authentication_method'
                value='password'
            />
            <Grid2 container spacing={2}>
                <Cell>
                    <TextField
                        label='Username'
                        name='username'
                        autoComplete='username'
                        fullWidth
                        value={formik.values.username}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        disabled={isInEditMode}
                        error={
                            formik.touched.username &&
                            Boolean(formik.errors.username)
                        }
                        helperText={
                            (formik.touched.username &&
                                formik.errors.username) ||
                            (isInEditMode && 'Cannot change username')
                        }
                    />
                </Cell>
                <Cell>
                    <TextField
                        label='Email Address'
                        name='email'
                        autoComplete='email'
                        type='email'
                        fullWidth
                        value={formik.values.email}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        error={
                            formik.touched.email && Boolean(formik.errors.email)
                        }
                        helperText={formik.touched.email && formik.errors.email}
                    />
                </Cell>
                <Cell>
                    <TextField
                        name='password'
                        label='Password'
                        type={showPassword ? 'text' : 'password'}
                        autoComplete='new-password'
                        fullWidth
                        value={formik.values.password}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        error={
                            formik.touched.password &&
                            Boolean(formik.errors.password)
                        }
                        helperText={
                            (formik.touched.password &&
                                formik.errors.password) ||
                            (isInEditMode &&
                                'Leave blank to keep the same password')
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
                </Cell>
                <Cell>
                    <TextField
                        label='First Name'
                        name='first_name'
                        autoComplete='given-name'
                        fullWidth
                        value={formik.values.first_name}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        error={
                            formik.touched.first_name &&
                            Boolean(formik.errors.first_name)
                        }
                        helperText={
                            formik.touched.first_name &&
                            formik.errors.first_name
                        }
                    />
                </Cell>
                <Cell>
                    <TextField
                        label='Last Name'
                        name='last_name'
                        autoComplete='family-name'
                        fullWidth
                        value={formik.values.last_name}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        error={
                            formik.touched.last_name &&
                            Boolean(formik.errors.last_name)
                        }
                        helperText={
                            formik.touched.last_name && formik.errors.last_name
                        }
                    />
                </Cell>
                <Cell>
                    <TextField
                        label='Phone Number'
                        name='phone_number'
                        autoComplete='tel'
                        type='tel'
                        fullWidth
                        value={formik.values.phone_number}
                        onChange={formik.handleChange}
                        onBlur={formik.handleBlur}
                        error={
                            formik.touched.phone_number &&
                            Boolean(formik.errors.phone_number)
                        }
                        helperText={
                            formik.touched.phone_number &&
                            formik.errors.phone_number
                        }
                    />
                </Cell>
                <Cell>
                    <DatePicker
                        name='date_of_birth'
                        label='Date of Birth'
                        fullWidth
                        slotProps={{ textField: { fullWidth: true } }}
                        value={formik.values.date_of_birth}
                        onChange={value =>
                            formik.setFieldValue('dateOfBirth', value)
                        }
                        onBlur={formik.handleBlur}
                        error={
                            formik.touched.date_of_birth &&
                            Boolean(formik.errors.date_of_birth)
                        }
                        helperText={
                            formik.touched.date_of_birth &&
                            formik.errors.date_of_birth
                        }
                    />
                </Cell>
                <Grid2 xs={12}>
                    <LoadingButton
                        loading={formik.isSubmitting}
                        type='submit'
                        fullWidth
                        variant='contained'
                        sx={{ mt: 3, mb: 2 }}
                    >
                        {initialValues ? 'Save' : 'Sign Up'}
                    </LoadingButton>
                </Grid2>
            </Grid2>
        </form>
    );
}
