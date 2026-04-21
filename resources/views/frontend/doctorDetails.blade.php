@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-three">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item-two">
                    <h2>{{ $doctor->title }} {{ $doctor->name }}</h2>
                    <h3>{{ $doctor->department->department_name ?? 'General' }}</h3>
                    <p>
                        @if($doctor->degrees->isNotEmpty())
                            {{ $doctor->degrees->pluck('degree_title')->implode(', ') }}
                            @if($doctor->degrees->first()->degree_description)
                                in {{ $doctor->degrees->pluck('degree_description')->filter()->implode(', ') }}
                            @endif
                        @else
                            Professional Medical Doctor
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Doctor Details -->
    <div class="doctor-details-area pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="doctor-details-item doctor-details-left">
                        @php
                            $photoPath = $doctor->photo ? asset('uploads/doctor/' . $doctor->photo) : asset('assets/img/doctor/3.jpg');
                        @endphp
                        <img src="{{ $photoPath }}" alt="{{ $doctor->name }}" style="width: 100%; height: auto; object-fit: cover;">
                        <div class="doctor-details-contact">
                            <h3>Contact info</h3>
                            <ul>
                                <li>
                                    <i class="icofont-ui-call"></i>
                                    Call : <a href="tel:{{ $doctor->phone }}">{{ $doctor->phone }}</a>
                                </li>
                                <li>
                                    <i class="icofont-ui-message"></i>
                                    <a href="mailto:{{ $doctor->email }}">{{ $doctor->email }}</a>
                                </li>
                                <li>
                                    <i class="icofont-location-pin"></i>
                                    {{ $doctor->address ?? 'Not Available' }}
                                </li>
                            </ul>
                        </div>
                        <div class="doctor-details-work">
                            <h3>Working hours</h3>
                            @if($orderedSchedules->isNotEmpty())
                                <div class="appointment-item-two-right">
                                    <div class="appointment-item-content">
                                        <div class="content-one">
                                            <ul>
                                                @foreach($orderedSchedules as $day => $schedules)
                                                    <li>{{ $day }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="content-two">
                                            <ul>
                                                @foreach($orderedSchedules as $day => $schedules)
                                                    <li>
                                                        @foreach($schedules as $index => $schedule)
                                                            {{ date('g:i a', strtotime($schedule->start_time)) }} - {{ date('g:i a', strtotime($schedule->end_time)) }}@if(!$loop->last), @endif
                                                        @endforeach
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <p class="text-muted">No schedule available</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="doctor-details-item">
                        <div class="doctor-details-right">
                            <div class="doctor-details-biography">
                                <h3>Biography</h3>
                                @if($doctor->description)
                                    {!! nl2br(e($doctor->description)) !!}
                                @else
                                    <p>{{ $doctor->title }} {{ $doctor->name }} is a highly qualified medical professional specializing in {{ $doctor->department->department_name ?? 'medical services' }}. With extensive experience and dedication to patient care, they provide expert medical consultation and treatment.</p>
                                @endif
                            </div>

                            @if($doctor->degrees->isNotEmpty())
                                <div class="doctor-details-biography">
                                    <h3>Education</h3>
                                    <ul>
                                        @foreach($doctor->degrees as $degree)
                                            <li>
                                                <strong>{{ $degree->degree_title }}</strong>
                                                @if($degree->degree_description)
                                                    - {{ $degree->degree_description }}
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="doctor-details-biography">
                                <h3>Specialization</h3>
                                <p>Specialist in <strong>{{ $doctor->department->department_name ?? 'General Medicine' }}</strong> with proven expertise in patient care and medical treatment.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Doctor Details -->

    <!-- Appointment -->
    <div class="appointment-area-three">
        <div class="container-fluid p-0">
            <div class="row m-0">

            </div>
        </div>
    </div>
    <!-- End Appointment -->
@endsection

@section('page_script')

@endsection
