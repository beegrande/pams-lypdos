/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

jQuery(document).ready(function ($) {

    $.ajaxSetup({cache: false});

    //$('.entry-summary').hide();
    //$('.hentry').css('margin-bottom', '10px');
    $('li.page_item').hover(
            function (e) {
                var post_link = $(this).find('a').attr("href");
                //alert($post_link.parent().toString());
                $aw = $(this).closest('li').parent();
                $aw.addClass('single-post-container');
                //var mousex = e.pageX + 20;
                //var mousey = e.pageY + 20;
                //$('.tooltip')
                //        .css({top: mousey, left: mousex})
                //$aw.fadeIn('slow');
                $aw.html("content loading");
                $aw.load(post_link);
                $('.single-post-container').dialog({
                    modal: true,
                    draggable: true,
                    resizable: true,
                    position: ['center', 'top'],
                    show: 'blind',
                    hide: 'blind',
                    width: 400, buttons: {
                        Ok: function () {
                            $(this).dialog("close");
                        }
                    }
                });
            }, function () {
        $aw = $(this).closest('li').parent();
        $aw.removeClass('single-post-container');
        //$aw.fadeOut('fast');
    }).mousemove(
            function (e) {
//                var mousex = e.pageX + 20;
//                var mousey = e.pageY + 20;
//                $('.tooltip')
//                        .css({top: mousey, left: mousex})
            });


//    $(".post-link").click(function () {
//        var post_link = $(this).attr("href");
//
//        $("#single-post-container").html("content loading");
//        $("#single-post-container").load(post_link);
//        return false;
});
