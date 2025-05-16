
// later when we implement session.js so it either displays the user
// avatar or the guest links.
export function initializeDropdown() {
    const dropdownButton =
        document.getElementById('dropdownButton');

    const dropdownMenu =
        document.getElementById('dropdownMenu');

    const profileDropdown =
        document.getElementById('profileDropdown');

// Toggle dropdown on button click
    dropdownButton.addEventListener(
        'click',  (e
    ) => {
        e.stopPropagation(); // Prevent click from bubbling
        dropdownMenu.classList.toggle('opacity-0');
        dropdownMenu.classList.toggle('scale-95');
        dropdownMenu.classList.toggle('pointer-events-none');
        dropdownMenu.classList.toggle('opacity-100');
        dropdownMenu.classList.toggle('scale-100');
    });

// Hide dropdown when clicking outside
    document.addEventListener(
        'click',  (e
    ) => {
        if (!profileDropdown.contains(e.target)) {
            dropdownMenu.classList.add('opacity-0', 'scale-95', 'pointer-events-none');
            dropdownMenu.classList.remove('opacity-100', 'scale-100');
        }
    });
}
