/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';


const add_video = document.getElementById('add_video');
add_video.addEventListener('click', (e) => {
    const videosList = document.querySelector('.list.videos');
    const prototype = videosList.getAttribute('data-prototype');
    let index = videosList.children.length;
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    let newVideo = document.createElement('div');
    newVideo.innerHTML = newForm;
    videosList.appendChild(newVideo);
})
