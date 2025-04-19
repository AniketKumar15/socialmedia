document.getElementById('createPostForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    const response = await fetch('http://localhost/socialmedia/backend/api/uploadPost.php', {
        method: 'POST',
        body: formData,
        credentials: 'include'
    });

    const result = await response.json();
    alert(result.message);

    if (result.status === 'success') {
        form.reset();
        document.getElementById('mediaPreview').innerHTML = '';
        document.getElementById('postModal').style.display = 'none';
        window.location.replace(window.location.href);
        // Optionally reload posts
    }
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.likeBtn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const postId = btn.getAttribute('data-post-id');

            const res = await fetch('http://localhost/socialmedia/backend/api/likePost.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                credentials: 'include',
                body: JSON.stringify({ post_id: postId })
            });

            const result = await res.json();

            if (result.status === 'liked') {
                btn.classList.remove('far');
                btn.classList.add('fas', 'liked');
                window.location.replace(window.location.href);
            } else if (result.status === 'unliked') {
                btn.classList.remove('fas', 'liked');
                btn.classList.add('far');
                window.location.replace(window.location.href);
            }
        });
    });
});


