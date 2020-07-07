let burger = document.getElementsByClassName('burger');
let menu = document.getElementsByTagName("header")[0].getElementsByClassName("menu")[0];
let body = document.getElementsByTagName("body")[0];
let open = false;
for(let i = 0; i < burger.length; i++){
    burger[i].onclick  = () => {
        for(let j = 0; j < burger.length; j++){
            burger[j].classList.toggle('active-one');
        }
        open = !open;
        if(open){
            menu.style.display = "flex";
            body.style.overflow = "hidden";
        }else{
            menu.style.display = "none";
            body.style.overflow = "auto";
        }
    };
}