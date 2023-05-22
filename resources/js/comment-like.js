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
                const createdAt = response.data.created_at;
                const commentHtml = `
            <div class="card" style="padding-top: 10px;">
                <div class="d-flex align-items-start">
                    <a href="/${user.name}" class="userhover">
                        <img src="${user.profile_picture}" class="rounded-circle" width="32" height="32" alt="">
                    </a>
                    <div class="card-body card-body-comment ml-2">
                        <p><a href="/profiles/${user.name}" class="userhover">${user.name}</a>
                           <span style="font-size: 10px;padding-left: 4px;">${comment.content}</span>
                        </p>
                        <p class="text-muted" style="font-size: 10px;">${createdAt}</p>
                    </div>
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
///////////////////////////////////////////////////

const likeCommentLinks = document.querySelectorAll('.like-comment-links');
const likeCommentIcons = document.querySelectorAll('.liked-comment-icons');
const likeCommentCounts = document.querySelectorAll('.liked-comment-counts');

likeCommentLinks.forEach(function(likeCommentLink, index) {
    likeCommentLink.addEventListener('click', function(e) {
        e.preventDefault();

        const commentId = this.getAttribute('data-comment-id');
        const url = '/comments/' + commentId + '/likes';

        const liked = localStorage.getItem(`comment_${commentId}_liked`) === 'true';

        axios.post(url)
            .then(function(response) {
                const { liked: newLiked, count } = response.data;

                localStorage.setItem(`comment_${commentId}_liked`, newLiked);

                likeCommentCounts[index].textContent = count + ' ' + (count === 1 ? 'like' : 'likes');

                if (newLiked) {
                    likeCommentIcons[index].classList.remove('mdi-heart-outline');
                    likeCommentIcons[index].classList.add('mdi-heart');
                } else {
                    likeCommentIcons[index].classList.remove('mdi-heart');
                    likeCommentIcons[index].classList.add('mdi-heart-outline');
                }
            })
            .catch(function(error) {
                console.log(error);
            });

        if (liked) {
            localStorage.setItem(`comment_${commentId}_liked`, false);

            likeCommentIcons[index].classList.remove('mdi-heart');
            likeCommentIcons[index].classList.add('mdi-heart-outline');

            const count = parseInt(likeCommentCounts[index].textContent) - 1;
            likeCommentCounts[index].textContent = count + ' ' + (count === 1 ? 'like' : 'likes');
        } else {
            localStorage.setItem(`comment_${commentId}_liked`, true);

            likeCommentIcons[index].classList.remove('mdi-heart-outline');
            likeCommentIcons[index].classList.add('mdi-heart');

            const count = parseInt(likeCommentCounts[index].textContent) + 1;
            likeCommentCounts[index].textContent = count + ' ' + (count === 1 ? 'like' : 'likes');
        }
    });
});

// Initialize the liked status and like count on page load
likeCommentLinks.forEach(function(likeCommentLink, index) {
    const commentId = likeCommentLink.getAttribute('data-comment-id');
    const liked = localStorage.getItem(`comment_${commentId}_liked`) === 'true';

    const count = parseInt(likeCommentCounts[index].textContent);

    if (liked) {
        likeCommentIcons[index].classList.remove('mdi-heart-outline');
        likeCommentIcons[index].classList.add('mdi-heart');
    } else {
        likeCommentIcons[index].classList.remove('mdi-heart');
        likeCommentIcons[index].classList.add('mdi-heart-outline');
    }

    likeCommentCounts[index].textContent = count + ' ' + (count === 1 ? 'like' : 'likes');
});
///////// dropdown
$(document).ready(function() {
    $('.dropdown-toggle').dropdown();
});
/// editmodal
var editmodal = document.getElementById("edit-post-modal");

var editbtn = document.getElementById("open-edit-modal-btn");

var editspan = document.getElementsByClassName("editclose")[0];

editbtn.onclick = function() {
    editmodal.style.display = "block";
}
editspan.onclick = function() {
    editmodal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target === editmodal) {
        editmodal.style.display = "none";
    }
}
/// delete modal
var deletemodal = document.getElementById("delete-post-modal");

var deletebtn = document.getElementById("open-delete-modal-btn");

var deletespan = document.getElementsByClassName("deleteclose")[0];

deletebtn.onclick = function() {
    deletemodal.style.display = "block";
}
deletespan.onclick = function() {
    deletemodal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target === deletemodal) {
        deletemodal.style.display = "none";
    }
}
