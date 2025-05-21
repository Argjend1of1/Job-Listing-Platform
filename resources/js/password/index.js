import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {showError} from "../reusableFunctions/alertUser.js";

document.getElementById('forgotPasswordForm').addEventListener('submit', async function (e) {
    e.preventDefault();
    const email = e.target.email.value;
    const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

    try {
        const res = await fetch('/api/forgot-password', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': xsrfToken
            },
            body: JSON.stringify({ email })
        });

        const data = await res.json();
        console.log(data);
        if (!res.ok) {
            throw data;
        }

        localStorage.setItem('reset_email', data.email);
        localStorage.setItem('reset_token', data.token);
        document.getElementById('responseMessage').textContent = data.message;

        gotoRoute('/reset-password')

    }catch (e) {
        showError(e.message);
    }
});
