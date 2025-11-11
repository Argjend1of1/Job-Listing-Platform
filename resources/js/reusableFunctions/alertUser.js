import Swal from "sweetalert2";
import {router} from "@inertiajs/react";

export function showSuccess(
    message = 'Success!', timer = 3000
) {
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}

export function showError(
    message = 'Something went wrong.', timer = 3000
) {
    Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: message,
        timer: timer,
        showConfirmButton: false
    });
}

export async function showInfo(
    message = '',
    showConfirmButton = false,
    showCancelButton = false,
    confirmButtonText = '',
) {
    return await Swal.fire({
        icon: 'info',
        title: 'Info',
        text: message,
        showConfirmButton: showConfirmButton,
        showCancelButton: showCancelButton,
        confirmButtonText: confirmButtonText,
    });

}

export async function showWarning(title, message, confirmationText) {
    const result = await Swal.fire({
        icon: "warning",
        title: title,
        text: message,
        showCancelButton: true,
        confirmButtonText: confirmationText,
    });

    if (result.isConfirmed) {
        router.visit("/login");
    }
}
