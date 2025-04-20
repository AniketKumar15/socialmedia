
# <p>
  <img src="./Frontend/Img/LogoIconLight.png" alt="Zenkai Logo" width="60" style="border-radius: 50%;">
  <h1>Zenkai - Social Media Platform</h1>
</p>



**Zenkai** is a lightweight social media web application inspired by platforms like X (formerly Twitter). It allows users to register, log in, post updates (called **Kais**), like posts, and soon comment and interact in real-time.

## 🧩 Features

- 🔐 User Authentication (Signup/Login)
- 📝 Post creation with text, image, or video (called "Kai")
- ❤️ Like/Unlike functionality
- ⏱️ Time ago feature for posts
- 🖼️ Dynamic media preview
- 💬 Upcoming: Comments system
- 📱 Responsive design (Desktop & Mobile)
- 🎯 Clean and simple layout with three main sections:
  - Left sidebar (navigation)
  - Center feed (posts)
  - Right sidebar (recommendations/future widgets)

## 📁 Project Structure

```
socialmedia/
│
├── backend/
│   ├── api/              # All API endpoints (uploadPost.php, likePost.php, etc.)
│   ├── db/
│   │   ├── db.php        # Database connection
│   │   └── tablecreation.php  # Table setup script
│
├── frontend/
│   ├── index.php         # Main entry point
│   ├── components/
│   │   └── postCard.php  # Post rendering logic
│   ├── style/            # CSS styles
│   ├── js/               # JavaScript files (likePost.js, uploadPost.js, etc.)
│   └── image/            # Static images
```

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, JavaScript (Vanilla)
- **Backend:** PHP (Procedural)
- **Database:** MySQL
- **Server:** XAMPP / Apache (Local development)

## 🚀 Setup Instructions

1. Clone this repository:
   ```bash
   git clone https://github.com/your-username/zenkai.git
   ```

2. Import the database:
   - Run `tablecreation.php` once to set up the required tables.

3. Configure XAMPP:
   - Place the `socialmedia/` folder inside `htdocs/`.

4. Start Apache and MySQL from XAMPP Control Panel.

5. Visit the project in browser:
   ```
   http://localhost/socialmedia/frontend/index.php
   ```

## 🙌 Author

Created with ❤️ by Aniket Kumar

