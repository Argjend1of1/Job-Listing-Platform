export function showSuccess(message = 'Success!') {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

export function showError(message = 'Something went wrong.') {
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}

export function showInfo(message = '') {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: message,
        timer: 3000,
        showConfirmButton: false
    });
}
