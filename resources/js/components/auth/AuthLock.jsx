import { useAuth } from '../../context/AuthContext.jsx';
import Auth from '../../pages/Auth.jsx';

export default function AuthLock({ children }) {
    const { isAuthenticated } = useAuth();

    if (isAuthenticated) {
        return children;
    }

    return <Auth />;
}
