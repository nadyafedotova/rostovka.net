var ti_clipboard = document.getElementsByClassName("ti-clipboard");
var href = document.getElementsByClassName("href");
for(var i=0;i<ti_clipboard.length;i++) {
    var index = i;
    ti_clipboard[i].addEventListener("click",listener.bind(null,i));
}

function listener(index) {
   href[index].select();
   document.execCommand("Copy");
}