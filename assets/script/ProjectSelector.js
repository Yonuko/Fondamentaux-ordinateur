let selectors = document.getElementsByClassName("selectItem");
let posts = document.getElementsByClassName("project");
let subSelectors = document.getElementsByClassName("subSelector");
let projectLists = document.getElementsByClassName("project-list");
let selection = "none";

for(let i = 0; i < selectors.length; i++){
    selectors[i].onclick = () =>{
        if(selection === selectors[i].dataset.type){
            if(selectors[i].dataset.subType !== "none"){
                selection = selectors[i].dataset.subType;
            }else{
                selection = "none";
            }
        }else{
            selection = selectors[i].dataset.type;
        }
        ChangeSelection();
    };
}

ChangeSelection();

function ChangeSelection(){
    for(let i = 0; i < subSelectors.length; i++){
        subSelectors[i].style.display = "none";
    }
    if(selection !== "none"){
        for(let i = 0; i < posts.length; i++){
            posts[i].style.display = "none";
        }
        let button = document.getElementById(selection);
        if(button.dataset.subType === "none"){
            let subSelector = document.getElementsByClassName("sub_type_" + selection)[0];
            if(subSelector !== undefined){
                subSelector.style.display = "flex";
            }
        }else{
            let subSelector = document.getElementsByClassName("sub_type_" + button.dataset.subType)[0];
            subSelector.style.display = "flex";
        }
        let postsToShow = document.getElementsByClassName(selection);
        for(let i = 0; i < postsToShow.length; i++){
            postsToShow[i].style.display = "flex";
        }
        // Disable all list of project thta don't have any project_available
        for(let i = 0; i < projectLists.length; i++){
            let activeChildCount = 0;
            let children = projectLists[i].children;
            for(let j = 0; j < children.length; j++){
                if(children[j].style.display === "flex"){
                    activeChildCount++;
                }
            }
            if(activeChildCount === 0){
                projectLists[i].style.display = "none";
            }else{
                projectLists[i].style.display = "flex";
            }
        }
    }else{
        for(let i = 0; i < posts.length; i++){
            posts[i].style.display = "flex";
        }
        for(let i = 0; i < projectLists.length; i++){
            projectLists[i].style.display = "flex";
        }
    }
}