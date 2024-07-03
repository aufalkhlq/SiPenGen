@extends('components.app')
@section('title', 'Jadwal')
@section('content')
@push('style')

@endpush
    <div class="content container-fluid">

        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Calendar</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Calendar</li>
                    </ul>
                </div>
                <div class="col-auto text-right float-right ml-auto">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_event">Create
                        Event</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-4">
                <h4 class="card-title">Select Class</h4>
                <div class="form-group">
                    <select id="class-select" class="form-control">
                        <option value="">Select Class</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ $selectedKelas == $k->id ? 'selected' : '' }}>{{ $k->name }}</option>
                        @endforeach
                    </select>
                </div>
                <h4 class="card-title">Drag & Drop Event</h4>
                <div id="calendar-events" class="mb-3">
                    <div class="calendar-events" data-class="bg-info"><i class="fas fa-circle text-info"></i> My Event One
                    </div>
                    <div class="calendar-events" data-class="bg-success"><i class="fas fa-circle text-success"></i> My Event
                        Two</div>
                    <div class="calendar-events" data-class="bg-danger"><i class="fas fa-circle text-danger"></i> My Event
                        Three</div>
                    <div class="calendar-events" data-class="bg-warning"><i class="fas fa-circle text-warning"></i> My Event
                        Four</div>
                </div>
                <div class="checkbox  mb-3">
                    <input id="drop-remove" type="checkbox">
                    <label for="drop-remove">
                        Remove after drop
                    </label>
                </div>
                <a href="#" data-bs-toggle="modal" data-bs-target="#add_new_event"
                    class="btn mb-3 btn-primary btn-block w-100">
                    <i class="fas fa-plus"></i> Add Category
                </a>
            </div>
            <div class="col-lg-9 col-md-8">
                <div class="card bg-white">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>

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
                                <input class="form-control" type="text">
                            </div>
                            <div class="form-group">
                                <label>Event Date <span class="text-danger">*</span></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker" type="text">
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

        <div class="modal custom-modal fade none-border" id="my_event">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Event</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body"></div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-success save-event submit-btn">Create event</button>
                        <button type="button" class="btn btn-danger delete-event submit-btn"
                            data-dismiss="modal">Delete</button>
                    </div>
                </div>
            </div>
        </div>

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
                                <input class="form-control form-white" placeholder="Enter name" type="text"
                                    name="category-name" />
                            </div>
                            <div class="form-group mb-0">
                                <label>Choose Category Color</label>
                                <select class="form-control form-white" data-placeholder="Choose a color..."
                                    name="category-color">
                                    <option value="success">Success</option>
                                    <option value="danger">Danger</option>
                                    <option value="info">Info</option>
                                    <option value="primary">Primary</option>
                                    <option value="warning">Warning</option>
                                    <option value="inverse">Inverse</option>
                                </select>
                            </div>
                            <div class="submit-section">
                                <button type="button" class="btn btn-primary save-category submit-btn"
                                    data-dismiss="modal">Save</button>
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
<script src="{{ asset('assets/plugins/fullcalendar/jquery.fullcalendar.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize the datetimepicker
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        icons: {
            time: 'far fa-clock'
        }
    });

    // Initialize the full calendar
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'agendaWeek'
        },
        defaultView: 'agendaWeek',
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function() {
            // this function is called when something is dropped
            if ($('#drop-remove').is(':checked')) { // check if the "remove after drop" checkbox is checked
                $(this).remove(); // if so, remove the element from the "Draggable Events" list
            }
        },
        events: [
            // event data
        ]
    });

    // Fetch schedule based on selected class
    $('#class-select').change(function() {
        var kelasId = $(this).val();
        $.ajax({
            url: '{{ route("mahasiswa.jadwal") }}',
            method: 'GET',
            data: { kelas_id: kelasId },
            success: function(response) {
                $('#calendar').fullCalendar('removeEvents');
                $('#calendar').fullCalendar('addEventSource', response.jadwals);
            }
        });
    });
});
</script>
@endpush
