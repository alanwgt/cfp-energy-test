import { Suspense } from 'react';

import {
    QueryErrorResetBoundary,
    useSuspenseQuery,
} from '@tanstack/react-query';
import { ErrorBoundary } from 'react-error-boundary';

import Exception from '../feedback/Exception.jsx';
import Loading from '../feedback/Loading.jsx';

export function withSuspenseAndErrorHandling(WrappedComponent) {
    return function ErrorBoundaryWrapper(props) {
        return (
            <QueryErrorResetBoundary>
                {({ reset }) => (
                    <ErrorBoundary onReset={reset} fallbackRender={Exception}>
                        <Suspense fallback={<Loading />}>
                            <WrappedComponent {...props} />
                        </Suspense>
                    </ErrorBoundary>
                )}
            </QueryErrorResetBoundary>
        );
    };
}

export default function withRemoteData(queryFn, queryKey) {
    return function withRemoteDataWrapped(WrappedComponent) {
        const handler = function QueryHandler(props) {
            const { data } = useSuspenseQuery({ queryKey, queryFn });

            return <WrappedComponent {...props} data={data.data} />;
        };

        return withSuspenseAndErrorHandling(handler);
    };
}
