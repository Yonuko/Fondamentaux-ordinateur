//Active l'animation des barres de compétences dès qu'on les voient.
function getElementOffset(id) {
    var dom = document.getElementById(id)
    var height = dom.offsetHeight

    var elem = document.querySelector("#" + id)
    var rect = elem.getBoundingClientRect()
    var scrollTop = window.pageYOffset || document.documentElement.scrollTop
    return rect.top + scrollTop + height - 500
}

let animOneTime = false;

window.addEventListener("scroll", function() {
    let progressBars = document.getElementsByClassName("progress-bar");

    if (window.scrollY >= getElementOffset("Competence") - 1000 && !animOneTime) {
      //Bar Animation---------
      animOneTime = true;
      for(let progressBar of progressBars){
        let maxValue = progressBar.dataset.maxValue;
        let width = 1;

        let barScroll = setInterval( WaitAnimToEnd, 15);

        function WaitAnimToEnd(){
          if (width >= maxValue) {
            clearInterval(barScroll);
          } else {
            width++;
            progressBar.style.width = width + '%';
          }
        }
      }
      //------------
    }
});