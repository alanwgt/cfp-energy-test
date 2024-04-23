import { useEffect, useState } from 'react';

import { Backdrop, Container, Pagination, Stack } from '@mui/material';
import Box from '@mui/material/Box';
import { useQuery } from '@tanstack/react-query';

import Exception from '../feedback/Exception.jsx';
import Loading from '../feedback/Loading.jsx';

export default function withRemotePaginated(queryFn, queryKey) {
    return function withRemotePaginatedWrapper(WrappedComponent) {
        function generateQueryKey({ page, filters }) {
            if (!Array.isArray(queryKey)) {
                queryKey = [queryKey];
            }
            return [...queryKey, page, JSON.stringify(filters)];
        }

        return function DataHandler(props) {
            const [page, setPage] = useState(1);
            const [lastPage, setLastPage] = useState(1);
            const [filters, setFilters] = useState({});

            const { data, isLoading, error, isError } = useQuery({
                queryKey: generateQueryKey({ page, filters }),
                queryFn: () => queryFn({ ...props, page, filters }),
            });

            useEffect(() => {
                if (data) {
                    setLastPage(data.data.meta.last_page);
                }
            }, [data]);

            const Component = isError ? (
                <Exception error={error} />
            ) : (
                <WrappedComponent
                    filter={filters}
                    setFilters={setFilters}
                    data={data?.data ?? { data: [] }}
                    {...props}
                />
            );

            return (
                <Stack sx={{ height: '100%' }}>
                    <Backdrop
                        open={isLoading}
                        sx={{ zIndex: theme => theme.zIndex.drawer + 1 }}
                    >
                        <Loading size={64} />
                    </Backdrop>
                    <Box sx={{ flex: 1 }}>{Component}</Box>
                    <Container sx={{ width: '100%' }}>
                        <Pagination
                            count={lastPage}
                            page={page}
                            color='primary'
                            variant='outlined'
                            onChange={(evt, page) => setPage(page)}
                            sx={{
                                mb: 2,
                                display: 'flex',
                                justifyContent: 'flex-end',
                            }}
                        />
                    </Container>
                </Stack>
            );
        };
    };
}
