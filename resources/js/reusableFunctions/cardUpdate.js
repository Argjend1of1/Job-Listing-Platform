export function updateCard(button, text, selector) {
    button.classList.remove('border-red-800');
    button.classList.add('border-green-800');
    button.innerHTML = text
    //remove card from the DOM
    setTimeout(() => {
        const card = button.closest(selector);
        if (card) card.remove();
    }, 1000)
}
