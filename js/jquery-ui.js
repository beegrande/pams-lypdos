/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



//TESTING JQUERY
//jQuery(document).ready(function($) {
//    $('.show_hide').hide();
//    $('h4').hover(
//            function() {
//                $aw = $(this).parent().find('.show_hide');
//                $aw.slideDown('fast');
//            },
//            function() {
//                $aw = $(this).parent().find('.show_hide');
//                $aw.slideUp('slow');
//            });
//});
//
//jQuery(document).ready(function($) {
//    $('.entry-summary').hide();
//    $('.hentry').css('margin-bottom', '10px');
//    $('header').hover(
//            function() {
//                $aw = $(this).parent().find('.entry-summary');
//                $aw.addClass('show_hide');
//                $aw.slideDown('fast');
//            },
//            function() {
//                $aw = $(this).parent().find('.entry-summary');
//                $aw.slideUp('slow');
//            });
//});


jQuery(document).ready(function ($) {
    $('.entry-summary').hide();
    $('.hentry').css('margin-bottom', '10px');
    $('header.entry-header').hover(
            function () {
                $aw = $(this).parent().find('.entry-summary');
                $aw.addClass('tooltip');
                $aw.fadeIn('fast');
            }, function () {
        $aw = $(this).parent().find('.entry-summary');
        $aw.fadeOut('fast');
    }).mousemove(
            function (e) {
                var mousex = e.pageX + 20;
                var mousey = e.pageY + 20;
                $('.tooltip')
                        .css({top: mousey, left: mousex})
            });
});