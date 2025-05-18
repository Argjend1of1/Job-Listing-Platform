export function hasCompany(employer) {
    if(employer) {
        return `
            <div>
                <p class="text-sm text-white font-semibold">Company:</p>
                <p class="text-gray-400 text-base">
                    ${employer.name}
                </p>
            </div>
        `
    }else {
        return ``;
    }
}

document.addEventListener("DOMContentLoaded", async () => {
    try {
        const response = await fetch('/api/account', {
            method: 'GET',
            credentials: 'include',
            headers: {
                'Accept': 'application/json'
            }
        });

        console.log(response);
        if (!response.ok) throw new Error('Unauthorized');

        const { user, employer } = await response.json();
        console.log(user);

        const accountContainer = document.getElementById('accountContainer');
        accountContainer.innerHTML = `
            <h2 class="text-2xl font-bold text-white mb-6">Account Information</h2>
            <div class="space-y-4">
            <div>
                <p class="text-sm text-white font-semibold">Name:</p>
                <p class="text-gray-400 text-base">${user.name}</p>
            </div>

            <div>
                <p class="text-sm text-white font-semibold">Email:</p>
                <p class="text-gray-400 text-base">${user.email}</p>
            </div>
            ${hasCompany(employer)}

            <div class="pt-6">
                <a href="/account/edit"
                   class="inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full focus:bg-gray-800">
                    Edit Account
                </a>
            </div>
        `;
    } catch (err) {
        console.error('Failed to fetch account data:', err);
        window.location.href = '/api/login';
    }
});
