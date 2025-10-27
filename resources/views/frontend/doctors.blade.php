@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-one">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Meet Our Qualified Doctors</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Doctors</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Doctor Search -->
    <div class="doctor-search-area">
        <div class="container">
            <form action="{{ route('doctors') }}" method="GET">
                <div class="row doctor-search-wrap">
                    <div class="col-sm-6 col-lg-6">
                        <div class="doctor-search-item">
                            <div class="form-group">
                                <i class="icofont-doctor-alt"></i>
                                <label>Search</label>
                                <input type="text" name="search" class="form-control" placeholder="Doctor Name" value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="btn doctor-search-btn">
                                <i class="icofont-search-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="doctor-search-item">
                            <div class="form-group">
                                <i class="icofont-hospital"></i>
                                <label>Category</label>
                                <select name="department_id" id="departmentFilter" class="form-control">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->department_id }}" {{ request('department_id') == $department->department_id ? 'selected' : '' }}>
                                            {{ $department->department_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Doctor Search -->

    <!-- Doctors -->
    <section class="doctors-area doctors-area-two pt-100">
        <div class="container">
            <div class="row justify-content-center">
                @forelse($doctors as $index => $doctor)
                    @php
                        $delays = ['.3s', '.5s', '.7s'];
                        $delay = $delays[$index % 3];
                        $photoPath = $doctor->photo ? asset('uploads/doctor/' . $doctor->photo) : asset('assets/img/home-one/doctor/1.jpg');
                    @endphp
                    <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $delay }}">
                        <div class="doctor-item">
                            <div class="doctor-top">
                                <img src="{{ $photoPath }}" alt="{{ $doctor->name }}" style="width: 100%; height: 350px; object-fit: cover;">
                                <a href="{{ route('appointment.create') }}?doctor_id={{ $doctor->doctor_id }}">Get Appointment</a>
                            </div>
                            <div class="doctor-bottom">
                                <h3>
                                    <a href="{{ route('doctor-details', $doctor->doctor_id) }}">{{ $doctor->title }} {{ $doctor->name }}</a>
                                </h3>
                                <span>{{ $doctor->department->department_name ?? 'General' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="alert alert-info" role="alert">
                            <i class="icofont-info-circle"></i>
                            @if(request('search') || request('department_id'))
                                <p class="mb-0">No doctors found matching your search criteria. Please try different filters.</p>
                            @else
                                <p class="mb-0">No doctors available at the moment. Please check back later.</p>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($doctors->hasPages())
                <div class="row">
                    <div class="col-12">
                        <div class="pagination-area text-center mt-5">
                            {{ $doctors->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- End Doctors -->
@endsection

@section('page_script')
<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        // Auto-submit form when department filter changes
        $('#departmentFilter').on('change', function() {
            $(this).closest('form').submit();
        });
    });
</script>
@endsection
