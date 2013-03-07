/**
 * Created with JetBrains PhpStorm.
 * User: christian.manalansan
 * Date: 10/10/12
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

(function ($) {

    $(document).ready(function() {
        var resizeTimer;

        function checkTogglePosition() {
            if ($(window).width() < 1200) { // move down
                $('.toggle-wrapper').addClass('lowered-toggle', 200);
            } else { // move to center
                $('.toggle-wrapper').removeClass('lowered-toggle', 200);
            }
        }

        $(window).resize(function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(checkTogglePosition, 100);
        });

        checkTogglePosition();
    });
})(jQuery);
