import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {postRequest} from "../reusableFunctions/fetchRequest.js";
import {showResponseMessage} from "../reusableFunctions/showResponseMessage.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {confirmAction} from "../reusableFunctions/confirmAction.js";
import JustValidate from "just-validate";

document.addEventListener("DOMContentLoaded", () => {
    const form =
        document.getElementById('jobForm');

    const validator = new JustValidate('#jobForm', {
        validateBeforeSubmitting: true,
        errorFieldCssClass: 'border-red-500',
        errorLabelCssClass: 'text-red-500 text-sm mt-1'
    })

    validator
        .addField('#title', [
            {
                rule: 'required',
                errorMessage: 'Title is required'
            }
        ])
        .addField('#salary', [
            {
                rule: 'required',
                errorMessage: 'Salary is required'
            }
        ])
        .addField('#location', [
            {
                rule: 'required',
                errorMessage: 'Location is required',
            }
        ])
        .addField('#schedule', [
            {
                rule: 'required',
                errorMessage: 'Schedule is required',
            },
            {
                rule: 'customRegexp',
                value: /^(Part Time|Full Time)$/,
                errorMessage: 'Schedule must be Part Time or Full Time',
            }
        ])
        .addField('#about', [
            {
                rule: 'required',
                errorMessage: 'About is required',
            }
        ])
        .addField('#url', [
            {
                rule: 'required',
                errorMessage: 'URL is required',
            },{
                rule: 'customRegexp',
                value: /^(https?:\/\/)?([\w\-]+\.)+[a-z]{2,6}(:\d{1,5})?(\/.*)?$/i,
                errorMessage: 'Must be a valid URL'
            }
        ])
        .onSuccess(async () => {
            const confirm = await confirmAction(
                'Are you sure you want to publish this job ?',
                'Yes, I am sure!'
            );
            if(!confirm) return;

            const xsrfToken =
                decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            const formData = new FormData(form);
            const data = Object.fromEntries(formData.entries());
            console.log(data);

            try {
                const response = await postRequest(
                    '/api/jobs/create', xsrfToken, data
                );
                console.log(response);

                const result = await response.json();
                console.log(result);

                const responseToUser =
                    document.getElementById('responseMessage');

                if(result.message !== 'Job Listed Successfully!') {
                    showResponseMessage(responseToUser, result);
                } else {
                    responseToUser.classList.remove('text-red-500');
                    responseToUser.classList.add('text-green-500');
                    showResponseMessage(responseToUser, result);
                }

                if (!response.ok) throw result;

                gotoRoute('/dashboard');
            }catch (err) {
                console.log(err);
            }
        });
});
