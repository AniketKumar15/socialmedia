<!-- Add Post Modal -->
<div class="post-modal" id="postModal">
    <div class="post-modal-content">
        <span class="close-btn" id="closeModal">&times;</span>
        <h2>Just dropped a Kai</h2>
        <form id="createPostForm" method="post">
            <textarea placeholder="What's happening?" name="postText" required></textarea>

            <div class="upload-section">
                <label for="postImage">
                    <i class="fas fa-image"></i> Upload Image
                </label>
                <input type="file" accept="image/*" id="postImage" name="postImage" hidden>

                <label for="postVideo">
                    <i class="fas fa-video"></i> Upload Video
                </label>
                <input type="file" accept="video/*" id="postVideo" name="postVideo" hidden>
            </div>

            <div class="media-preview" id="mediaPreview"></div>

            <button type="submit" class="submit-post-btn" name="postBtn">Post</button>
        </form>

    </div>
</div>