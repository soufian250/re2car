$(document).ready(function(){

    var editor = new Quill('#editor', {
        modules: { toolbar: '#toolbar' },
        toolbar: [
            [{ header: [1, 2, false] }],
            ['bold', 'italic', 'underline'],
            ['image', 'code-block']
        ],
        placeholder: 'Votre Article...',
        theme: 'snow',
    });


    $("#post_title").keyup(function(e){
        let typedText = $(this).val();
        let sluggedText = slugifyInput(typedText);
        $("#post_slug").val(sluggedText);

    });

})

function slugifyInput(text) {

    const from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;"
    const to = "aaaaaeeeeeiiiiooooouuuunc------"

    const newText = text.split('').map(
        (letter, i) => letter.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i)))

    return newText
        .toString()                     // Cast to string
        .toLowerCase()                  // Convert the string to lowercase letters
        .trim()                         // Remove whitespace from both sides of a string
        .replace(/\s+/g, '-')           // Replace spaces with -
        .replace(/&/g, '-and-')           // Replace & with 'and'
        .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
        .replace(/\-\-+/g, '-');        // Replace multiple - with single -
}
