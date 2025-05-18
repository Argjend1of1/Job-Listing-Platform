function inputsHtml(names = [], labels = [], values = []) {
    let html = ``;
    for(let i= 0; i < labels.length; i++) {
        html += `
            <div>
                    <label class="block text-white mb-2 font-bold">${labels[i]}</label>
                    <input name=${names[i]} value='${values[i]}' class="rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full" />
            </div>
        `
    }
    return html;
}

function buttonsHtml(id, labels = []) {
    let buttonsHtml = ``;
    for(let i = 0; i < labels.length; i += 2) {
        buttonsHtml += `
            <button type='submit' class=" inline-block px-6 py-2 border-2 border-gray-700 text-white hover:bg-gray-700 transition rounded-full cursor-pointer">${labels[i]}</button>
            <button id=${id} class="border-2 border-red-800 transition rounded-full py-2 px-6 font-bold ml-3 hover:bg-red-800 cursor-pointer focus:bg-red-900">${labels[i + 1]}</button>
        `
    }
    return buttonsHtml;
}

export function generateEditForm(formId, names=[], labels = [], values = [], buttonId, buttonLabels = []) {
    return `
            <form id=${formId} class="space-y-4">
                ${inputsHtml(names, labels, values)}

                <p class="mb-2 mt-2 text-green-500" id="userMessage"></p>

                <div class="mt-7 flex justify-between">
                    ${buttonsHtml(buttonId, buttonLabels)}
                </div>
            </form>
        `;
}
