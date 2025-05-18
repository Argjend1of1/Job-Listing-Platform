import {getRequest} from "../reusableFunctions/fetchRequest.js";
import {generateEditForm} from "../reusableFunctions/generatingHTML/htmlFormGenerate.js";

document.addEventListener("DOMContentLoaded", async () => {
    try{
        const response = await getRequest('/api/account/edit')

        if(!response.ok) throw new Error('Failed to fetch job.');

        const { user } = await response.json();

        const formContainer = document.getElementById('editAccount');

        if(!user.employer) {
            formContainer.innerHTML = generateEditForm(
                'editAccountForm',
                ['name'], ['Your Name'],
                [user.name], 'deleteAccount',
                ['Update Account', 'Delete Account']
            )
        }else {
            formContainer.innerHTML = generateEditForm(
                'editAccountForm',
                ['name', 'employer'],
                ['Your Name', 'Company Name'],
                [user.name, user.employer?.name],
                'deleteAccount',
                ['Update Account', 'Delete Account']
            );
        }
    }catch (err) {
        console.log(err);
        window.location.href = '/api/dashboard'
    }

})
