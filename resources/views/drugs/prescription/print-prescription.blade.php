<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style nonce="{{ $cspNonce }}">
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            margin-bottom: 200px;
        }

        .doctor-name {
            font-size: 15px;
            font-weight: bold;
        }

        .doctor-degree {
            font-size: 12px;
        }

        .prescription-header-row {
            display: flex;
            flex-wrap: nowrap;
            align-items: flex-start;
            justify-content: space-between;
            width: 100%;
            gap: 10px;
            margin-top: 10px;
        }

        .prescription-header-doctor {
            flex: 0 0 28%;
            max-width: 280px;
            text-align: left;
            min-width: 0;
        }

        .prescription-header-logo {
            flex: 1 1 auto;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-width: 0;
            padding: 0 6px;
        }

        .prescription-header-logo img {
            max-height: 72px;
            max-width: 220px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .prescription-header-patient {
            flex: 0 0 auto;
            width: max-content;
            max-width: min(240px, 38vw);
            text-align: left;
            align-self: flex-start;
        }

        .prescription-header-patient > div {
            margin: 0;
            line-height: 1.35;
        }

        .prescription-header-patient > div + div {
            margin-top: 2px;
        }

        .prescription-header-patient .label {
            display: inline-block;
            min-width: 4.5rem;
            font-weight: bold;
        }

        .prescription-header-row--no-logo .prescription-header-logo {
            display: none;
        }

        .prescription-header-row--no-logo {
            justify-content: space-between;
        }

        .prescription-header-row--no-logo .prescription-header-doctor {
            flex: 1 1 auto;
            max-width: 50%;
        }

        .rx-title {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
        }

        .medicine-list {
            list-style: decimal;
            padding-left: 20px;
        }

        .medicine-list li::marker {
            font-weight: bold;
        }

        .history-section div {
            margin-bottom: 10px;
        }

        /* Footer */
        .footer-bar {
            background: #ffffff;
            color: #eb0707;
            padding: 10px;
            font-size: 11px;
            font-weight: bolder;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .footer-left {
            float: left;
            width: 66.66%;
            display: flex;
            align-items: center;
        }

        .footer-right {
            float: right;
            width: 33.33%;
            text-align: right;
        }

        .site-logo {
            max-width: 80px;
            max-height: 50px;
            object-fit: contain;
        }

        .doctor-footer-info {
            margin-left: 10px;
            line-height: 1.4;
            color: #000;
        }

        .footer-bar a {
            color: #eb0707;
            text-decoration: underline;
        }

        /* ✅ Signature fixed just above footer */
        .signature-wrapper {
            position: fixed;
            right: 30px;
            bottom: 130px;
            display: inline-block;
            background: #fff;
            z-index: 9999; /* 🔥 FIX: doctor name visible */
        }

        .signature-image {
            max-width: 150px;
            max-height: 60px;
            object-fit: contain;
            margin-bottom: 5px;
            display: block;
        }

        .signature-section {
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: right;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .prescription-header-row {
                break-inside: avoid;
            }
        }
    </style>
</head>

<body class="p-4">

    <!-- Doctor (left) | Logo (center) | Patient (right) -->
    <div class="prescription-header-row {{ empty($headerLogo?->file_path) ? 'prescription-header-row--no-logo' : '' }}">
        <div class="prescription-header-doctor">
            <span class="text-info doctor-name">
                {{ $prescription?->doctor->title }} {{ $prescription?->doctor->name }}
            </span><br>

            @if ($prescription->doctor->degrees && $prescription->doctor->degrees->count())
                @foreach ($prescription->doctor->degrees as $deg)
                    <div class="doctor-degree">
                        {{ $deg->degree_title }} - {{ $deg->degree_description }}
                    </div>
                @endforeach
            @endif

            @if ($prescription->doctor->department && $prescription->doctor->department->department_name)
                <div class="doctor-degree">
                    <b>{{ strtoupper($prescription->doctor->department->department_name) }}</b>
                </div>
            @endif
        </div>

        <div class="prescription-header-logo">
            @if (!empty($headerLogo?->file_path))
                <img src="{{ asset($headerLogo->file_path) }}" alt="{{ $headerLogo->alt_text ?? 'Logo' }}">
            @endif
        </div>

        <div class="prescription-header-patient">
            @if (!empty($prescription->patient->name))
                <div><span class="label">Name:</span> {{ $prescription->patient->name }}</div>
            @endif
            @if (!empty($prescription->patient->patient_id_number))
                <div><span class="label">Patient ID:</span> {{ $prescription->patient->patient_id_number }}</div>
            @endif
            @if (!empty($prescription->patient->age))
                <div><span class="label">Age:</span> {{ $prescription->patient->age }} Yrs</div>
            @endif
            @if (!empty($prescription->patient->weight))
                <div><span class="label">Weight:</span> {{ $prescription->patient->weight }} kg</div>
            @endif
            @if (!empty($prescription->patient->blood_group))
                <div><span class="label">Blood Group:</span> {{ $prescription->patient->blood_group }}</div>
            @endif
            <div><span class="label">Date:</span> {{ $prescription->created_at->format('d.m.Y') }}</div>
        </div>
    </div>

    <hr>

    <!-- Main Content -->
    <div class="row mt-3">
        <div class="col-6 history-section">
            @if ($prescription->clinicalRecord && $prescription->clinicalRecord->count() > 0)
                @foreach ($prescription->clinicalRecord as $record)
                    @if ($record->subscriptionType && !empty($record->subscription_details))
                        <div>
                            <strong>{{ $record->subscriptionType->subscription_type }}:</strong>
                            <div class="ms-3">{{ $record->subscription_details }}</div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <div class="col-6">
            @if ($prescription->medication && $prescription->medication->count() > 0)
                <div class="rx-title">Rx</div>
                <ol class="medicine-list">
                    @foreach ($prescription->medication as $m)
                        <li>
                            @if ($m->drugType && $m->drugType->drug_type)
                                <strong>{{ $m->drugType->drug_type }}</strong>.
                            @endif
                            @if ($m->drug && $m->drug->trade_name)
                                <strong>{{ $m->drug->trade_name }}@if($m->drug->generic_name) ({{ $m->drug->generic_name }})@endif</strong>
                            @endif
                            @if ($m->drugStrength && $m->drugStrength->drug_strength)
                                <strong> - {{ $m->drugStrength->drug_strength }}</strong>
                            @endif
                            @if (($m->drugDose && $m->drugDose->drug_dose) || ($m->drugDuration && $m->drugDuration->drug_duration))
                                <br>
                                @if ($m->drugDose && $m->drugDose->drug_dose)
                                    {{ $m->drugDose->drug_dose }}
                                @endif
                                @if ($m->drugDuration && $m->drugDuration->drug_duration)
                                    <strong>{{ $m->drugDuration->drug_duration }}</strong>
                                @endif
                            @endif
                            @if ($m->drugAdvice && $m->drugAdvice->drug_advice)
                                <br>
                                <strong>Instruction:</strong>
                                {{ $m->drugAdvice->drug_advice }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            @endif

            @if (!empty($prescription->doctor_advice))
                <div class="rx-title">Advice</div>
                {!! $prescription->doctor_advice !!}
            @endif

            @if (!empty($prescription->follow_up))
                <div class="rx-title">Follow up</div>
                {{ $prescription->follow_up }}
            @endif
        </div>
    </div>

    <!-- Signature -->
    <div class="signature-wrapper text-end">
        <img src="{{ asset('uploads/doctor sign/athful_sign.png') }}" alt="Doctor Signature" class="signature-image">
        <div class="signature-section">
            <strong>
                ({{ $prescription?->doctor->title }} {{ $prescription?->doctor->name }})
            </strong>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-bar">
        <hr class="text-dark">
        <div class="footer-left">
            {{-- @if ($siteInfo?->file_path)
                <img src="{{ asset($siteInfo->file_path) }}" class="site-logo">
            @endif --}}

            <div class="doctor-footer-info">
                <b>Teledoc-Athful's Healthcare Platform.</b><br>
                Contact: +960 9303893 (WhatsApp message)<br>
                Email: info@teledocathful.com <br>
                @php $siteUrl = request()->getSchemeAndHttpHost(); @endphp
                Weblink:www.teledocathful.com<br>

            </div>
        </div>

        <div class="footer-right text-dark">
            <small>
                যে কোন স্বাস্থ্য বিষয়ক পরামর্শের জন্য ওয়েবসাইট লিঙ্কে গিয়ে আপনার নাম রেজিস্ট্রেশন করে এপয়ন্টমেন্ট করুন।
            </small>
        </div>

        <div class="clearfix"></div>
    </div>

    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function () {
            const patientName = "{{ $prescription->patient->name ?? '' }}";
            document.title = patientName
                ? patientName + "'s Prescription"
                : "Prescription";
            window.print();
        });
    </script>

</body>
</html>
