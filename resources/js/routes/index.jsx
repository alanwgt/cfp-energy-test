import { Route, Routes } from 'react-router-dom';

import HomePage from '../pages/HomePage.jsx';
import ListUsersPage from '../pages/ListUsersPage.jsx';
import ManageUserPage from '../pages/ManageUserPage.jsx';
import UserProfilePage from '../pages/UserProfilePage.jsx';
import ViewUserPage from '../pages/ViewUserPage.jsx';

export default function AppRoutes() {
    return (
        <Routes>
            <Route path='/' element={<HomePage />} />
            <Route path='/profile' element={<UserProfilePage />} />

            <Route path='users'>
                <Route index element={<ListUsersPage />} />
                <Route path=':id' element={<ViewUserPage />} />
                <Route path=':id/edit' element={<ManageUserPage />} />
                <Route path='/users/new' element={<ManageUserPage />} />
            </Route>
        </Routes>
    );
}
