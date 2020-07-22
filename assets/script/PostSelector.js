let selectors = document.getElementsByClassName("selectItem");
let posts = document.getElementsByClassName("post");
let selection = "none";

for(let i = 0; i < selectors.length; i++){
    selectors[i].onclick = () =>{
        if(selection === selectors[i].dataset.type){
            selection = "none";
        }else{
            selection = selectors[i].dataset.type;
        }
        ChangeSelection();
    };
}

ChangeSelection();

function ChangeSelection(){
    if(selection !== "none"){
        for(let i = 0; i < posts.length; i++){
            posts[i].style.display = "none";
        }
        let postsToShow = document.getElementsByClassName(selection);
        for(let i = 0; i < postsToShow.length; i++){
            postsToShow[i].style.display = "flex";
        }
    }else{
        for(let i = 0; i < posts.length; i++){
            posts[i].style.display = "flex";
        }
    }
}