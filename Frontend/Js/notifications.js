function timeAgo(dateString) {
    const date = new Date(dateString);
    const seconds = Math.floor((new Date() - date) / 1000);

    const intervals = {
        year: 31536000,
        month: 2592000,
        week: 604800,
        day: 86400,
        hour: 3600,
        minute: 60,
        second: 1
    };

    for (let unit in intervals) {
        const value = Math.floor(seconds / intervals[unit]);
        if (value > 0) {
            return `${value} ${unit}${value !== 1 ? 's' : ''} ago`;
        }
    }
    return "just now";
}
console.log("askfnakn00");
document.addEventListener('DOMContentLoaded', () => {
    fetch('http://localhost/socialmedia/backend/api/getNotifications.php')
        .then(res => res.json())
        .then(data => {
            const container = document.getElementById('notificationsContainer');
            container.innerHTML = '';


            if (data.status === 'success') {
                if (data.notifications.length === 0) {
                    container.innerHTML = '<p>No notifications yet.</p>';
                    return;
                }

                data.notifications.forEach(notification => {
                    let actionText = '';
                    if (notification.type === 'like') {
                        actionText = 'liked your post';
                    } else if (notification.type === 'comment') {
                        actionText = 'commented on your post';
                    } else if (notification.type === 'follow') {
                        actionText = 'followed you';
                    }

                    const div = document.createElement('div');
                    div.className = 'notificationCard';

                    // Build the base HTML
                    let innerHTML = `
                        <div class="notificationUser">
                            <img src="${notification.profile_pic ? '../' + notification.profile_pic : './img/avatar.png'}" alt="Profile">
                            <div>
                                <p><strong>@${notification.username}</strong> ${actionText}</p>
                                <small>${timeAgo(notification.created_at)}</small>
                            </div>
                        </div>`;

                    // Only include post content and "show more" if this is a post-related notification
                    if (notification.post_id && notification.post_content) {
                        const preview = notification.post_content.length > 100
                            ? notification.post_content.slice(0, 100) + '...'
                            : notification.post_content;

                        innerHTML += `
                        <div>
                            <p>${preview}</p>
                            <a href='http://localhost/socialmedia/Frontend/index.php?post_id=${notification.post_id}'>Show More</a>
                        </div>`;
                    }

                    div.innerHTML = innerHTML;
                    container.appendChild(div);
                });
            } else {
                container.innerHTML = '<p>Error loading notifications</p>';
            }
        });
});