document.addEventListener('DOMContentLoaded', () => {
    fetch('http://localhost/socialmedia/backend/api/getNotifications.php')
        .then(res => res.json())
        .then(data => {
            const notifIcon = document.querySelector('.NotificationsIcon');
            const notifIconMobile = document.querySelector('.NotificationsIconMobile');


            if (data.unreadCount > 0) {
                notifIcon.style.display = 'inline';
                notifIconMobile.style.color = 'rgb(255, 0, 0)';

                // notifIcon.parentElement.appendChild(document.createTextNode(data.unreadCount));
                // Show the dot
            } else {
                notifIcon.style.display = 'none'; // Hide the dot
                notifIconMobile.style.color = 'rgb(255, 255, 255)';

            }
        });
});
