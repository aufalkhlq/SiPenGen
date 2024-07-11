@extends('components.app')
@section('title', 'Jadwal')
@section('content')
@push('style')
<script>document.getElementsByTagName("html")[0].className += " js";</script>
<link href="{{ asset('assets/timetable/css/style.css') }}" rel="stylesheet">
<style>
    .right {
        text-align: right;
        margin-right: 20px
    }
</style>
@endpush
<!-- Add Cetak Excel button -->
<div class="margin-top-lg right">
    <a href="{{ route('dosen.jadwalcetak') }}" class="btn btn-primary">Cetak Excel</a>
</div>

<div class="cd-schedule cd-schedule--loading margin-top-lg margin-bottom-lg js-cd-schedule">
    <div class="cd-schedule__timeline">
        <ul>
            <li><span>07:00</span></li>
            <li><span>07:45</span></li>
            <li><span>08:30</span></li>
            <li><span>09:15</span></li>
            <li><span>10:00</span></li>
            <li><span>10:45</span></li>
            <li><span>11:30</span></li>
            <li><span>12:15</span></li>
            <li><span>13:00</span></li>
            <li><span>13:30</span></li>
            <li><span>14:00</span></li>
            <li><span>14:30</span></li>
            <li><span>15:00</span></li>
            <li><span>15:30</span></li>
            <li><span>16:00</span></li>
            <li><span>16:30</span></li>
            <li><span>17:00</span></li>
            <li><span>17:30</span></li>
            <li><span>18:00</span></li>
        </ul>
    </div>

    <div class="cd-schedule__events">
        <ul>
            @foreach ($eventsByDay as $day => $events)
                <li class="cd-schedule__group">
                    <div class="cd-schedule__top-info"><span>{{ $day }}</span></div>
                    <ul>
                        @foreach($events as $index => $event)
                            @php
                                // Assign a color class based on the index
                                $colorClasses = ['event-1', 'event-2', 'event-3', 'event-4'];
                                $colorClass = $colorClasses[$index % count($colorClasses)];
                            @endphp
                            <li class="cd-schedule__event">
                                <a data-start="{{ $event['start'] }}" data-end="{{ $event['end'] }}" data-content="event-{{ strtolower(str_replace(' ', '-', $event['title'])) }}" data-event="{{ $colorClass }}" href="#0">
                                    <em class="cd-schedule__name">{{ $event['title'] }}</em>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="cd-schedule-modal">
        <header class="cd-schedule-modal__header">
            <div class="cd-schedule-modal__content">
                <span class="cd-schedule-modal__date"></span>
                <h3 class="cd-schedule-modal__name"></h3>
            </div>
            <div class="cd-schedule-modal__header-bg"></div>
        </header>
        <div class="cd-schedule-modal__body">
            <div class="cd-schedule-modal__event-info"></div>
            <div class="cd-schedule-modal__body-bg"></div>
        </div>
        <a href="#0" class="cd-schedule-modal__close text-replace">Close</a>
    </div>

    <div class="cd-schedule__cover-layer"></div>
</div>
@endsection

@push('script')
<script src="{{asset('assets/timetable/js/util.js')}}"></script>
<script src="{{asset('assets/timetable/js/main.js')}}"></script>
@endpush
