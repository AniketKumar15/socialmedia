<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Zenkai - Login / Signup</title>

    <link rel="stylesheet" href="./Style/accountStyle.css">
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">

    <!-- ✅ Stable Font Awesome Version -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        .password-wrapper {
            position: relative;
            width: 100%;
            margin-bottom: 15px;
        }

        .password-wrapper input {
            width: 100%;
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            background: none;
            border: none;
            font-size: 16px;
            color: #555;
        }

        .toggle-password:hover {
            color: #000;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Zenkai - Join Our Community</h1>

        <div class="tabs">
            <button id="loginTab" class="active">Login</button>
            <button id="signupTab">Signup</button>
        </div>

        <!-- ================= LOGIN FORM ================= -->
        <form id="loginForm" class="active" method="post" action="http://localhost/socialmedia/Backend/api/login.php">

            <input type="text" placeholder="Username" name="username" required />

            <div class="password-wrapper">
                <input type="password" placeholder="Password" name="password" id="loginPassword" required />
                <button type="button" class="toggle-password" onclick="togglePassword('loginPassword', this)">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="submit-btn" name="loginBtn">Login</button>
        </form>

        <!-- ================= SIGNUP FORM ================= -->
        <form id="signupForm" method="post" action="http://localhost/socialmedia/Backend/api/register.php">

            <input type="text" placeholder="Full Name" name="fullname" required />
            <input type="text" placeholder="Username" name="username" required />
            <input type="email" placeholder="Email" name="email" required />

            <div class="password-wrapper">
                <input type="password" placeholder="Password" name="password" id="signupPassword" minlength="8"
                    required />
                <button type="button" class="toggle-password" onclick="togglePassword('signupPassword', this)">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <div class="password-wrapper">
                <input type="password" placeholder="Confirm Password" name="cpassword" id="confirmPassword"
                    minlength="8" required />
                <button type="button" class="toggle-password" onclick="togglePassword('confirmPassword', this)">
                    <i class="fa-solid fa-eye"></i>
                </button>
            </div>

            <button type="submit" class="submit-btn" name="signupBtn">Signup</button>
        </form>
    </div>

    <!-- ================= TOGGLE SCRIPT ================= -->
    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector("i");

            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        }
    </script>

    <script src="./Js/accountApp.js"></script>
    <script src="./js/theme.js"></script>

</body>

</html>