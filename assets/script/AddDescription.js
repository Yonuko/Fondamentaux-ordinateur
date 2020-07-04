let count = 1;

let descriptionHolder = document.getElementById("Descriptions");
let addDescriptionButton = document.getElementById("addDesc");
let removeDescriptionButton = document.getElementById("removeDesc");
let expendObject = document.getElementsByClassName("expend");
let firstDescription = document.getElementById("description-1");

for(let i = 0; i < expendObject.length; i++){
    expendObject[i].onclick = () =>{
        if(expendObject[i].classList.contains("toggle")){
            expendObject[i].classList.remove("toggle");
            firstDescription.style.display = "none";
        }else{
            expendObject[i].classList.add("toggle");
            firstDescription.style.display = "block";
        }
    };
}

removeDescriptionButton.onclick = () =>{
    document.getElementById("description-ckeditor-" + count).remove();
    document.getElementById("description-" + count).remove();
    document.getElementById("description-label-" + count).remove();
    document.getElementById("subName-" + count).remove();
    document.getElementById("subName-label-" + count).remove();
    count--;
    if(count === 1){
        removeDescriptionButton.style.display = "none";
    }
}

addDescriptionButton.onclick = () =>{
    count++;
    let descriptionLabel = document.createElement("label");
    let descriptionTextArea = document.createElement("textarea");
    let arrowImg = document.createElement("img");
    let labelDiv = document.createElement("div");
    let subTitleLabel = document.createElement("label");
    let subTitleName = document.createElement("input");

    subTitleLabel.setAttribute("for", "subName-" + count);
    subTitleLabel.setAttribute("id", "subName-label-" + count);
    subTitleLabel.innerHTML = "Sous titre paragraphe " + count;

    subTitleName.setAttribute("type", "text");
    subTitleName.setAttribute("name", "subName-" + count);
    subTitleName.setAttribute("id", "subName-" + count);

    labelDiv.classList.add("toggler");
    labelDiv.setAttribute("id", "description-label-" + count);

    descriptionTextArea.setAttribute("name", "description-" + count);
    descriptionTextArea.setAttribute("id", "description-" + count);
    
    arrowImg.classList.add("expend");
    arrowImg.classList.add("toggle");
    arrowImg.src = "http://localhost/portfolio/assets/image/ArrowIcon.png";
    
    descriptionHolder.appendChild(subTitleLabel);
    descriptionHolder.appendChild(subTitleName);

    descriptionLabel.appendChild(arrowImg);
    descriptionLabel.setAttribute("for", "description-" + count);
    descriptionLabel.innerHTML = "Description (paragraphe) " + count;

    labelDiv.appendChild(arrowImg);
    labelDiv.appendChild(descriptionLabel);

    descriptionHolder.appendChild(labelDiv);
    descriptionHolder.appendChild(descriptionTextArea);

    ClassicEditor
    .create( document.querySelector( '#description-' + count ) )
    .then( editor => {
        console.log( 'Editor was initialized', editor );
    } )
    .catch( error => {
        console.error( error );
    } );

    if(count >= 1){
        removeDescriptionButton.style.display = "block";
    }

    addIDToCKeditor();
};

function addIDToCKeditor(){
    let editors = document.getElementsByClassName("ck-editor");
    let arrowImgs = document.getElementsByClassName("expend");
    for(let i = 0; i < editors.length; i++){
        editors[i].setAttribute("id", "description-ckeditor-" + count);
        arrowImgs[i].onclick = () =>{
            if(arrowImg.classList.contains("toggle")){
                arrowImg.classList.remove("toggle");
                editors[i].style.display = "none";
            }else{
                arrowImg.classList.add("toggle");
                editors[i].style.display = "block";
            }
        };
    }
}