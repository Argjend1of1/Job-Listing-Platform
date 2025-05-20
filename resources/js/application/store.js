import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {showError, showSuccess} from "../reusableFunctions/alertUser.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";

document.addEventListener('DOMContentLoaded', async () => {
    const applyButton = document.getElementById('applyButton');

    const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

    if(applyButton) {
        applyButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const {jobId} = applyButton.dataset;
            console.log(jobId);

            const confirm = await confirmAction(
                'Are you sure you want to apply for this job ?',
                'Yes, I am sure!'
            )
            if(!confirm) return;

            try {
                const response = await fetch(`/api/jobs/${jobId}/apply`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    }
                });
                console.log(response);
                const result = await response.json();
                console.log(result);

                if(result.message === 'You need to be logged in to apply for this job!') {
                    gotoRoute('/login', 3000)
                }
                if(result.message === 'Please upload your resume before applying!') {
                    gotoRoute('/resume', 3000)
                }
                if(!response.ok) {
                    showError(result.message)
                    return;
                }

                showSuccess(result.message || "Applied Successfully!");
                gotoRoute('/', 3000);
            }catch (e) {
                showError(e.message || 'Unexpected Error!');
            }
        })
    }
})
