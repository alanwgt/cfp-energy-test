import { useSuspenseQuery } from '@tanstack/react-query';

import withSuspenseAndErrorHandling from './withSuspenseAndErrorHandling.jsx';

export default function withRemoteData(queryFn, queryKey) {
    return function withRemoteDataWrapped(WrappedComponent) {
        const handler = function QueryHandler(props) {
            if (typeof queryKey === 'function') {
                queryKey = queryKey(props);
            }

            const { data } = useSuspenseQuery({ queryKey, queryFn });

            return <WrappedComponent {...props} data={data.data} />;
        };

        return withSuspenseAndErrorHandling(handler);
    };
}
