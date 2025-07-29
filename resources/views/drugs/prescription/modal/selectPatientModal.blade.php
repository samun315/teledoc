<!-- Right-Side Slide-in Modal -->
<div class="modal fade slide-right" id="patientModal" tabindex="-1" aria-labelledby="prescriptionModalLabel"
    aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-slideout">
        <div class="modal-content h-100 border-0 rounded-0">
            <div class="modal-header">
                <h5 class="modal-title">Select Patient For Prescription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body d-flex flex-column">
                <!-- Search Input -->
                <input type="text" class="form-control mb-3" id="searchPatient" placeholder="Search Patient...">

                <!-- Patient List -->
                <div id="patientList" class="overflow-auto flex-grow-1">
                </div>
            </div>

            <div class="modal-footer justify-content-between">
                <button class="btn btn-success">Create Prescription</button>
                <a href="{{ route('patient.create') }}" target="_blank" class="btn btn-warning">New Patient</a>
            </div>
        </div>
    </div>
</div>
