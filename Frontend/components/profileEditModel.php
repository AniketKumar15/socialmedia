<!-- Edit Profile Modal -->
<div id="editProfileModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Edit Profile</h2>
        <form id="editProfileForm" enctype="multipart/form-data">
            <div class="avatar-preview">
                <img id="previewImage" src="" alt="Profile Preview">
                <input type="file" id="profilePic" name="profile_pic" accept="image/*"
                    onchange="previewProfilePic(event)">
            </div>

            <label>Full Name</label>
            <input type="text" name="fullname" id="fullname" required>

            <label>Username</label>
            <input type="text" name="username" id="username" required>

            <label>Email</label>
            <input type="email" name="email" id="email" required>

            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>