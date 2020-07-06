let skillBars = document.getElementsByClassName("skill-bar");

for(let i = 0; i < skillBars.length; i++){
    if(skillBars[i].getAttribute("aria-valuenow") >= 98){
        skillBars[i].style.borderRadius = "10px";
    }
    skillBars[i].style.width = skillBars[i].getAttribute("aria-valuenow") + "%";
}

let selector = "none";

let skills = document.getElementsByClassName("skills")[0];
let devButton = document.getElementById("devButton");
let infraButton = document.getElementById("infraButton");
let webButton = document.getElementById("webButton");
let otherButton = document.getElementById("otherButton");

let devSkills = document.getElementsByClassName("dev");
let infraSkills = document.getElementsByClassName("infra");
let webSkills = document.getElementsByClassName("web");
let otherSkills = document.getElementsByClassName("other");

ChangeSelector();

if(devButton !== undefined){
    devButton.onclick = () => {
        if(selector === "dev"){
            selector = "none";
            ChangeSelector();
            return;
        }
        selector = "dev";
        ChangeSelector();
    };

    infraButton.onclick = () => {
        if(selector === "infra"){
            selector = "none";
            ChangeSelector();
            return;
        }
        selector = "infra";
        ChangeSelector();
    };

    webButton.onclick = () => {
        if(selector === "web"){
            selector = "none";
            ChangeSelector();
            return;
        }
        selector = "web";
        ChangeSelector();
    };

    otherButton.onclick = () => {
        if(selector === "other"){
            selector = "none";
            ChangeSelector();
            return;
        }
        selector = "other";
        ChangeSelector();
    };
}

function ChangeSelector(){
    for(let i = 0; i < skills.children.length; i++){
        skills.children[i].style.display = "none";
    }
    switch(selector){
        case "none":
            for(let i = 0; i < skills.children.length; i++){
                skills.children[i].style.display = "flex";
            }
            break;
        case "dev":
            for(let i = 0; i < devSkills.length; i++){
                devSkills[i].style.display = "flex";
            }
            break;
        case "infra":
            for(let i = 0; i < infraSkills.length; i++){
                infraSkills[i].style.display = "flex";
            }
            break;
        case "web":
            for(let i = 0; i < webSkills.length; i++){
                webSkills[i].style.display = "flex";
            }
            break;
        case "other":
            for(let i = 0; i < otherSkills.length; i++){
                otherSkills[i].style.display = "flex";
            }
            break;
    }
}