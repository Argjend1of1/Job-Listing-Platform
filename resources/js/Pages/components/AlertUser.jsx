import Swal from "sweetalert2";
const AlertUser = ({type = 'success', message, timer = 3000}) => {
    if(type === 'success') {
        return Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            timer: timer,
            showConfirmButton: false
        })
    }else if(type === 'error') {
        return Swal.fire({
            icon: 'error',
            title: 'Oops!',
            text: message,
            timer: timer,
            showConfirmButton: false
        });
    }else if(type === 'info') {
        return Swal.fire({
            icon: 'info',
            title: 'Info',
            text: message,
            timer: timer,
            showConfirmButton: false
        });
    }else {
        console.warn('Please select from 1-3.')
    }
}

export default AlertUser
