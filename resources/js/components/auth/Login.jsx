import { Checkbox, FormControlLabel, Stack, TextField } from '@mui/material';
import Typography from '@mui/material/Typography';
import { useFormik } from 'formik';
import * as Yup from 'yup';

import { useAuth } from '../../context/AuthContext.jsx';
import LoadingButton from '../inputs/LoadingButton.jsx';

const initialState = {
    email: '',
    password: '',
    rememberMe: false,
};

const loginSchema = Yup.object().shape({
    email: Yup.string().email().required(),
    password: Yup.string().required(),
    rememberMe: Yup.boolean(),
});

export default function Login() {
    const { login } = useAuth();
    const formik = useFormik({
        initialValues: initialState,
        validationSchema: loginSchema,
        onSubmit: ({ email, password, rememberMe }, { setSubmitting }) => {
            login(email, password, rememberMe).finally(() =>
                setSubmitting(false)
            );
        },
    });

    return (
        <form onSubmit={formik.handleSubmit}>
            <Stack spacing={2}>
                <TextField
                    required
                    fullWidth
                    label='Email Address'
                    name='email'
                    autoComplete='email'
                    value={formik.values.email}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={formik.touched.email && Boolean(formik.errors.email)}
                    helperText={formik.touched.email && formik.errors.email}
                />
                <TextField
                    required
                    fullWidth
                    name='password'
                    label='Password'
                    type='password'
                    autoComplete='current-password'
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
                />
                <FormControlLabel
                    control={
                        <Checkbox
                            name='rememberMe'
                            type='checkbox'
                            checked={formik.values.rememberMe}
                            onChange={formik.handleChange}
                            onBlur={formik.handleBlur}
                        />
                    }
                    label={
                        <Typography variant='subtitle1'>Remember-me</Typography>
                    }
                />
                <LoadingButton
                    loading={formik.isSubmitting}
                    type='submit'
                    fullWidth
                    variant='contained'
                    sx={{ mt: 3, mb: 2 }}
                >
                    Sign In
                </LoadingButton>
            </Stack>
        </form>
    );
}
