let addTypeButton = document.getElementById("addType");
let typeSection = document.getElementsByClassName("types")[0];
let e = document.getElementById("kw");
let typeNames = Array();

let types = document.getElementsByClassName("type");

for(let i = 0; i < types.length; i++){
    typeNames.push(types[i].value);
    const type = types[i];
    type.onclick = () => {
        const index = typeNames.indexOf(type.getAttribute("value"));
        if (index > -1) {
            typeNames.splice(index, 1);
        }
        type.remove();
        SetName();
    }
}

addTypeButton.onclick = () => {
    if(typeNames.includes(e.value)){
        return;
    }
    let input = document.createElement("input");
    input.readOnly = true;
    input.setAttribute("class", "type");
    input.setAttribute("value", e.value);
    typeSection.appendChild(input);
    typeNames.push(e.value);
    input.onclick = () => {
        const index = typeNames.indexOf(input.getAttribute("value"));
        if (index > -1) {
            typeNames.splice(index, 1);
        }
        input.remove();
        SetName();
    }
    e.value = "";
    SetName();
};

function SetName(){
    let types = document.getElementsByClassName("type");
    for(let i = 0; i < types.length; i++){
        types[i].setAttribute("name", "type-" + (i+1));
    }
}