import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {patchRoleRequest} from "../reusableFunctions/fetchRequest.js";
import {updateCard} from "../reusableFunctions/cardUpdate.js";
import {showError} from "../reusableFunctions/alertUser.js";

document.addEventListener("DOMContentLoaded", async () => {
    document.querySelectorAll('#demoteAdmin')
        .forEach((button) => {
            // needed for identifying on which company it's pressed
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const {adminId} = button.dataset;
                if(!adminId) {
                    console.error('Admin ID not found.');
                    return;
                }

                const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

                const confirm = await confirmAction(
                    "Do you really want to demote this admin?",
                    'Yes, demote him!'
                );
                if (!confirm) return;

                try {
                    const response = await patchRoleRequest(
                        `/api/admins/${adminId}`, xsrfToken, 'user'
                    );
                    console.log(response);

                    const result = await response.json()
                    console.log(result);

                    if (!response.ok) {
                        throw result;
                    }

                    updateCard(button, 'Demoted!', '.admin-card');
                }catch (err) {
                    showError(err.message || 'Unexpected Error. Please try again!');
                }
            })
        })
})
