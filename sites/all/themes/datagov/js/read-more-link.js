/**
 * Created with JetBrains PhpStorm.
 * User: christian.manalansan
 * Date: 10/10/12
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

(function ($) {

    $(document).ready(function() {
        $('.read-more-button').click(function(){
            window.location.href = $('.views_slideshow_slide :visible a:first').attr('href');
        });
    });
})(jQuery);
