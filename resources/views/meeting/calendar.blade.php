<div class="box">
    <div class="box-body">
        <div id="meeting_calendar" style="width: 98%;margin: 0 auto;padding: 15px 0;"></div>
    </div>
</div>

<div class="modal fade addEventModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Meeting</h4>
            </div>
            {!! Form::open(array('url' => 'meeting')) !!}
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="submit" name="addEventBtn" class="btn btn-submit btn-shadow addEventBtn">Add</button>
                    <button type="button" class="btn btn-delete btn-shadow" data-dismiss="modal">Close</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal fade editEventModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Meeting</h4>
            </div>
            {!! Form::open(array('url' => 'meeting', 'method' => 'PATCH', 'class' => 'editMeetingForm')) !!}
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="submit" name="editEventBtn" class="btn btn-submit editEventBtn btn-shadow">Edit</button>
                    <button type="button" class="btn btn-delete btn-shadow" data-dismiss="modal">Close</button>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal fade" id="add_member">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Add Member</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

@section('js_footer')
@parent
<script>
    $(function(e){
        var paddingLeft = function (paddingValue, str) {
           return String(paddingValue + str).slice(-paddingValue.length);
        };

        var date = new Date();
        var meeting_calendar = $('#meeting_calendar');
        var addEventModal = $('.addEventModal');
        var editEventModal = $('.editEventModal');
        var calendarEvents = [];
        var timezone = [];
        var teams = [];
        var currentTimezone = '';
        var currentTeam = '';
        var currentUser = '';
        var renderCounter = 0;

        loadEvent();
        function loadEvent(){
            var thisUrl = '{{ URL::to('meetingJson') }}' + (currentTimezone ? ('?timezone=' + currentTimezone) : '');
            $.ajax({
                url: thisUrl,
                success: function(doc) {
                    calendarEvents = doc;
                    $.ajax({
                        url: '{{ URL::to('meetingTimezone') }}',
                        success: function(doc) {
                            currentTimezone = doc.current_timezone;
                            timezone = doc.timezone;

                            $.ajax({
                                url: '{{ URL::to('teamBuilderJson') }}',
                                success: function(doc) {
                                    teams = doc;

                                    renderCalendar();
                                }
                            });
                        }
                    });
                }
            });
        }

        function renderCalendar(){
            meeting_calendar.fullCalendar({
                timezone: currentTimezone,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                buttonText: {
                    today: 'today',
                    month: 'month',
                    week: 'week',
                    day: 'day'
                },
                titleFormat: {
                    month:  "[<strong style='font-size: 30px;'>]MMMM YYYY[</strong>]",
                    week:  "[<strong style='font-size: 30px;'>]MMM D YYYY[</strong>]",
                    day:  "[<strong style='font-size: 30px;'>]MMMM D YYYY[</strong>]"
                },
                columnFormat: {
                    week: 'ddd MMMM D' //to customize the weekly title from Sun 4/4 to Sun April 4
                },
                theme: 1,
                eventRender: function(event, element, view) {
                    //hide time as requested by Tom
                    element.find('.fc-event-time').css('display', 'none');

                    //custom title content for each calendar meeting
                    var title = '<strong>Project:</strong> ' + event.project_title + '<br />';
                    title += '<strong>Description:</strong> ' + event.description + '<br />';
                    title += '<strong>Type:</strong> ' + event.meeting_type + '<br />';
                    title += '<strong>Priority:</strong> ' + event.meeting_priority + '<br />';
                    element
                        .find('.fc-event-title')
                        .html(title);

                    // render the timezone offset below the event title
                    if (event.start.hasZone()) {
                         element
                            .find('.fc-event-title')
                            .after($('<div class="tzo"/>').text(event.start.format('Z'))
                        );
                    }
                },
                eventAfterAllRender: function( view ){
                    var fc_header = $('.fc-header');
                    var header_left = $('.fc-header-left');
                    header_left.find('.fc-button').prependTo(".fc-header-right");

                    header_left.find('.fc-button').addClass('hidden');
                    header_left.find('.fc-header-space').addClass('hidden');

                    if(fc_header.find('.timezoneArea').length == 0){ //only append if drop down timezone doesn't exist yet
                        var tStr =
                            '<span class="form-inline timezoneArea" style="margin-left: 10px;">' +
                                '<select class="timezone-selector form-control" title="Select Timezone" style="font-size: 18px;"></select>' +
                             '</span>';
                        header_left.append(tStr);

                        //add the options for timezone drop down
                        $.each(timezone, function(i, t){
                            fc_header
                                .find('.timezone-selector')
                                .append($("<option/>").text(t).attr('value', t));
                        });
                        fc_header.find('.timezone-selector').selectpicker({ width: '150px' });

                        //set the default value and add event when the timezone dp is change
                        fc_header
                            .find('.timezone-selector')
                            .val(currentTimezone)
                            .on('change', function() {
                                currentTimezone = $(this).val(); //pass new value
                                meeting_calendar.fullCalendar('destroy'); //remove existing calendar
                                loadEvent(); //create new calendar
                            });
                    }
                    if(fc_header.find('.teamArea').length == 0){
                        var teamStr =
                            '<span class="form-inline teamArea" style="margin-left: 10px;">' +
                                '<select class="team-selector form-control" title="Group Meeting" style="font-size: 18px;"></select>&nbsp;' +
                                '<select class="user-selector form-control hidden" title="Add User" style="width: 130px;font-size: 12px;"></select>&nbsp;' +
                                '<button type="button" class="btn btn-sm btn-submit btn-shadow addMemberBtn hidden" style="font-size: 18px;"><i class="fa fa-plus-circle"></i> Add</button>' +
                             '</span>';
                        header_left.append(teamStr);

                        $.each(teams, function(i, t){
                            fc_header
                                .find('.team-selector')
                                .append($("<option/>").text(t.title).attr('value', t.id));
                        });
                        fc_header.find('.team-selector').selectpicker({ width: '160px' });

                        teamChange();
                        fc_header
                            .find('.team-selector')
                            .val(currentTeam)
                            .on('change', function() {
                                currentTeam = $(this).val(); //pass new value
                                teamChange();
                            });

                        userChange();
                        fc_header
                            .find('.user-selector')
                            .val(currentUser)
                            .on('change', function() {
                                currentUser = $(this).val(); //pass new value
                                userChange();
                            });

                        fc_header
                            .find('.addMemberBtn')
                            .on('click', function() {
                                var add_member = $('#add_member');
                                var thisUrl = '{{ URL::to("/teamBuilder/create?p=member") }}&id=' + currentTeam;
                                $.ajax({
                                    url: thisUrl,
                                    success: function(doc) {
                                        add_member.modal('show');
                                        add_member.find('.modal-body').html(doc);
                                    }
                                });
                            });
                    }


                    renderCounter ++;
                },
                events: calendarEvents,
                dayClick: function(date, jsEvent, view) {
                    //add meeting pop out triggered
                    var d = date._d;
                    var dStr = d.getFullYear() + '-' + paddingLeft("00", parseInt(d.getMonth()) + 1) + '-' + paddingLeft("00", d.getDate());
                    $.ajax({
                        url: '{{ URL::to("/meeting/create") }}',
                        method: "GET",
                        data: {
                            date: dStr
                        },
                        success: function(doc) {
                            addEventModal.find('.modal-body').html(doc);
                            addEventModal.modal('show');
                        }
                    });
                },
                eventClick: function(calEvent, jsEvent, view) {
                    //edit meeting pop out triggered
                    var thisUrl = '{{ URL::to("/meeting") }}/' + calEvent.id;
                    $.ajax({
                        url: thisUrl,
                        success: function(doc) {
                            editEventModal.find('.editMeetingForm').attr('action', thisUrl);
                            editEventModal.find('.modal-body').html(doc);
                            editEventModal.modal('show');
                        }
                    });
                },
                editable: true,
                eventDrop: function(event, delta, revertFunc) {
                    //drag and drop functionality
                    $.ajax({
                        url: '{{ URL::to("/meeting") }}/' + event.id,
                        method: "PATCH",
                        data: {
                            is_drag: 1,
                            new_date: event.start.format(),
                            start_date: event.start_date,
                            end_date: event.end_date
                        },
                        success: function(doc) {

                        },
                        error: function (xhr, ajaxOptions, thrownError) {

                        }
                    });
                }
            });
        }

        function teamChange(){
            var fc_header = $('.fc-header');
            var thisEvents = calendarEvents;
            fc_header.find('.user-selector').html('');

            if(currentTeam != 0){
                fc_header.find('.addMemberBtn').removeClass('hidden');

                thisEvents = $.grep(thisEvents, function(v) {
                    return v.project_id == currentTeam;
                });

                $.ajax({
                    url: '{{ URL::to('teamBuilderUserJson') }}?t=' + currentTeam,
                    success: function(user) {
                        $.each(user, function(i, t){
                            fc_header
                                .find('.user-selector')
                                .append($("<option/>").text(t.name).attr('value', t.id));
                        });
                        fc_header.find('.user-selector').selectpicker({ width: '150px' });

                        if(user.length > 0){
                            fc_header.find('.user-selector').removeClass('hidden');
                        }
                        else{
                            fc_header.find('.user-selector').addClass('hidden');
                        }
                    }
                });
            }
            else{
                fc_header.find('.addMemberBtn').addClass('hidden');
                fc_header.find('.user-selector').addClass('hidden');
            }

            meeting_calendar.fullCalendar('removeEvents');
            meeting_calendar.fullCalendar('addEventSource', thisEvents);
        }
        function userChange(){
            var thisEvents = calendarEvents;

            thisEvents = $.grep(thisEvents, function(v) {
                var isOk = currentUser != 0 ? $.inArray(currentUser, v.attendees_id) !== -1 : true;
                if(currentTeam != 0){
                    isOk = isOk ? v.project_id == currentTeam : isOk;
                }

                return isOk;
            });

            meeting_calendar.fullCalendar('removeEvents');
            meeting_calendar.fullCalendar('addEventSource', thisEvents);
        }
    });
</script>
@stop