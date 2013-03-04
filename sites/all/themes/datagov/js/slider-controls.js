/**
 * Created with JetBrains PhpStorm.
 * User: christian.manalansan
 * Date: 10/10/12
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

(function ($) {

    $(document).ready(function() {
        var slideOffImg = '/sites/all/themes/datagov/images/slide-control-off.png';
        var slideOnImg = '/sites/all/themes/datagov/images/slide-control-on.png';

        $('#views_slideshow_cycle_teaser_section_community_hub_slideshow-ogpl_community_hub_slideshow_block').cycle({
            pager: '#slider-controls',
            pagerEvent: 'mouseover',
            pause: true,
            pauseOnPagerHover: true,
            pagerAnchorBuilder: function(idx, slide) { // callback fn that creates a thumbnail to use as pager anchor
                return '<li class="slider-control-item" title="' + $(slide.outerHTML).find('img:first').attr('alt') + '"></li>';
            }
        });
    });
})(jQuery);
