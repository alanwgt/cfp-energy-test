import { Suspense } from 'react';

import { QueryErrorResetBoundary } from '@tanstack/react-query';
import { ErrorBoundary } from 'react-error-boundary';

import Exception from '../feedback/Exception.jsx';
import Loading from '../feedback/Loading.jsx';

export default function withSuspenseAndErrorHandling(WrappedComponent) {
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
