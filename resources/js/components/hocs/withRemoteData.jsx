import { useEffect, useState } from 'react';

import { useSuspenseQuery } from '@tanstack/react-query';
import { useParams } from 'react-router-dom';

import withSuspenseAndErrorHandling from './withSuspenseAndErrorHandling.jsx';

export default function withRemoteData(
    queryFn,
    queryKey,
    useURLParams = false
) {
    return function withRemoteDataWrapped(WrappedComponent) {
        const handler = function QueryHandler(props) {
            if (typeof queryKey === 'function') {
                queryKey = queryKey(props);
            }

            const params = useParams();
            const [queryK, setQueryK] = useState(queryKey);

            useEffect(() => {
                if (useURLParams) {
                    setQueryK(k => [...k, ...Object.values(params)]);
                }
            }, [params]);

            const { data } = useSuspenseQuery({
                queryK,
                queryFn: () => queryFn({ ...params }),
            });

            return <WrappedComponent {...props} data={data.data?.data} />;
        };

        return withSuspenseAndErrorHandling(handler);
    };
}
