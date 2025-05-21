import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {showError} from "../reusableFunctions/alertUser.js";

document.addEventListener('DOMContentLoaded', async () => {
    const email = localStorage.getItem('reset_email');
    const token = localStorage.getItem('reset_token');
    if (!token || !email) {
        gotoRoute('/', 0);
    }

    document.getElementById('resetPasswordForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        const form = e.target;

        const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

        document.getElementById('resetEmail').value = email;
        document.getElementById('resetToken').value = token;

        const passwordInput = form.querySelector('input[name="password"]');
        const confirmPasswordInput = form.querySelector('input[name="password_confirmation"]');

        const password = form.password.value;
        const password_confirmation = form.password_confirmation.value;

        try {
            const res = await fetch('/api/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-XSRF-TOKEN': xsrfToken
                },
                body: JSON.stringify({
                    token,
                    email,
                    password,
                    password_confirmation
                })
            });

            const data = await res.json();
            const responseToUser = document.getElementById('responseMessage');

            if (!res.ok) {
                passwordInput.value = '';
                confirmPasswordInput.value = '';
                throw data;
            }
            console.log(data);

            localStorage.removeItem('reset_email');
            localStorage.removeItem('reset_token');
            responseToUser.textContent = "Password reset successful. You can now log in.";

            gotoRoute('/login', 3000)
        }catch (e) {
            showError(e.message)
        }
    });
})
