/**
 * Created with JetBrains PhpStorm.
 * User: christian.manalansan
 * Date: 10/10/12
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

(function ($) {

    $(document).ready(function() {
        // hide views that are not shown by default
        // TODO: make it less hacky
        $('.start-hidden').hide();
        $('.start-hidden').removeClass('start-hidden');


        $('.toggle-control').click(function(){
            if($('.events-wrapper').is(':hidden')) { // events toggle clicked
                $('.features-wrapper').toggle("slide", { direction: "left" }, 250, function() {
                    $('.events-wrapper').toggle("slide", { direction: "right" }, 250);
                });
                $('.events-toggle').toggle("fade", { }, 100, function() {
                    $('.features-toggle').toggle("fade", { easing: 'easeInExpo' }, 1000);
                });
            }
            else { // features toggle clicked
                $('.events-wrapper').toggle("slide", { direction: "left" }, 250, function() {
                    $('.features-wrapper').toggle("slide", { direction: "right" }, 250);
                });
                $('.features-toggle').toggle("fade", { }, 100, function() {
                    $('.events-toggle').toggle("fade", { easing: 'easeInExpo' }, 1000);
                });
            }
        });

        // PRA text on 'Contact Us' page
        $('.pra-text-toggle').click(function() {
            $('.pra-text-toggle').toggle();
        });
    });
})(jQuery);
