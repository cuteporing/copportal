var calendar = {

    init: function() {

        /**
         * Get current date
         */
        var d = new Date();
        var strDate       = d.getFullYear() + "/" + (d.getMonth() + 1) + "/" + d.getDate();
        var manilaOffset  = 8*60*60000;
        var userOffset    = d.getTimezoneOffset()*60000;
        var manilaTime   = new Date(d.getTime()+manilaOffset+userOffset);
        var currentMonth  = manilaTime.getMonth()+1;
        var currentYear   = manilaTime.getFullYear();

        getCalendar(currentMonth, currentYear);


        function getCalendar(month, year){
            console.log('month',month);
            console.log('year',year);
            var url = 'http://localhost/copportal/events_ajax/calendar/'+year+'/'+month;
            $.get( url, function( data ) {
                // console.log( data );
                var result = JSON.parse(data);
                // console.log("RESULT: ");
                // console.log("--------------------------------------");
                // console.log( result );


                var list = '';

                $(".list").html(list);

                if( result.events.length > 0){
                    for (var i = 0; i < result.events.length; i++) {
                        result.events[i].description = result.events[i].description.replace('<span>', '');
                        result.events[i].description = result.events[i].description.replace('</span>', '');
                        list = '<h2 class="title" style="margin-left:1.25em;">'+result.events[i].title+'</h2>';
                        list+= '<a class="close fontawesome-remove fa fa-times"></a>';
                        list+= '<p class="date">'+result.events[i].date+'</p>';
                        list+= '<p>'+result.events[i].description+'</p>';
                        list+= '<a href="'+result.events[i].slug+'">';
                        list+= '<span>Read more!</span>';
                        list+= '</a><br>';

                        if( result.events[i].date_month < 10 ){
                            result.events[i].date_month = result.events[i].date_month.replace('0', "");
                        }

                        if( result.events[i].date_day < 10 ){
                            result.events[i].date_day = result.events[i].date_day.replace('0', "");
                        }

                        var div = document.createElement("div");
                        div.className  = 'day-event';
                        div.setAttribute('date-month', result.events[i].date_month);
                        div.setAttribute('date-day', result.events[i].date_day);
                        div.innerHTML = list;

                        $(".list").append(div)
                    }
                }

                var calendar = '';
                var row = 0;
                for (var i = 0; i < result.dates.length; i++) {
                    if( row > 6 ) {
                        calendar = calendar + '</tr>';
                        row = 0;
                    }

                    if( row == 0 ){
                        calendar = calendar + '<tr>';
                    }

                    calendar = calendar + result.dates[i];

                    row++;
                }


                $('.calendar table tbody').html( calendar );

                 /**
                 * Get current day and set as '.current-day'
                 */
                if( manilaTime.getMonth()+1 == currentMonth && currentYear == manilaTime.getFullYear() ){
                    $('tbody').find('td[date-day="' + manilaTime.getDate() + '"]').addClass('current-day');
                }

                /**
                 * Add '.event' class to all days that has an event
                 */
                $('.day-event').each(function(i) {
                    var eventMonth = $(this).attr('date-month');
                    var eventDay = $(this).attr('date-day');
                    $('tbody tr td[date-month="' + eventMonth + '"][date-day="' + eventDay + '"]').addClass('event');
                });

                /**
                 * Get current month and set as '.current-month' in title
                 */
                var monthNumber = currentMonth;

                function GetMonthName(monthNumber) {
                    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                    return months[monthNumber - 1];
                }

                $('.month').text(GetMonthName(monthNumber) + ' ' + currentYear);

                /**
                 * Add class '.active' on calendar date
                 */
                $('tbody td').on('click', function(e) {
                    if ($(this).hasClass('event')) {
                        $('tbody td').removeClass('active');
                        $(this).addClass('active');
                    } else {
                        $('tbody td').removeClass('active');
                    };
                });


                /**
                 * Get current day on click in calendar
                 * and find day-event to display
                 */
                $('tbody td').on('click', function(e) {
                    $('.day-event').slideUp('fast');
                    var monthEvent = $(this).attr('date-month');
                    var dayEvent = $(this).text();
                    $('.day-event[date-month="' + monthEvent + '"][date-day="' + dayEvent + '"]').slideDown('fast');
                });

                /**
                 * Close day-event
                 */
                $('.close').on('click', function(e) {
                    $(this).parent().slideUp('fast');
                });

                /**
                 * Save & Remove to/from personal list
                 */
                $('.save').click(function() {
                    if (this.checked) {
                        $(this).next().text('Remove from personal list');
                        var eventHtml = $(this).closest('.day-event').html();
                        var eventMonth = $(this).closest('.day-event').attr('date-month');
                        var eventDay = $(this).closest('.day-event').attr('date-day');
                        var eventNumber = $(this).closest('.day-event').attr('data-number');
                        $('.person-list').append('<div class="day" date-month="' + eventMonth + '" date-day="' + eventDay + '" data-number="' + eventNumber + '" style="display:none;">' + eventHtml + '</div>');
                        $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"]').slideDown('fast');
                        $('.day').find('.close').remove();
                        $('.day').find('.save').removeClass('save').addClass('remove');
                        $('.day').find('.remove').next().addClass('hidden-print');
                        remove();
                        sortlist();
                    } else {
                        $(this).next().text('Save to personal list');
                        var eventMonth = $(this).closest('.day-event').attr('date-month');
                        var eventDay = $(this).closest('.day-event').attr('date-day');
                        var eventNumber = $(this).closest('.day-event').attr('data-number');
                        $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').slideUp('slow');
                        setTimeout(function() {
                            $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').remove();
                        }, 1500);
                    }
                });

                function remove() {
                    $('.remove').click(function() {
                        if (this.checked) {
                            $(this).next().text('Remove from personal list');
                            var eventMonth = $(this).closest('.day').attr('date-month');
                            var eventDay = $(this).closest('.day').attr('date-day');
                            var eventNumber = $(this).closest('.day').attr('data-number');
                            $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').slideUp('slow');
                            $('.day-event[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').find('.save').attr('checked', false);
                            $('.day-event[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').find('span').text('Save to personal list');
                            setTimeout(function() {
                                $('.day[date-month="' + eventMonth + '"][date-day="' + eventDay + '"][data-number="' + eventNumber + '"]').remove();
                            }, 1500);
                        }
                    });
                }

                /**
                 * Sort personal list
                 */
                function sortlist() {
                    var personList = $('.person-list');

                    personList.find('.day').sort(function(a, b) {
                        return +a.getAttribute('date-day') - +b.getAttribute('date-day');
                    }).appendTo(personList);
                }

                /**
                 * Print button
                 */
                $('.print-btn').click(function() {
                    window.print();
                });


                }
            )
        }


        jQuery('.calendar .btn-next').on('click', function(e){
            var goToMonth = currentMonth+1;

            if( goToMonth > 12 ){
                currentMonth = 1;
                currentYear  = currentYear+1;
            }else{
                currentMonth++;
            }
            getCalendar(currentMonth, currentYear);
        });

        jQuery('.calendar .btn-prev').on('click', function(e){
            var goToMonth = currentMonth-1;

            if( goToMonth < 1 ){
                currentMonth = 12;
                currentYear  = currentYear-1;
            }else{
                currentMonth--;
            }
            getCalendar(currentMonth, currentYear);
        });
    },
};

$(document).ready(function() {
    calendar.init();
});