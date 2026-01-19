@extends('master')

@section('title', 'Configure Doctor Fee')
@section('content')
    <!--begin::Toolbar -->
    <x-toolbar-component title="Configure Doctor Fee" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Doctor', 'url' => route('doctor.index')],
        ['label' => 'Fee Configuration', 'url' => route('doctor.fee.index')],
        ['label' => 'Configure Fee', 'active' => true],
    ]"
        actionUrl="{{ route('doctor.fee.index') }}" actionIcon="fas fa-list" actionLabel="Fee List" />
    <!--end::Toolbar -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <form method="POST"
                action="{{ route('doctor.fee.update', $editModeData?->doctor_id) }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Doctor Info Display -->
                            <div class="col-md-12 mb-5">
                                <div class="alert alert-info d-flex align-items-center p-5">
                                    <i class="fas fa-user-md fs-2hx text-primary me-4"></i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-dark">{{ $editModeData->title }} {{ $editModeData->name }}</h4>
                                        <span class="text-muted">
                                            <i class="fas fa-envelope me-2"></i>{{ $editModeData->email }} | 
                                            <i class="fas fa-phone me-2"></i>{{ $editModeData->phone }}
                                        </span>
                                        @if($editModeData->department)
                                            <span class="badge badge-info mt-2" style="width: fit-content;">
                                                {{ $editModeData->department->department_name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Consultation Fee -->
                            <div class="col-md-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">Consultation Fee</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" 
                                        name="consultation_fee" 
                                        step="0.01"
                                        min="0"
                                        class="form-control form-control-light @error('consultation_fee') is-invalid @enderror"
                                        value="{{ $editModeData->consultation_fee ?? old('consultation_fee', 0) }}" 
                                        placeholder="Enter Consultation Fee"
                                        required>
                                </div>
                                @error('consultation_fee')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                                <div class="form-text">Enter the consultation fee amount in BDT</div>
                            </div>

                            <!-- Platform Commission -->
                            <div class="col-md-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">Platform Commission (%)</label>
                                <div class="input-group">
                                    <input type="number" 
                                        name="platform_commission" 
                                        step="0.01"
                                        min="0"
                                        max="100"
                                        class="form-control form-control-light @error('platform_commission') is-invalid @enderror"
                                        value="{{ $editModeData->platform_commission ?? old('platform_commission', 0) }}" 
                                        placeholder="Enter Platform Commission"
                                        required>
                                    <span class="input-group-text">%</span>
                                </div>
                                @error('platform_commission')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                                <div class="form-text">Enter the platform commission percentage (0-100)</div>
                            </div>

                            <!-- Calculation Preview -->
                            @if($editModeData->consultation_fee && $editModeData->platform_commission)
                                <div class="col-md-12 mb-5">
                                    <div class="card bg-light-primary">
                                        <div class="card-body">
                                            <h5 class="text-primary mb-3">Fee Breakdown</h5>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="d-flex flex-column">
                                                        <span class="text-muted fs-7">Consultation Fee</span>
                                                        <span class="fs-4 fw-bold text-dark" id="preview_consultation_fee">
                                                            ৳{{ number_format($editModeData->consultation_fee, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex flex-column">
                                                        <span class="text-muted fs-7">Platform Commission</span>
                                                        <span class="fs-4 fw-bold text-success" id="preview_commission">
                                                            ৳{{ number_format(($editModeData->consultation_fee * $editModeData->platform_commission) / 100, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="d-flex flex-column">
                                                        <span class="text-muted fs-7">Doctor Earnings</span>
                                                        <span class="fs-4 fw-bold text-primary" id="preview_earnings">
                                                            ৳{{ number_format($editModeData->consultation_fee - (($editModeData->consultation_fee * $editModeData->platform_commission) / 100), 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-12 mt-4 text-end">
                                <a href="{{ route('doctor.fee.index') }}" class="btn btn-sm btn-light me-2">Cancel</a>
                                <button type="submit" class="btn btn-sm btn-primary">Update Fee Configuration</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')
    <script nonce="{{ $cspNonce }}">
        // Real-time calculation preview
        const consultationFeeInput = document.querySelector('input[name="consultation_fee"]');
        const platformCommissionInput = document.querySelector('input[name="platform_commission"]');
        
        const previewConsultationFee = document.getElementById('preview_consultation_fee');
        const previewCommission = document.getElementById('preview_commission');
        const previewEarnings = document.getElementById('preview_earnings');

        function updatePreview() {
            const fee = parseFloat(consultationFeeInput.value) || 0;
            const commission = parseFloat(platformCommissionInput.value) || 0;
            
            const commissionAmount = (fee * commission) / 100;
            const doctorEarnings = fee - commissionAmount;

            if (previewConsultationFee) {
                previewConsultationFee.textContent = '৳' + fee.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            if (previewCommission) {
                previewCommission.textContent = '৳' + commissionAmount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
            if (previewEarnings) {
                previewEarnings.textContent = '৳' + doctorEarnings.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        }

        if (consultationFeeInput && platformCommissionInput) {
            consultationFeeInput.addEventListener('input', updatePreview);
            platformCommissionInput.addEventListener('input', updatePreview);
        }
    </script>
@endsection
