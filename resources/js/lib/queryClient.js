import { QueryClient } from '@tanstack/react-query';

export default new QueryClient({
    defaultOptions: {
        queries: {
            refetchOnMount: true,
            refetchOnWindowFocus: false,
            refetchOnReconnect: false,
            staleTime: 2 * 1000, // em ms
            retry: false,
        },
        mutations: {
            retry: false,
        },
    },
});
