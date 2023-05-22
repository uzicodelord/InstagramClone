var modal = document.getElementById("modal");

var btn = document.getElementById("open-modal-btn");

var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target === modal) {
        modal.style.display = "none";
    }
}
//////////////////////

import axios from 'axios';

const likeLinks = document.querySelectorAll('.like-link');
const likeIcons = document.querySelectorAll('.like-icon');
const likeCounts = document.querySelectorAll('.like-count');

likeLinks.forEach(function(likeLink, index) {
    likeLink.addEventListener('click', function(e) {
        e.preventDefault();

        const postId = this.getAttribute('data-post-id');
        const url = '/posts/' + postId + '/like';

        const liked = localStorage.getItem(`post_${postId}_liked`) === 'true';

        axios.post(url)
            .then(function(response) {
                const { liked: newLiked, count } = response.data;

                localStorage.setItem(`post_${postId}_liked`, newLiked);

                likeCounts[index].textContent = count + ' ' + (count === 1 ? 'like' : 'likes');

                if (newLiked) {
                    likeIcons[index].classList.remove('mdi-heart-outline');
                    likeIcons[index].classList.add('mdi-heart');
                } else {
                    likeIcons[index].classList.remove('mdi-heart');
                    likeIcons[index].classList.add('mdi-heart-outline');
                }
            })
            .catch(function(error) {
                console.log(error);
            });

        if (liked) {
            localStorage.setItem(`post_${postId}_liked`, false);

            likeIcons[index].classList.remove('mdi-heart');
            likeIcons[index].classList.add('mdi-heart-outline');
        } else {
            localStorage.setItem(`post_${postId}_liked`, true);

            likeIcons[index].classList.remove('mdi-heart-outline');
            likeIcons[index].classList.add('mdi-heart');
        }
    });
});

// Initialize the liked status and like count on page load
likeLinks.forEach(function(likeLink, index) {
    const postId = likeLink.getAttribute('data-post-id');
    const liked = localStorage.getItem(`post_${postId}_liked`) === 'true';

    const count = parseInt(likeCounts[index].textContent);

    if (liked) {
        likeIcons[index].classList.remove('mdi-heart-outline');
        likeIcons[index].classList.add('mdi-heart');
    } else {
        likeIcons[index].classList.remove('mdi-heart');
        likeIcons[index].classList.add('mdi-heart-outline');
    }

    likeCounts[index].textContent = count + ' ' + (count === 1 ? 'like' : 'likes');
});

////////////////////
const commentForms = document.querySelectorAll('#comment-form');
const commentLists = document.querySelectorAll('#comment-list');

commentForms.forEach((commentForm, index) => {
    commentForm.addEventListener('submit', function (event) {
        event.preventDefault();
        const postId = this.getAttribute('data-post-id');
        const url = `/posts/${postId}/comments`;
        const formData = new FormData(this);

        axios.post(url, formData)
            .then(function (response) {
                const comment = response.data.comment;
                const user = response.data.user;
                const commentHtml = `
                  <div class="card">
                    <div class="card-body card-body-comment">
                      <a href="/${user.name}" class="userhover">${user.name}</a> ${comment.content}
                    </div>
                  </div>
                `;

                commentLists[index].insertAdjacentHTML('beforeend', commentHtml);
                commentForm.reset();
            });
    });

    const commentInput = commentForm.querySelector('.comment');
    const submitBtn = commentForm.querySelector('button[type="submit"]');

    commentInput.addEventListener('input', function() {
        if (this.value.trim().length > 0) {
            submitBtn.style.display = 'block';
        } else {
            submitBtn.style.display = 'none';
        }
    });
});


var editprofilemodal = document.getElementById("edit-profile-modal");

var editprofilebtn = document.getElementById("edit-profile-btn");

var editspan = document.getElementsByClassName("editprofileclose")[0];

editprofilebtn.onclick = function() {
    editprofilemodal.style.display = "block";
}

editspan.onclick = function() {
    editprofilemodal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target === editprofilemodal) {
        editprofilemodal.style.display = "none";
    }
}

