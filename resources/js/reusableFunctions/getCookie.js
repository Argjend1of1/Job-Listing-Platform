export function getCookieValue(name) {
    const cookie = document.cookie
        .split('; ')
        .find(row => row.startsWith(name + '='));
    return cookie ? cookie.split('=')[1] : null;
}
