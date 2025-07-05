export function showSuccess(message = 'Success!', timer = 3000) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}

export function showError(message = 'Something went wrong.', timer = 3000) {
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}

export function showInfo(message = '', timer = 3000) {
    Swal.fire({
        icon: 'info',
        title: 'Info',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}
