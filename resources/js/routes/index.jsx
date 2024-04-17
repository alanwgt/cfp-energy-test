import { BrowserRouter, Route, Routes } from 'react-router-dom';

import Home from '../pages/Home.jsx';

export default function AppRoutes() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path='/' element={<Home />} />
            </Routes>
        </BrowserRouter>
    );
}
