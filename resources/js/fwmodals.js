var followingmodal = document.getElementById("followingmodal");

var followingbtn = document.getElementById("following-btn");

var followingspan = document.getElementsByClassName("followingclose")[0];

followingbtn.onclick = function() {
    followingmodal.style.display = "block";
}

followingspan.onclick = function() {
    followingmodal.style.display = "none";
}
window.onclick = function(event) {
    if (event.target === followingmodal) {
        followingmodal.style.display = "none";
    }
}
////////////////////////////////////////////////

var followersmodal = document.getElementById("followersmodal");

var followersbtn = document.getElementById("followers-btn");

var followerspan = document.getElementsByClassName("followersclose")[0];

followersbtn.onclick = function() {
    followersmodal.style.display = "block";
}

followerspan.onclick = function() {
    followersmodal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target === followersmodal) {
        followersmodal.style.display = "none";
    }
}
