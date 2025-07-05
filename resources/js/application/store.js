import {confirmAction} from "../reusableFunctions/confirmAction.js";
import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {showError, showInfo, showSuccess} from "../reusableFunctions/alertUser.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {deleteRequest} from "../reusableFunctions/fetchRequest.js";

document.addEventListener('DOMContentLoaded', async () => {
    const applyButton = document.getElementById('applyButton');
    const bookmarkButton = document.getElementById('bookmarkButton');
    const removeBookmark = document.getElementById('removeBookmark');
    const reportButton = document.getElementById('reportButton');
    const deleteButton = document.getElementById('deleteButton');

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

    if(bookmarkButton) {
        bookmarkButton.addEventListener('click', async () => {
            const {jobId} = bookmarkButton.dataset;
            console.log(jobId);

            const confirm = await confirmAction(
                'Are you sure you want to bookmark this job ?',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            try {
                const response = await fetch(`/api/jobs/${jobId}/bookmark`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    }
                });
                const result = await response.json();
                console.log(result);
                if(!response.ok) {
                    throw result;
                }

                showSuccess(result.message);
                gotoRoute('/', 3000)
            }catch (e){
                showError(e.message || 'Something went wrong.');
                gotoRoute('/bookmarks', 3000)
            }
        })
    }

    if(removeBookmark) {
        removeBookmark.addEventListener('click', async () => {
            const {jobId} = removeBookmark.dataset;
            console.log(jobId);

            const confirm = await confirmAction(
                'Are you sure you want to remove this bookmark ?',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            try {
                const response = await deleteRequest(
                    `/api/jobs/${jobId}/bookmark`, xsrfToken
                );
                const result = await response.json();
                console.log(result);
                if(!response.ok) {
                    throw result;
                }

                showSuccess(result.message);
                gotoRoute('/');
            }catch (e){
                showError(e.message || 'Something went wrong.');
                gotoRoute('/', 3000);
            }
        })
    }

    if(reportButton) {
        reportButton.addEventListener('click', async (e) => {
            e.preventDefault();
            const {jobId} = reportButton.dataset;
            console.log(jobId);

            const confirm = await confirmAction(
                'Are you sure you want to report this job ?',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            try {
                const response = await fetch(`/api/jobs/${jobId}/report`, {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    }
                });

                const result = await response.json();
                console.log(result)
                if(!response.ok) {
                    showInfo(result.message, 3000);
                    gotoRoute('/', 3000);
                    return;
                }
                console.log(response);

                showSuccess(result.message);
                gotoRoute('/', 3000);
            }catch (e) {
                showError(e.message || 'Unexpected Error!');
            }
        });
    }

    if(deleteButton) {
        deleteButton.addEventListener('click', async () => {
            const {jobId} = deleteButton.dataset;
            console.log(jobId);

            const confirm = await confirmAction(
                'Are you sure you want to remove this job ? ',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            try {
                const response = await fetch(`/api/jobs/${jobId}/destroy`, {
                    method: 'DELETE',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    }
                })
                console.log(response);
                const result = await response.json();
                console.log(result);

                if(!response.ok) {
                    showError(result.message)
                }

                showSuccess(result.message);
                gotoRoute('/');
            }catch (e) {
                showError(e.message || 'Unexpected Error. Please try again!');
            }
        })
    }
})
