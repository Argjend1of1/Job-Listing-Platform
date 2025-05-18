import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {deleteRequest, patchRequest} from "../reusableFunctions/fetchRequest.js";
// update+delete
document.addEventListener('DOMContentLoaded', () => {
    async function waitForForm() {
        const editAccount = document.getElementById('editAccountForm');
        const deleteAccount = document.getElementById('deleteAccount');
        if (!editAccount) {
            return requestAnimationFrame(waitForForm);
        }

        editAccount.addEventListener('submit', async (e) => {
            e.preventDefault();

            // 2) collect form data
            const formData = new FormData(editAccount);
            const data = Object.fromEntries(formData.entries());
            console.log(data);

            // 3) extract the token from the cookie
            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            const confirm = await confirmAction(
                'Are you sure you want to update your account ?',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            try {
                const response =  await patchRequest(
                    '/api/account/edit', xsrfToken, data
                );

                if (!response.ok) {
                    const error = await response.json().catch(() => ({}));
                    throw new Error(error.message || `HTTP ${response.status}`);
                }

                const result = await response.json();
                console.log('Update result:', result);

                const userMessage = document.getElementById('userMessage');
                userMessage.innerHTML = result.message;

                gotoRoute('/account')
            } catch (err) {
                console.error('Update failed:', err);
                alert(err.message || 'Failed to update the job.');
            }
        });

        deleteAccount.addEventListener('click', async (e) => {
            e.preventDefault();
            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));
            const confirm = await confirmAction(
                'Are you sure you want to remove your account ?',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            try {
                const response = await deleteRequest(
                    `/api/account/edit`, xsrfToken
                )

                if (!response.ok) {
                    const error = await response.json().catch(() => ({}));
                    throw new Error(error.message || `HTTP ${response.status}`);
                }

                const result = await response.json();
                console.log('Delete result:', result);

                const userMessage = document.getElementById('userMessage');
                userMessage.innerHTML = result.message;

                gotoRoute('/');
            }catch (err) {
                console.log(err);
            }
        })
    }

    waitForForm();
});
