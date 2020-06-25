"use strict";

let notificationButton = document.getElementById("bell");
let notificationContent = document.getElementById("notif-content");
let notificationCross = notificationContent.getElementsByClassName("close");
let notificationCount = document.getElementById("num");

let notificationObjects = document.getElementsByClassName("notification-content")[0].children;

let activated = false;
let stayOpen = false;

// Check if main should be 95% or not
// TODO:: change the percente by the height of page - height of header
resizeMain();
window.addEventListener('resize', () =>{
    resizeMain();
});

function resizeMain(){
    let mainElement = document.getElementsByTagName("main")[0];
    let headerHeight = document.getElementsByTagName("header")[0].offsetHeight;
    // 50 is the height of the menu
    if(mainElement.offsetHeight - (headerHeight - 50) > 0){
        mainElement.style.height = (headerHeight - 50) + "px";
    }else{
        mainElement.style.height = "auto";
    }
}

function notificationCloseButton(){
    stayOpen = false;
    activated = false;
    notificationContent.style.display = "none";
}

function readNotif(id){
    let notification = document.getElementById("notification-" + id);
    if(!notification.classList.contains("notSeen")){
        return;
    }
    notification.classList.remove("notSeen");
    DecreaseNotifCount();
}

function CountNotification(){
    let count = 0;
    for(let i = 0; i < notificationObjects.length; i++){
        if(notificationObjects[i].classList.contains("notSeen")){
            count ++;
        }
    }
    UpdateNotifCount(count);
}

function DecreaseNotifCount(){
    let count = parseInt(notificationCount.innerHTML);
    count--;
    UpdateNotifCount(count);
}

function UpdateNotifCount(count){
    notificationCount.innerHTML = count;
    if(count === 0){
        notificationCount.style.display = "none";
    }else{
        notificationCount.style.display = "flex";
    }
}

function removeNotif(id){
    let notification = document.getElementById("notification-" + id);
    notification.style.opacity = '0';
    setTimeout(function(){notification.remove();}, 200);
}

notificationContent.addEventListener("mousedown", () => {
    stayOpen = true;
});

notificationContent.addEventListener("mouseleave", () => {
    stayOpen = false;
});

notificationButton.addEventListener("mouseup", () => {
    if(activated){
        activated = false;
        notificationContent.style.display = "none";
    }else{
        notificationContent.style.display = "block";
        activated = true;
    }
});

document.getElementsByTagName("body")[0].addEventListener("mousedown", () => {
    if(!activated || stayOpen){
        return;
    }
    activated = false;
    notificationContent.style.display = "none";
});

CountNotification();