const scrollDown = document.getElementById('scrollDown');
scrollDown.addEventListener('click', goScrollDown)

function goScrollDown(){
    window.scroll(0, window.innerHeight);
}

const scrollUp = document.getElementById('scrollUp');
scrollUp.addEventListener('click', goScrollUp)

function goScrollUp(){
    window.scroll(0,-window.innerHeight);
}