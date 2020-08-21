let postLogo = document.getElementById("postLogo");
let imageScale = postLogo.naturalHeight / postLogo.naturalWidth;
postLogo.style.maxHeight = postLogo.offsetWidth * imageScale + "px";
window.onresize = () => {
    postLogo.style.maxHeight = postLogo.offsetWidth * imageScale + "px";
};