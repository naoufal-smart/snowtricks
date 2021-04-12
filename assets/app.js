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
    newVideo.innerHTML = newForm;
    videosList.appendChild(newVideo);
})

// Afficher ou masquer le champ de saisi "nouveau groupe"
const new_group_field = document.getElementById('figure_new_group');
new_group_field.parentElement.style.display = 'none';

const figure_group_field = document.getElementById('figure_group');
figure_group_field.addEventListener('change', function(e){
    if(this.value == 'add'){
        new_group_field.parentElement.style.display = 'block';
        new_group_field.required = true;
    }else{
        new_group_field.parentElement.style.display = 'none';
        new_group_field.parentElement.required = false;
    }
})


