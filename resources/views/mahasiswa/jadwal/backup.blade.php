@extends('components.app')
@section('title', 'Jadwal')
@section('content')
@push('style')
<link href="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet">
@endpush
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Jadwal</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Jadwal</li>
                </ul>
            </div>
            <div class="col-auto text-right float-right ml-auto">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_event">Create Event</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-8">
            <div class="card bg-white">
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="add_event" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Event Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title">
                        </div>
                        <div class="form-group">
                            <label>Event Date <span class="text-danger">*</span></label>
                            <div class="cal-icon">
                                <input class="form-control datetimepicker" type="text" name="date">
                            </div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Detail Modal -->
    <div class="modal custom-modal fade none-border" id="my_event">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Event Name <span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="title">
                        </div>
                        <div class="form-group">
                            <label>Category <span class="text-danger">*</span></label>
                            <select class="form-control" name="category">
                                <option value="bg-info">Info</option>
                                <option value="bg-success">Success</option>
                                <option value="bg-danger">Danger</option>
                                <option value="bg-warning">Warning</option>
                                <option value="bg-primary">Primary</option>
                                <option value="bg-purple">Purple</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success save-event submit-btn">Save</button>
                    <button type="button" class="btn btn-danger delete-event submit-btn" data-dismiss="modal">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Category Modal -->
    <div class="modal custom-modal fade" id="add_new_event">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Category</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label>Category Name</label>
                            <input class="form-control form-white" placeholder="Enter name" type="text" name="category-name">
                        </div>
                        <div class="form-group mb-0">
                            <label>Choose Category Color</label>
                            <select class="form-control form-white" data-placeholder="Choose a color..." name="category-color">
                                <option value="success">Success</option>
                                <option value="danger">Danger</option>
                                <option value="info">Info</option>
                                <option value="primary">Primary</option>
                                <option value="warning">Warning</option>
                                <option value="inverse">Inverse</option>
                            </select>
                        </div>
                        <div class="submit-section">
                            <button type="button" class="btn btn-primary save-category submit-btn" data-dismiss="modal">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('assets/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/plugins/fullcalendar/fullcalendar.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize the external events
        $('#calendar-events div.calendar-events').each(function() {
            var eventObject = {
                title: $.trim($(this).text())
            };
            $(this).data('eventObject', eventObject);
            $(this).draggable({
                zIndex: 999,
                revert: true,
                revertDuration: 0
            });
        });

        // Initialize the calendar
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'agendaWeek,agendaDay'
            },
            defaultView: 'agendaWeek',
            editable: true,
            droppable: true,
            drop: function(date, jsEvent, ui, resourceId) {
                var originalEventObject = $(this).data('eventObject');
                var copiedEventObject = $.extend({}, originalEventObject);
                copiedEventObject.start = date;
                $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
                if ($('#drop-remove').is(':checked')) {
                    $(this).remove();
                }
            },
            selectable: true,
            selectHelper: true,
            select: function(start, end, allDay) {
                var modal = $('#my_event');
                modal.modal('show');
                modal.find('form').on('submit', function(e) {
                    e.preventDefault();
                    var title = modal.find("input[name='title']").val();
                    var category = modal.find("select[name='category']").val();
                    if (title) {
                        var eventData = {
                            title: title,
                            start: start,
                            end: end,
                            allDay: allDay,
                            className: category
                        };
                        $('#calendar').fullCalendar('renderEvent', eventData, true);
                    }
                    modal.modal('hide');
                    $('#calendar').fullCalendar('unselect');
                });
            },
            eventClick: function(calEvent, jsEvent, view) {
                var modal = $('#my_event');
                modal.modal('show');
                modal.find("input[name='title']").val(calEvent.title);
                modal.find("select[name='category']").val(calEvent.className[0]);
                modal.find('.save-event').unbind('click').click(function() {
                    calEvent.title = modal.find("input[name='title']").val();
                    calEvent.className = [modal.find("select[name='category']").val()];
                    $('#calendar').fullCalendar('updateEvent', calEvent);
                    modal.modal('hide');
                });
                modal.find('.delete-event').unbind('click').click(function() {
                    $('#calendar').fullCalendar('removeEvents', calEvent._id);
                    modal.modal('hide');
                });
            },
            slotDuration: '00:30:00',
            minTime: '08:00:00',
            maxTime: '18:00:00',
            allDaySlot: false
        });
    });
</script>
@endpush
