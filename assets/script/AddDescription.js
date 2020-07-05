let count = 1;

let descriptionHolder = document.getElementById("Descriptions");
let addDescriptionButton = document.getElementById("addDesc");
let removeDescriptionButton = document.getElementById("removeDesc");
let expendObject = document.getElementsByClassName("expend");

addIDToCKeditor();

removeDescriptionButton.onclick = () =>{
    document.getElementById("description-ckeditor-" + count).remove();
    document.getElementById("description-textarea-" + count).remove();
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
    subTitleLabel.setAttribute("class", "label");
    subTitleLabel.innerHTML = "Sous titre paragraphe " + count;

    subTitleName.setAttribute("type", "text");
    subTitleName.setAttribute("name", "subName-" + count);
    subTitleName.setAttribute("id", "subName-" + count);

    labelDiv.classList.add("toggler");
    labelDiv.setAttribute("id", "description-label-" + count);

    descriptionTextArea.setAttribute("name", "description-" + count);
    descriptionTextArea.setAttribute("id", "description-textarea-" + count);
    
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
    .create( document.querySelector( '#description-textarea-' + count ) )
    .then(editor => {
        addIDToCKeditor();
    })
    .catch( error => {
        console.error( error );
    } );

    if(count >= 1){
        removeDescriptionButton.style.display = "block";
    }
};

function addIDToCKeditor(){
    let editorsCollection = descriptionHolder.getElementsByClassName("ck-editor");
    let editors = Array.prototype.slice.call( editorsCollection );
    let arrowImgs = document.getElementsByClassName("expend");
    console.log(editors.length);
    for(let i = 0; i < editors.length; i++){
        editors[i].setAttribute("id", "description-ckeditor-" + (i+1));
        arrowImgs[i].onclick = () =>{
            if(arrowImgs[i].classList.contains("toggle")){
                arrowImgs[i].classList.remove("toggle");
                editors[i].style.display = "none";
            }else{
                arrowImgs[i].classList.add("toggle");
                editors[i].style.display = "block";
            }
        };
    }
}