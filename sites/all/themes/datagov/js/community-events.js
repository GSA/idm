/**
 * Created with JetBrains PhpStorm.
 * User: christian.manalansan
 * Date: 10/10/12
 * Time: 3:48 PM
 * To change this template use File | Settings | File Templates.
 */

(function ($) {

    $(document).ready(function() {
        var ajaxUrl = "/community-events-fields/";
        var today = new Date();
        fillCalendarDots(today.getFullYear() + '' + ('00' + (today.getMonth() + 1)).slice(-2)); // normally returns 0-11, we want 01-12

        $("tr.days td:not(.noday, .selected)").click(function(ev) {
            $(this).addClass('gldp-default-selected');
        });

        $("#events-calendar").glDatePicker({
            showAlways: true,
            position: 'inherit',
            selectedDate: new Date(),
            onChange: function(target, newDate) {
                fetchEvents(target, newDate, true, ajaxUrl);
            }
        });
        // by default: highlight today and fetch today's events
            fetchEvents($(".gldp-default-monyear"), today, true, ajaxUrl);

        $('body').delegate('.gldp-default-monyear', 'click', function(ev) { // TODO: convert to using .on() when using jQuery1.7+
            $('.events-list-view').html('<h3>Fetching events for ' + $(this).html() + '</h3>');
            var newDate = new Date(Date.parse('1 ' + $(this).html()));
            deselect();
            chooseMonth();
            fetchEvents($(".gldp-default-monyear"), newDate, false, ajaxUrl);
        });
        $('body').delegate('.gldp-default-prevnext', 'click', function(ev) { // TODO: convert to using .on() when using jQuery1.7+
            var newDate = new Date(Date.parse('1 ' + $('.gldp-default-monyear').html()));
            fillCalendarDots(newDate.getFullYear() + '' + ('00' + (newDate.getMonth() + 1)).slice(-2));
        });

        function deselect() {
            $('.gldp-days')
                .removeClass('gldp-default-selected')
                .removeClass('gldp-default-day-hover')
                .removeClass('gldp-default-sat-hover')
                .removeClass('gldp-default-sun-hover')
                .removeClass('selected');
            $('.gldp-days div').removeClass('selected');
        }

        function fetchEvents(target, newDate, isDay, url) {
            var newData = {
                year : newDate.getFullYear(),
                month : ('00' + (newDate.getMonth() + 1)).slice(-2), // normally returns 0-11, we want 01-12
                mode : 'html'
            };
            var param = newData.year + '' + newData.month;

            if (isDay) { // getting events for a day
                $('.events-list-view').html('<h3>Fetching events for ' + newDate.toDateString() + '</h3>');
                newData.date = ('00' + (newDate.getDate())).slice(-2); // normally returns 1-31, we want 01-31
                param += newData.date;
            } else { // getting events for a month
                $('.events-list-view').html('<h3>Fetching events for ' + target.html() + '</h3>');
            }

            // handle fetching of events
            bodyContent = $.ajax({
                url: url + param,
                global: false,
                type: "POST",
                data: {},
                dataType: "html",
                success: function(msg){
                    $('.events-list-view').html(msg);

                    $('.preloads.event-timestamps').each(function() {
                        var dateRange = $(this).html();
                        var dateRangeParts = dateRange.split(' to ');
                        var startTS = parseInt($.trim(dateRangeParts[0])) * 1000; // convert unix timestamp > js timestamp
                        var endTS = parseInt($.trim(dateRangeParts[1])) * 1000; // convert unix timestamp > js timestamp
                        if (!endTS) {
                            endTS = startTS;
                        }
                        var endDate = new Date(endTS);
                        if (endDate < new Date()) {
                            $(this).parent().addClass('past-event');
                        }
                    });
                }
            }).responseText;
        }
        function chooseMonth() {
            $("tr.days td:not(.noday)")
                .addClass('gldp-default-selected')
                .addClass('selected');
            $('tr.days td:not(.noday) div').addClass('selected');
        }
        function fillCalendarDots(param) { // param format = 'YYYYMM'
            // handle fetching of events
            bodyContent = $.ajax({
                url: '/eventcsv/' + param + '/count.csv',
                global: false,
                type: "POST",
                data: {},
                dataType: "html",
                success: function(msg){
                    // loop through lines of the file to create an array
                    var calItems = msg.split("\n");
                    var eventCount = [];

                    for (i in calItems) {
                        // I am expecting either:
                        // a single timestamp - e.g.: 1355164500
                        // or a timestamp range - e.g.: 1355077800 to 1356546600
                            var dateRangeParts = calItems[i].split(' to ');
                            var startTS = parseInt($.trim(dateRangeParts[0])) * 1000; // convert unix timestamp > js timestamp
                            var endTS = parseInt($.trim(dateRangeParts[1])) * 1000; // convert unix timestamp > js timestamp

                        var startDate = new Date(startTS);
                        if (!startTS) continue;
                        if (!endTS) { // deal with the single timestamp, add a calendar dot
                            if (startDate.getDate) {
                                if (!eventCount[startDate.getDate()]++) {
                                    eventCount[startDate.getDate()] = 1;
                                }
                            }
                        } else { // deal with the timestamp range, add a dot for every date in that range
                            var monthStartDate = new Date(parseInt(param.substr(0, 4)), parseInt(param.substr(4, 2), 10) - 1);
                            var monthStartTS = monthStartDate.getTime();
                            var endDate = new Date(endTS);
                            startDate = new Date(Math.max(startTS, monthStartTS)); // start at event start or month start, whichever comes LAST
                            for (
                                startDate.setHours(0, 0);
                                (startDate.getMonth() == monthStartDate.getMonth()) && (startDate <= endDate); // keep going until event end or month end, whichever comes FIRST
                                startDate.setDate(startDate.getDate() + 1)
                            ) { // loop from [start] to [end], or [start] to [end of month] - whichever comes soonest
                                if (!eventCount[startDate.getDate()]++) {
                                    eventCount[startDate.getDate()] = 1;
                                }
                            }
                        }
                    }

                    // loop through the array to generate markup for dots
                    $("tr.days td:not(.noday)").each(function (index) {
                        var thisDate = index + 1; // date is not zero-based like index is, so adjust the index
                        if (eventCount[thisDate]) {
                            switch (eventCount[thisDate]) {
                                case 1:
                                    $(this).addClass('one-event');
                                    break;
                                case 2:
                                    $(this).addClass('two-events');
                                    break;
                                case 3:
                                    $(this).addClass('three-events');
                                    break;
                                default:
                                    $(this).addClass('many-events');
                            }
                        }
                    });
                }
            }).responseText;
        }
    });
})(jQuery);
