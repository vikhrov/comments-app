document.addEventListener('click', function(event) {
    if (event.target.matches('.show-replies-btn')) {
        const button = event.target;
        const parentId = button.getAttribute('data-parent');
        const container = document.getElementById(`replies-container-${parentId}`);

        if (container.style.display === 'none' || container.innerHTML.trim() === '') {
            container.innerHTML = '';

            fetch(`/comments/replies/${parentId}`)
                .then(response => response.text())
                .then(data => container.innerHTML = data);

            button.innerText = 'Close replies';
            container.style.display = 'block';
        } else {
            button.innerText = 'Show replies';
            container.style.display = 'none';
        }
    }
});
