import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {patchRoleRequest} from "../reusableFunctions/fetchRequest.js";
import {showError} from "../reusableFunctions/alertUser.js";
import {updateCard} from "../reusableFunctions/cardUpdate.js";

document.addEventListener("DOMContentLoaded", async () => {
    document.querySelectorAll('#promoteUser')
        .forEach((button) => {
            // needed for identifying on which company it's pressed
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const {userId} = button.dataset;
                if(!userId) {
                    console.error('Employer ID not found.');
                    return;
                }

                const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

                const confirm = await confirmAction(
                    "Do you really want to promote this user ?",
                    'Yes, promote him!'
                );
                if (!confirm) return;

                try {
                    const response = await patchRoleRequest(
                        `/api/admins/create/${userId}`, xsrfToken, 'admin'
                    );

                    const result = await response.json();
                    console.log(result);

                    if (!response.ok) {
                        showError(result.message);
                    }
                    updateCard(button, 'Promoted!', '.user-card');
                }catch (err) {
                    showError( err.message || 'Something went wrong.')
                }
            })
        })
})
