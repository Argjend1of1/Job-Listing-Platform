export function gotoRoute(route, timeout = 1000) {
    setTimeout(() => {
        window.location.href = route;
    }, timeout);
}
