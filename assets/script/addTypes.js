let addTypeButton = document.getElementById("addType");
let typeSection = document.getElementsByClassName("types")[0];
let e = document.getElementById("typeSelect");
let typeNames = Array();

addTypeButton.onclick = () => {
    if(typeNames.includes(e.options[e.selectedIndex].value)){
        return;
    }
    let input = document.createElement("input");
    input.readOnly = true;
    input.setAttribute("class", "type");
    input.setAttribute("value", e.options[e.selectedIndex].value);
    typeSection.appendChild(input);
    typeNames.push(e.options[e.selectedIndex].value);
    input.onclick = () => {
        const index = typeNames.indexOf(input.getAttribute("value"));
        if (index > -1) {
            typeNames.splice(index, 1);
        }
        input.remove();
        SetName();
    }
    SetName();
};

function SetName(){
    let types = document.getElementsByClassName("type");
    for(let i = 0; i < types.length; i++){
        types[i].setAttribute("name", "type-" + (i+1));
    }
}