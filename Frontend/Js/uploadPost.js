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


document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.comment-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const postId = btn.getAttribute('data-post-id');
            console.log(postId);
            // Hide post area, show comment area
            document.querySelector('.postArea').style.display = 'none';
            const commentArea = document.querySelector('.commentArea');
            commentArea.style.display = 'block';

            // Load the post and its comments dynamically
            const res = await fetch(`./components/postCommentView.php?post_id=${postId}`);
            const html = await res.text();
            commentArea.innerHTML = html;
        });
    });
});

document.addEventListener('DOMContentLoaded', async () => {
    // Handle clicking comment buttons
    document.querySelectorAll('.comment-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const postId = btn.getAttribute('data-post-id');
            const newUrl = window.location.href.split('?')[0] + '?post_id=' + postId;
            window.history.pushState({ post_id: postId }, "", newUrl);
            loadCommentView(postId);
        });
    });

    // Handle direct URL with post_id
    const urlParams = new URLSearchParams(window.location.search);
    const postIdUrl = urlParams.get('post_id');
    if (postIdUrl) {
        loadCommentView(postIdUrl);
    }

    async function loadCommentView(postId) {
        const postArea = document.querySelector('.postArea');
        const commentArea = document.querySelector('.commentArea');

        if (postArea) postArea.style.display = 'none';
        if (commentArea) {
            commentArea.style.display = 'block';

            const res = await fetch(`./components/postCommentView.php?post_id=${postId}`);
            const html = await res.text();
            commentArea.innerHTML = html;

            // Attach comment submission listener after comment section loads
            const submitBtn = document.getElementById('submitComment');
            if (submitBtn) {
                submitBtn.addEventListener('click', async (e) => {
                    e.preventDefault();

                    const content = document.getElementById('commentText').value.trim();
                    if (!content) return alert("Comment cannot be empty");

                    const response = await fetch('http://localhost/socialmedia/Backend/api/addComment.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        credentials: 'include',
                        body: JSON.stringify({ post_id: postId, content })
                    });
                    window.location.replace(window.location.href);
                    const result = await response.json();
                    console.log(result);
                });
            }
        }
    }
});
window.addEventListener('popstate', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const postId = urlParams.get('post_id');

    if (postId) {
        // Same logic as above to load comment view
    } else {
        // No post_id — show post feed again
        document.querySelector('.postArea').style.display = 'block';
        document.querySelector('.commentArea').style.display = 'none';
    }
});


