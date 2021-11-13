require('./bootstrap');

import ClassicEditor from '@ckeditor/ckeditor5-build-classic/build/ckeditor';

const ready = (callback) => {
    if (document.readyState !== "loading") callback();
    else document.addEventListener("DOMContentLoaded", callback);
}

ready(() => {
    ClassicEditor
        .create(document.querySelector('.ckeditorContent'))
        .then( editor => {
            editor.ui.view.editable.element.style.height = '300px';
        } )
        .catch(error => {
            console.log(`error`, error)
        });
});


