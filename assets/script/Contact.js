let contactPanel = document.getElementById("ContactMe");

let button = document.getElementById("ContactButton");

let footer = document.getElementsByTagName("footer");


button.onclick = function(){

  contactPanel.style.display = "block";
  footer[0].style.height = 120 + "vh";
  contactPanel.scrollIntoView();
};
