<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zenkai - Login / Signup</title>
    <link rel="stylesheet" href="./Style/accountStyle.css">
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <h1>Zenkai - Join Our Community</h1>
        <div class="tabs">
            <button id="loginTab" class="active">Login</button>
            <button id="signupTab">Signup</button>
        </div>

        <!-- Login Form -->
        <form id="loginForm" class="active" method="post" action="http://localhost/socialmedia/Backend/api/login.php">
            <input type="text" placeholder="Username" name="username" required />
            <input type="password" placeholder="Password" name="password" required />
            <button type="submit" class="submit-btn" name="loginBtn">Login</button>
        </form>

        <!-- Signup Form -->
        <form id="signupForm" method="post" action="http://localhost/socialmedia/Backend/api/register.php">
            <input type="text" placeholder="Full Name" name="fullname" required />
            <input type="text" placeholder="Username" name="username" required />
            <input type="email" placeholder="Email" name="email" required />
            <input type="password" placeholder="Password" name="password" minlength="8" required />
            <input type="password" placeholder="Conform Password" name="cpassword" minlength="8" required />
            <button type="submit" class="submit-btn" name="signupBtn">Signup</button>
        </form>
    </div>

    <script src="./Js/accountApp.js"></script>
</body>

</html>