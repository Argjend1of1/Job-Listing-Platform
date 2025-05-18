import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {showResponseMessage} from "../reusableFunctions/showResponseMessage.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {showError} from "../reusableFunctions/alertUser.js";

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('uploadResumeForm');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);
        const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

        try {
            const response = await fetch('/api/resume', {
                method: 'POST',
                credentials:'include',
                headers: {
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                body: formData
            });
            const result = await response.json();

            const responseToUser =
                document.getElementById('responseMessage');
            if(result.message !== 'Resume Uploaded Successfully!') {
                showResponseMessage(responseToUser, result);
            } else {
                responseToUser.classList.remove('text-red-500');
                responseToUser.classList.add('text-green-500');
                showResponseMessage(responseToUser, result);
            }

            if (!response.ok) throw result;

            gotoRoute('/');
        } catch (error) {
            showError(error.message)
        }
    });
});
