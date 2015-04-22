jQuery(document).ready(function ($) {

    $('#linkyBox').masonry({
        singleMode: true,
        columnWidth: 192,
        itemSelector: '.boxy',
        isResizable: true
    });

    $('.floating-box-wrapper').masonry({
        singleMode: true,
        itemSelector: '.floating-box',
        gutterWidth: 20,

    });

    var container = $('.floating-image-wrapper');
//    var msnry;
//    imagesLoaded( container, function() {
//    msnry = new Masonry( container, {
//        itemSelector: '.floating-image'
//    });
    container.imagesLoaded(function () {
        container.masonry({
            singleMode: true,
            itemSelector: '.floating-image',
            isResizable: true,
                    //columnWidth : 240
        });
    });
});