export function handleDateProp(obj, prop) {
    if (Array.isArray(prop)) {
        prop.forEach(p => handleDateProp(obj, p));
        return obj;
    }

    const propParts = prop.split('.');

    let currentLevel = obj;
    for (let i = 0; i < propParts.length - 1; i++) {
        if (!currentLevel[propParts[i]]) {
            return obj;
        }
        currentLevel = currentLevel[propParts[i]];
    }

    const finalProp = propParts[propParts.length - 1];
    const date = currentLevel[finalProp];

    if (date) {
        currentLevel[finalProp] = new Date(date);
    }

    return obj;
}
