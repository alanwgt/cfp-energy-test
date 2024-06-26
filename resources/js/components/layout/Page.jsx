import { Breadcrumbs, ButtonGroup, Container, Stack } from '@mui/material';
import Box from '@mui/material/Box';
import Button from '@mui/material/Button';
import Typography from '@mui/material/Typography';
import { Link } from 'react-router-dom';

export default function Page({
    title,
    children,
    breadcrumbs = [],
    actions = [],
}) {
    const computedBreadcrumbs = [{ to: '/', label: 'Home' }, ...breadcrumbs];

    return (
        <Container my={2}>
            <Stack my={2} spacing={2}>
                <Stack
                    direction='row'
                    justifyContent='space-between'
                    alignItems='center'
                >
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
                    {actions.length > 0 && (
                        <ButtonGroup>
                            {actions.map(({ label, ...buttonProps }, index) => (
                                <Button key={index} {...buttonProps}>
                                    {label}
                                </Button>
                            ))}
                        </ButtonGroup>
                    )}
                </Stack>
                {title && <Typography variant='h4'>{title}</Typography>}
                <Box>{children}</Box>
            </Stack>
        </Container>
    );
}
