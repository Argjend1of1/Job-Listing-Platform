import {getCookieValue} from "../reusableFunctions/getCookie.js";
import {gotoRoute} from "../reusableFunctions/gotoRoute.js";
import {showResponseMessage} from "../reusableFunctions/showResponseMessage.js";
import JustValidate from "just-validate";

document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('is_company').addEventListener('change', ()  => {
        document.getElementById('companyNameInput').classList.toggle('hidden');
    });

    const form =
        document.getElementById('registerForm');
    if(!form) return;
    console.log(form);

    const validation = new JustValidate('#registerForm', {
        errorFieldCssClass: 'border-red-500',
        errorLabelCssClass: 'text-red-500, text-sm mt-1'
    });

    validation
        .addField('#name',[
            {
                rule: 'required',
                errorMessage: 'Name is required'
            }
        ])
        .addField('#email', [
            {
                rule: 'required',
                errorMessage: 'Email is required'
            },
            {
                rule: 'email',
                errorMessage: 'Invalid email format'
            }
        ])
        .addField('#password', [
            {
                rule: 'required',
                errorMessage: 'Password is required'
            },
            {
                rule: 'minLength',
                value: 6,
                errorMessage: 'Password must be at least 6 characters'
            }
        ])
        .addField('#password_confirmation', [
            {
                rule: 'required',
                errorMessage: 'Please confirm your password',
            },
            {
                rule: 'minLength',
                value: 6,
                errorMessage: 'Password must be at least 6 characters'
            }
        ])
        .addField('#logo', [
            {
                rule: 'required',
                errorMessage: 'Logo is required',
            },
            {
                rule: 'file',
                errorMessage: 'Please upload a valid file',
                validator: (value) => {
                    const file = document.getElementById('logo').files[0];
                    if (file) {
                        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
                        return validTypes.includes(file.type);  // Check if file type is valid
                    }
                    return false;  // No file selected or invalid file type
                }
            },
            {
                rule: 'maxFilesCount',
                value: 1,
                errorMessage: 'You can only upload one logo',
            },
            {
                rule: 'maxLength',
                value: 2 * 1024 * 1024,  // 2MB in bytes
                errorMessage: 'Logo must be less than 2MB',
            }
        ])
        .addField('#category', [
            {
                rule: 'required',
                errorMessage: 'Please specify the category!',
            }
        ])
        .addField('#employer', [
            {
                rule: 'minLength',
                value: 3,
                errorMessage: 'Company should contain at least 3 characters',
            }
        ])
        .onSuccess(async (e) => {
            e.preventDefault();//reloading stopped

            const formData = new FormData(form);

            // for (let [key, value] of formData.entries()) {
            //     console.log(`${key}:`, value);
            // }

            await fetch('/sanctum/csrf-cookie', {
                credentials: 'include'
            });

            const xsrfToken = decodeURIComponent(getCookieValue('XSRF-TOKEN'));

            try {
                const response = await fetch('/api/register', {
                    method: 'POST',
                    credentials: 'include',
                    headers: {
                        'Accept': 'application/json',
                        'X-XSRF-TOKEN': xsrfToken
                    },
                    body: formData
                })

                const result = await response.json();
                console.log(result.message);

                const responseToUser =
                    document.getElementById('responseMessage');

                if(result.message !== 'Successfully Registered!') {
                    document.getElementById('password').value = '';
                    document.getElementById('password_confirmation').value = '';
                    responseToUser.classList.add('text-red-500');
                    showResponseMessage(responseToUser, result);
                } else {
                    responseToUser.classList.add('text-green-500');
                    showResponseMessage(responseToUser, result);
                }
                // console.log("HERE!!!");

                if (!response.ok) throw result;

                gotoRoute('/login');
            } catch (err) {
                document.getElementById('responseMessage')
                    .textContent = err?.message || 'Registration Failed!';
            }
        })
});
