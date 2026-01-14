<?php
session_start();
include "../Backend/db/db.php";

if (!isset($_SESSION["id"])) {
    header("Location: ./account.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zenkai - Settings</title>
    <link rel="shortcut icon" href="./Img/LogoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="./Style/style.css">
    <link rel="stylesheet" href="./Style/navBarStyle.css">
    <link rel="stylesheet" href="./Style/postCardStyle.css">
    <link rel="stylesheet" href="./Style/threePartStyle.css">
    <link rel="stylesheet" href="./Style/postModelStyle.css">
    <link rel="stylesheet" href="./Style/commentStyle.css">
    <link rel="stylesheet" href="./Style/SettingPageStyle.css">



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <?php include "./components/navBar.php"; ?>

    <main>
        <?php include "./components/leftSideBar.php" ?>
        <section class="postArea">
            <h1>Settings</h1>
            <div class="settings-container">
                <div class="settings-card">
                    <div class="toggleMode">
                        <!-- Light / Dark mode toggle -->
                        <p>Toggle Mode</p>
                        <!-- From Uiverse.io by JkHuger -->
                        <label for="theme" class="theme">
                            <span class="theme__toggle-wrap">
                                <input id="theme" class="theme__toggle" type="checkbox" role="switch" name="theme"
                                    value="light" aria-label="Toggle light and dark mode">
                                <span class="theme__fill"></span>
                                <span class="theme__icon">
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                    <span class="theme__icon-part"></span>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
                <details class="settings-card">
                    <summary>Privacy Policy</summary>

                    <!-- 1. Introduction -->
                    <details class="accordion">
                        <summary class="accordion__summary">Introduction</summary>
                        <div class="accordion__content">
                            <p>
                                Welcome to Zenkia. Your privacy is very important to us. This Privacy Policy explains
                                how we collect,
                                use, protect, and handle your personal information when you use our social media
                                platform.
                            </p>
                            <p>
                                By accessing or using Zenkia, you agree to the practices described in this policy.
                            </p>
                        </div>
                    </details>

                    <!-- 2. Information We Collect -->
                    <details class="accordion">
                        <summary class="accordion__summary">Information We Collect</summary>
                        <div class="accordion__content">
                            <p>We may collect the following types of information:</p>
                            <ul>
                                <li>Account information such as username, email address, and profile details</li>
                                <li>Content you create, post, like, comment on, or share</li>
                                <li>Messages and interactions with other users</li>
                                <li>Device information such as browser type, IP address, and operating system</li>
                            </ul>
                        </div>
                    </details>

                    <!-- 3. How We Use Your Information -->
                    <details class="accordion">
                        <summary class="accordion__summary">How We Use Your Information</summary>
                        <div class="accordion__content">
                            <p>Your information is used to:</p>
                            <ul>
                                <li>Provide, maintain, and improve Zenkia’s features</li>
                                <li>Personalize your experience and content recommendations</li>
                                <li>Communicate with you about updates, security, and support</li>
                                <li>Detect and prevent fraud, abuse, or harmful activity</li>
                            </ul>
                        </div>
                    </details>

                    <!-- 4. Sharing of Information -->
                    <details class="accordion">
                        <summary class="accordion__summary">Sharing of Information</summary>
                        <div class="accordion__content">
                            <p>
                                Zenkia does not sell your personal data. We may share information only in the following
                                cases:
                            </p>
                            <ul>
                                <li>With your consent</li>
                                <li>To comply with legal obligations or law enforcement requests</li>
                                <li>To protect the safety, rights, or security of Zenkia and its users</li>
                                <li>With trusted service providers who help operate our platform</li>
                            </ul>
                        </div>
                    </details>

                    <!-- 5. Cookies & Tracking -->
                    <details class="accordion">
                        <summary class="accordion__summary">Cookies & Tracking Technologies</summary>
                        <div class="accordion__content">
                            <p>
                                We use cookies and similar technologies to improve performance, remember preferences,
                                and analyze platform usage.
                            </p>
                            <p>
                                You can manage or disable cookies through your browser settings, though some features
                                may not function properly.
                            </p>
                        </div>
                    </details>

                    <!-- 6. Data Security -->
                    <details class="accordion">
                        <summary class="accordion__summary">Data Security</summary>
                        <div class="accordion__content">
                            <p>
                                We implement industry-standard security measures to protect your data from unauthorized
                                access,
                                alteration, or disclosure.
                            </p>
                            <p>
                                While we strive to protect your information, no online platform can guarantee complete
                                security.
                            </p>
                        </div>
                    </details>

                    <!-- 7. User Rights -->
                    <details class="accordion">
                        <summary class="accordion__summary">Your Rights & Choices</summary>
                        <div class="accordion__content">
                            <p>You have the right to:</p>
                            <ul>
                                <li>Access and update your personal information</li>
                                <li>Delete your account and associated data</li>
                                <li>Control privacy settings and visibility of your content</li>
                                <li>Opt out of certain communications</li>
                            </ul>
                        </div>
                    </details>

                    <!-- 8. Children’s Privacy -->
                    <details class="accordion">
                        <summary class="accordion__summary">Children’s Privacy</summary>
                        <div class="accordion__content">
                            <p>
                                Zenkia is not intended for children under the age of 13. We do not knowingly collect
                                personal
                                information from children.
                            </p>
                            <p>
                                If you believe a child has provided us with personal data, please contact us so we can
                                remove it.
                            </p>
                        </div>
                    </details>

                    <!-- 9. Changes to Policy -->
                    <details class="accordion">
                        <summary class="accordion__summary">Changes to This Policy</summary>
                        <div class="accordion__content">
                            <p>
                                We may update this Privacy Policy from time to time. Any changes will be posted on this
                                page
                                with an updated effective date.
                            </p>
                            <p>
                                Continued use of Zenkia after changes means you accept the updated policy.
                            </p>
                        </div>
                    </details>

                    <!-- 10. Contact -->
                    <details class="accordion">
                        <summary class="accordion__summary">Contact Us</summary>
                        <div class="accordion__content">
                            <p>
                                If you have questions or concerns about this Privacy Policy or your data, please contact
                                us
                                through Zenkia’s support or settings page.
                            </p>
                        </div>
                    </details>
                </details>

                <div class="settings-card">
                    <div class="toggleMode">
                        <p>Forget Password</p>
                        <form id="settingForm" method="post"
                            action="http://localhost/socialmedia/Backend/api/ForgetPassword.php">

                            <input type="password" name="new_password" class="forgetPasswordInput"
                                placeholder="Enter your new password" minlength="8" required>

                            <button type="submit">Update</button>
                        </form>

                    </div>
                </div>

                <div class="settings-card">
                    <div class="toggleMode">
                        <p>Delete Account</p>
                        <form id="settingForm" method="post"
                            action="http://localhost/socialmedia/Backend/api/DeleteAccount.php">
                            <input type="text" name="del_Account"
                                placeholder="Enter your username to deletion confirmation" required>
                            <button type="submit" style="background-color: red; color: white;">Delete</button>
                        </form>

                    </div>
                </div>

                <details class="settings-card">
                    <summary>Frequently Asked Questions (FAQs)</summary>

                    <!-- 1 -->
                    <details class="accordion">
                        <summary class="accordion__summary">What is Zenkia?</summary>
                        <div class="accordion__content">
                            <p>
                                Zenkia is a social media platform where users can connect, share content, and interact
                                with
                                others in a safe and modern digital environment.
                            </p>
                        </div>
                    </details>

                    <!-- 2 -->
                    <details class="accordion">
                        <summary class="accordion__summary">Is Zenkia free to use?</summary>
                        <div class="accordion__content">
                            <p>
                                Yes. Zenkia is completely free to use. All core features such as posting, liking,
                                commenting, and messaging are available at no cost.
                            </p>
                        </div>
                    </details>

                    <!-- 3 -->
                    <details class="accordion">
                        <summary class="accordion__summary">How do I create an account?</summary>
                        <div class="accordion__content">
                            <p>
                                You can create an account by signing up with your name, username, email address,
                                and password on the registration page.
                            </p>
                        </div>
                    </details>

                    <!-- 4 -->
                    <details class="accordion">
                        <summary class="accordion__summary">I forgot my password. What should I do?</summary>
                        <div class="accordion__content">
                            <p>
                                If you forgot your password, you can reset it from the settings or forgot password
                                section by entering a new password while logged in.
                            </p>
                        </div>
                    </details>

                    <!-- 5 -->
                    <details class="accordion">
                        <summary class="accordion__summary">How can I change my privacy settings?</summary>
                        <div class="accordion__content">
                            <p>
                                You can manage your privacy preferences from the Settings page. This includes
                                controlling who can see your content and how your data is used.
                            </p>
                        </div>
                    </details>

                    <!-- 6 -->
                    <details class="accordion">
                        <summary class="accordion__summary">Can I delete my account?</summary>
                        <div class="accordion__content">
                            <p>
                                Yes. You can request account deletion from the Settings section. Once deleted,
                                your data will be permanently removed from Zenkia.
                            </p>
                        </div>
                    </details>

                    <!-- 7 -->
                    <details class="accordion">
                        <summary class="accordion__summary">How do I report inappropriate content or users?</summary>
                        <div class="accordion__summary">
                            <p>
                                You can report posts or users using the report option available on content and profiles.
                                Our moderation team reviews all reports to maintain a safe community.
                            </p>
                        </div>
                    </details>

                    <!-- 8 -->
                    <details class="accordion">
                        <summary class="accordion__summary">Is my personal data safe on Zenkia?</summary>
                        <div class="accordion__content">
                            <p>
                                Yes. We use secure technologies and best practices to protect your personal data
                                and prevent unauthorized access.
                            </p>
                        </div>
                    </details>

                    <!-- 9 -->
                    <details class="accordion">
                        <summary class="accordion__summary">Does Zenkia support dark and light mode?</summary>
                        <div class="accordion__content">
                            <p>
                                Yes. Zenkia offers both dark and soft-light modes, which can be toggled from the
                                Settings page.
                            </p>
                        </div>
                    </details>

                    <!-- 10 -->
                    <details class="accordion">
                        <summary class="accordion__summary">How can I contact Zenkia support?</summary>
                        <div class="accordion__content">
                            <p>
                                If you need help, you can reach out through the Help & Support section in Settings.
                                We are always here to help you.
                            </p>
                        </div>
                    </details>
                </details>

            </div>
        </section>

        <?php include "./components/rightSideBar.php" ?>

    </main>
    <script src="./js/theme.js"></script>
</body>

</html>