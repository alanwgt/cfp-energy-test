import { useSuspenseQuery } from '@tanstack/react-query';
import { useParams } from 'react-router-dom';

import withSuspenseAndErrorHandling from './withSuspenseAndErrorHandling.jsx';

export default function withRemoteData(queryFn, queryKey) {
    return function withRemoteDataWrapped(WrappedComponent) {
        const handler = function QueryHandler(props) {
            if (typeof queryKey === 'function') {
                queryKey = queryKey(props);
            }

            const params = useParams();

            const { data } = useSuspenseQuery({
                queryKey: [...queryKey, ...Object.values(params)],
                queryFn: () => queryFn({ ...params }),
            });

            return <WrappedComponent {...props} data={data.data?.data} />;
        };

        return withSuspenseAndErrorHandling(handler);
    };
}
