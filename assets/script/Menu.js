let isOnMainPanel = false;

let cvWindow = document.getElementById("CV");

//Gère le button du CV
let cvButton = document.getElementsByTagName('button');
cvButton[0].onclick = function(){

  cvWindow.style.display = "block";
  document.getElementsByTagName("body")[0].style.overflow = "none";

};

//Gère l'apparition du menu--
let menu = document.getElementsByClassName("Menu");

let sectionTab = [null,null,null,null, null];

sectionTab[0] = document.getElementById("Accueil");
sectionTab[1] = document.getElementById("A-propos");
sectionTab[2] = document.getElementById("Projets");
sectionTab[3] = document.getElementById("Competence");
sectionTab[4] = document.getElementById("Contact");

for(let i = 0; i < menu[0].children[0].childElementCount; i ++){

  sectionTab[i].addEventListener("mouseover", function( ) {
    if(i == 0){
      MakeDesapearMenu();
      isOnMainPanel = false;
    }else {
      if(!isOnMainPanel) {
        ShowMenu();
      }
      ColorTheSelectedIndex(i);
    }
  });

  menu[0].children[0].children[i].children[0].onclick = function( ) {
    if(i == 0){
      MakeDesapearMenu();
      isOnMainPanel = true;
    }else {
      ShowMenu();
      ColorTheSelectedIndex(i);
    }
  };
}

let closeButton = document.getElementsByClassName("Close");
for(let i = 0; i < closeButton.lenght; i++){
  closeButton[i].onclick = function(){
    closeButton();
  }
}
//----------

function MakeDesapearMenu(){
  menu[0].style.display = "none";
}

function ShowMenu(){
  menu[0].style.display = "block";
}

function ColorTheSelectedIndex(index){
  for(let i = 0; i < menu[0].children[0].childElementCount; i++){
    if(index == i){
      menu[0].children[0].children[i].children[0].style.color = "orange";
    }else {
      menu[0].children[0].children[i].children[0].style.color = "black";
    }
  }
}

function CloseWindow(){
  cvWindow.style.display = "none";
}
