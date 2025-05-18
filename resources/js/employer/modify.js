import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {deleteRequest, patchRoleRequest} from "../reusableFunctions/fetchRequest.js";
import {updateCard} from "../reusableFunctions/cardUpdate.js";
import {showError} from "../reusableFunctions/alertUser.js";

document.addEventListener("DOMContentLoaded", async () => {
    document.querySelectorAll('#deleteEmployer')
        .forEach((button) => {
            // needed for identifying on which company it's pressed
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                const {employerId} = button.dataset;
                console.log(employerId);
                if(!employerId) {
                    console.error('Employer ID not found.');
                    return;
                }

                const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

                const confirm = await confirmAction(
                    "Do you really want to remove this employer?",
                    'Yes, remove him!'
                );
                if (!confirm) return;

                try {
                    const response = await deleteRequest(
                        `api/employers/${employerId}`, xsrfToken
                    );

                    const result = await response.json();

                    if (!response.ok) {
                        showError(result.message);
                    }

                    updateCard(
                        button, 'Removed!', '.employer-card'
                    );
                }catch (err) {
                    showError(err.message);
                }
            })
        })

    document.querySelectorAll('#promoteEmployer').forEach((button)=> {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const {userId} = button.dataset;
            console.log(userId);

            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'))

            const confirm = await confirmAction(
                'Do you really want to promote this employer ?',
                'Yes, Promote!'
            );
            if(!confirm) return;

            try {
                const response = await patchRoleRequest(
                    `/api/employers/${userId}`, xsrfToken, 'superEmployer'
                );
                const result = await response.json();

                if (!response.ok) {
                    throw result
                }

                updateCard(
                    button, 'Promoted!', '.employer-card'
                );
            }catch (err) {
                showError(err.message);
            }
        })
    })
})
