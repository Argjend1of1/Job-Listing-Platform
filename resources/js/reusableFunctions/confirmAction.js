import Swal from "sweetalert2";

export async function confirmAction(text, confirmButtonText) {
    const result = await Swal.fire({
        title: 'Are you sure?',
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmButtonText
    });

    return result.isConfirmed; // boolean
}
