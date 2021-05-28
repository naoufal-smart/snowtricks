
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

    // event listener
    const delete_image_textarea_icon = newImage.querySelector('.delete');
    delete_image_textarea_icon.addEventListener('click', function(e){
        e.preventDefault();
        newImage.parentElement.removeChild(newImage);
    })
})