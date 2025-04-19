const addPostBtn = document.querySelector(".add-post-btn");
const postModal = document.getElementById("postModal");
const closeModal = document.getElementById("closeModal");

// Open modal on button click
addPostBtn.addEventListener("click", () => {
    postModal.style.display = "flex";
});

// Close modal
closeModal.addEventListener("click", () => {
    postModal.style.display = "none";
});

// Close modal when clicking outside the modal box
window.addEventListener("click", (e) => {
    if (e.target === postModal) {
        postModal.style.display = "none";
    }
});

const imageInput = document.getElementById('postImage');
const videoInput = document.getElementById('postVideo');
const mediaPreview = document.getElementById('mediaPreview');

// Clear and show preview when image selected
imageInput.addEventListener('change', () => {
    const file = imageInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            mediaPreview.innerHTML = `<img src="${reader.result}" alt="Preview Image">`;
        };
        reader.readAsDataURL(file);
        videoInput.value = ''; // reset video if image is selected
    }
});

// Clear and show preview when video selected
videoInput.addEventListener('change', () => {
    const file = videoInput.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = () => {
            mediaPreview.innerHTML = `
        <video controls>
          <source src="${reader.result}" type="${file.type}">
          Your browser does not support the video tag.
        </video>`;
        };
        reader.readAsDataURL(file);
        imageInput.value = ''; // reset image if video is selected
    }
});
