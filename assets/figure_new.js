// Ajouter une vidéo
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
    const delete_video_textarea_icon = newVideo.querySelector('.delete');
    delete_video_textarea_icon.addEventListener('click', function(e){
        e.preventDefault();
        newVideo.parentElement.removeChild(newVideo);
    })
})

// Toggle le champ de saisie pour modifier la video
const edit_video_icons = document.querySelectorAll('body.figure-edition .list.videos .video .update');
let video_field;
Array.from(edit_video_icons).forEach(function(icon){
    icon.addEventListener('click', function(e){
        e.preventDefault();
        video_field = e.currentTarget.closest('.video').querySelector('.edit');
        video_field.classList.toggle('visible');
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


// Ajouter l'image principale
const add_main_image = document.getElementById('add_main_image');
add_main_image.addEventListener('click', (e) => {
    const mainPicturePlacHolder = document.querySelector('#mainPicture');
    let index = 0;
    let newImgForm = e.currentTarget.getAttribute('data-prototype');
    newImgForm = newImgForm.replace(/__name__/g, index);
    let newImage = document.createElement('div');
    newImage.classList.add('media');
    newImage.classList.add('picture');
    newImage.innerHTML = newImgForm;
    newImage.innerHTML += `<div class="controls">
                <a href="#" class="control delete"><i class="fas fa-trash-alt"></i></a>
            </div>`

    mainPicturePlacHolder.appendChild(newImage);

    // event listener
    const delete_image_textarea_icon = newImage.querySelector('.delete');
    delete_image_textarea_icon.addEventListener('click', function(e){
        e.preventDefault();
        newImage.parentElement.removeChild(newImage);
    })
})

// Ajouter une image
const add_image = document.getElementById('add_image');
add_image.addEventListener('click', (e) => {
    const picturesList = document.querySelector('.list.pictures');
    const imgPrototype = picturesList.getAttribute('data-prototype');
    let index = picturesList.children.length + 1;
    let newImgForm = imgPrototype;
    newImgForm = newImgForm.replace(/__name__/g, index);
    let newImage = document.createElement('div');
    newImage.classList.add('media');
    newImage.classList.add('picture');
    newImage.innerHTML = newImgForm;
    newImage.innerHTML += `<div class="controls">
                <a href="#" class="control delete"><i class="fas fa-trash-alt"></i></a>
            </div>`

    picturesList.appendChild(newImage);

    // Supprimer une image
    const delete_image_textarea_icon = newImage.querySelector('.delete');
    delete_image_textarea_icon.addEventListener('click', function(e){
        e.preventDefault();
        newImage.parentElement.removeChild(newImage);
    })
})