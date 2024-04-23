import { Breadcrumbs, Stack } from '@mui/material';
import { Link } from 'react-router-dom';

export default function Page({ title, children, breadcrumbs = [] }) {
    const computedBreadcrumbs = [{ to: '/', label: 'Home' }, ...breadcrumbs];

    return (
        <Stack my={2} spacing={2}>
            {breadcrumbs.length > 0 && (
                <Breadcrumbs>
                    {computedBreadcrumbs.map(breadcrumb => (
                        <Link
                            to={breadcrumb.to ?? '#'}
                            key={breadcrumb.to ?? '#'}
                        >
                            {breadcrumb.label}
                        </Link>
                    ))}
                </Breadcrumbs>
            )}
            {children}
        </Stack>
    );
}
