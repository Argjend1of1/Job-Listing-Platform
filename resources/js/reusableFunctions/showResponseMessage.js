export function showResponseMessage(response, result) {
    response.textContent = result.message;

    setTimeout(() => {
        response.textContent = '';
    }, 1300)
}



