import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {showResponseMessage} from "../reusableFunctions/showResponseMessage.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
// update+delete
document.addEventListener('DOMContentLoaded', () => {
    const jobId = window.location.pathname.split('/').pop();

    const editForm = document.getElementById('editJobForm');
    const deleteListing = document.getElementById('deleteListing');

    // validate with just-validate then proceed with confirmAction pop up

    editForm.addEventListener('submit', async (e) => {
        e.preventDefault();

        // 2) collect form data
        const formData = new FormData(editForm);
        const data = Object.fromEntries(formData.entries());

        // 3) extract the token from the cookie
        const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

        const confirm = await confirmAction(
            'Are you sure you want to update this job ?',
            'Yes, I am sure!'
        );
        if(!confirm) return;

        try {
            const response = await fetch(`/api/dashboard/edit/${jobId}`, {
                method: 'PATCH',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                body: JSON.stringify(data),
            });


            const result = await response.json();
            console.log('Update result:', result);

            const responseToUser =
                document.getElementById('responseMessage');

            if(result.message !== 'Job updated successfully!') {
                showResponseMessage(responseToUser, result);
            } else {
                responseToUser.classList.remove('text-red-500');
                responseToUser.classList.add('text-green-500');
                showResponseMessage(responseToUser, result);
            }

            if (!response.ok) throw result;

            gotoRoute('/dashboard');
        } catch (err) {
            console.error('Update failed:', err);
            alert(err.message || 'Failed to update the job.');
        }
    });

    deleteListing.addEventListener('click', async (e) => {
        e.preventDefault();
        const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

        const confirm = await confirmAction(
            'Are you sure you want to delete this listing ?',
            'Yes, I am sure!'
        );
        if(!confirm) return;

        try {
            const response = await fetch(`/api/dashboard/edit/${jobId}`, {
                method: 'DELETE',
                credentials:'include',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                }
            });
            const result = await response.json();

            const responseToUser =
                document.getElementById('responseMessage');

            if(result.message !== 'Listing deleted successfully!') {
                showResponseMessage(responseToUser, result);
            } else {
                responseToUser.classList.remove('text-red-500');
                responseToUser.classList.add('text-green-500');
                showResponseMessage(responseToUser, result);
            }
            if (!response.ok) throw result;

            gotoRoute('/dashboard');
        }catch (err) {
            console.log(err);
        }
    });
});
