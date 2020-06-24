let skillBars = document.getElementsByClassName("skill-bar");

for(let i = 0; i < skillBars.length; i++){
    if(skillBars[i].getAttribute("aria-valuenow") >= 98){
        skillBars[i].style.borderRadius = "10px";
    }
    skillBars[i].style.width = skillBars[i].getAttribute("aria-valuenow") + "%";
}