
console.log("Working")
document.addEventListener('click', async (e) => {
    if (e.target && e.target.id === 'followBtn') {
        const targetId = e.target.getAttribute('data-user-id');

        const res = await fetch('http://localhost/socialmedia/backend/api/toggleFollow.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            credentials: 'include',
            body: JSON.stringify({ target_id: targetId })
        });

        const result = await res.json();
        console.log(result);
        window.location.replace(window.location.href);
        if (result.status === 'followed') {
            e.target.textContent = 'Unfollow';
        } else if (result.status === 'unfollowed') {
            e.target.textContent = 'Follow';
        }

    }
});