export function getAllowedRoles(role) {
    switch (role) {
        case 'admin':
            return ['user', 'manager'];
        case 'manager':
            return ['user'];
        default:
            return [];
    }
}
