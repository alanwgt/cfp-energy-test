import { Checkbox, FormControlLabel, Stack, TextField } from '@mui/material';
import Typography from '@mui/material/Typography';
import { useFormik } from 'formik';
import * as Yup from 'yup';

import { useAuth } from '../../context/AuthContext.jsx';
import LoadingButton from '../inputs/LoadingButton.jsx';

const initialState = {
    identification: '',
    password: '',
    rememberMe: false,
};

const loginSchema = Yup.object().shape({
    identification: Yup.string().min(3).required(),
    password: Yup.string().min(8).required(),
    rememberMe: Yup.boolean(),
});

export default function Login() {
    const { login } = useAuth();
    const formik = useFormik({
        initialValues: initialState,
        validationSchema: loginSchema,
        onSubmit: (
            { identification, password, rememberMe },
            { setSubmitting }
        ) => {
            login(identification, password, rememberMe).finally(() =>
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
                    label='Email Address/Username'
                    name='identification'
                    autoComplete='username'
                    value={formik.values.identification}
                    onChange={formik.handleChange}
                    onBlur={formik.handleBlur}
                    error={
                        formik.touched.identification &&
                        Boolean(formik.errors.identification)
                    }
                    helperText={
                        formik.touched.identification &&
                        formik.errors.identification
                    }
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
