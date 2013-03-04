/**
 * Created with JetBrains PhpStorm.
 * User: christian.manalansan
 * Date: 10/10/12
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

/**
 * The 'Upcoming Events' View does not give me the proper date format for the dateblocks, so this postprocessor
 * converts a Unix timestamp to the desired date format
 */

(function ($) {

    $(document).ready(function() {
        $('.view-community-activity-feed-content.view-display-id-ogpl_community_event_block .views-field-field-date .field-content').each(function() {
            var thisDate = new Date(parseInt($(this).html()) * 1000); // unix timestamp > js timestamp > js date
            var months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']
            var monthLabel = months[thisDate.getMonth()];
            var dateLabel = thisDate.getDate();

            $(this).html('<div class="wrapper"><div class="datebox-container"><div class="month">' + monthLabel + '</div><div class="date">' + dateLabel + '</div></div></div>');
        });
        $('.view-community-activity-feed-content.view-display-id-ogpl_community_event_block .views-row').append('<div class="clearfloat"></div>');
    });
})(jQuery);
