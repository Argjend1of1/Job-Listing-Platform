import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {patchRoleRequest} from "../reusableFunctions/fetchRequest.js";
import {updateCard} from "../reusableFunctions/cardUpdate.js";
import {showError} from "../reusableFunctions/alertUser.js";

document.addEventListener('DOMContentLoaded', async () => {
    document.querySelectorAll('#demoteEmployer')
        .forEach((button) => {
            button.addEventListener('click', async (e) => {
                e.preventDefault();
                console.log(e);
                const {employerId} = button.dataset;
                console.log(employerId);

                const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));
                const confirm = await confirmAction(
                    'Are you sure you want to demote this employer ?',
                    'Yes, demote!'
                );
                if(!confirm) return;

                try {
                    const response = await patchRoleRequest(
                        `/api/premiumEmployers/${employerId}`,
                        xsrfToken, 'employer'
                    );

                    const result = await response.json();
                    console.log(result);

                    if(!response.ok) {
                        throw result;
                    }

                    updateCard(
                        button, 'Demoted!', '.employer-card'
                    );
                }catch (err) {
                    showError(err.message);
                }
            })
        })
});
