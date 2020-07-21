let sliders = document.getElementsByClassName("skill-slider");
let values = document.getElementsByClassName("value");
let newSkillBars = document.getElementsByClassName("skill-bar");

for(let i = 0; i < sliders.length; i++){
    sliders[i].addEventListener("input", (e) => {
        if(e.target.value < 1){
            e.target.value = 1;
        }else if (e.target.value > 100){
            e.target.value = 100;
        }
        values[i].value = e.target.value;
        newSkillBars[i].setAttribute("aria-valuenow", values[i].value);
        if(newSkillBars[i].getAttribute("aria-valuenow") >= 98){
            newSkillBars[i].style.borderRadius = "10px";
        }
        newSkillBars[i].style.width = newSkillBars[i].getAttribute("aria-valuenow") + "%";
    });

    values[i].addEventListener("input", (e) => {
        if(e.target.value < 1){
            e.target.value = 1;
        }else if (e.target.value > 100){
            e.target.value = 100;
        }
        sliders[i].value = e.target.value;
        newSkillBars[i].setAttribute("aria-valuenow", values[i].value);
        if(newSkillBars[i].getAttribute("aria-valuenow") >= 98){
            newSkillBars[i].style.borderRadius = "10px";
        }
        newSkillBars[i].style.width = newSkillBars[i].getAttribute("aria-valuenow") + "%";
    });
}
