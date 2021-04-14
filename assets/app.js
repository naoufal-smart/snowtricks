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

// Ajouter une vidéo dynamiquement
const add_video = document.getElementById('add_video');
add_video.addEventListener('click', (e) => {
    const videosList = document.querySelector('.list.videos');
    const prototype = videosList.getAttribute('data-prototype');
    let index = videosList.children.length;
    let newForm = prototype;
    newForm = newForm.replace(/__name__/g, index);
    let newVideo = document.createElement('div');
    newVideo.classList.add('media');
    newVideo.classList.add('video');
    newVideo.innerHTML = newForm;
    newVideo.innerHTML += `<div class="controls">
                <a href="#" class="control delete"><i class="fas fa-trash-alt"></i></a>
            </div>`

    videosList.appendChild(newVideo);

    // event listener
    const delete_videao_textarea_icon = newVideo.querySelector('.delete');
    delete_videao_textarea_icon.addEventListener('click', function(e){
        e.preventDefault();
        newVideo.parentElement.removeChild(newVideo);
    })
})

// Toggle le champ de saisie pour modifier la video
const edit_video_icons = document.querySelectorAll('body.figure-edition .list.videos .video .update');
let field;
Array.from(edit_video_icons).forEach(function(icon){
   icon.addEventListener('click', function(e){
       e.preventDefault();
       field = e.currentTarget.closest('.video').querySelector('.edit');
       field.classList.toggle('visible');
   })
});

// Supprimer une video
const delete_video_icon = document.querySelectorAll('body.figure-edition .list.videos .video .delete')
let video;
Array.from(delete_video_icon).forEach(function(icon){
    icon.addEventListener('click', function(e){
        e.preventDefault();
        video = e.currentTarget.closest('.video');
        video.parentElement.removeChild(video);
    })
});



