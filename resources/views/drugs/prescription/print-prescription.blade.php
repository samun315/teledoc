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
            margin-bottom: 160px;
        }

        /* Doctor */
        .doctor-name {
            font-size: 15px;
            font-weight: bold;
        }
        .doctor-degree {
            font-size: 12px;
        }

        /* Top Row */
        .top-row {
            width: 100%;
            overflow: hidden;
            margin-top: 10px;
        }

        .doctor-info {
            float: left;
            width: 60%;
        }

        .patient-info-right {
            float: right;
            width: 38%;
            text-align: left;
        }

        .patient-info-right .label {
            display: inline-block;
            width: 110px;
            font-weight: bold;
        }

        .clearfix {
            clear: both;
        }

        /* Rx */
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
            background: #defce5;
            color: #eb0707;
            padding: 10px;
            font-size: 11px;
            font-weight: bolder;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        .footer-left {
            float: left;
            width: 66.66%;
        }

        .footer-right {
            float: right;
            width: 33.33%;
            text-align: right;
        }

        .site-logo {
            float: left;
            max-width: 80px;
            max-height: 50px;
            object-fit: contain;
        }

        .doctor-footer-info {
            float: left;
            margin-left: 10px;
            line-height: 1.4;
        }

        .footer-bar a {
            color: #eb0707;
            text-decoration: underline;
        }

        .signature-section {
            border-top: 1px solid #ccc;
            padding-top: 10px;
            margin-top: 20px;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="p-4">

    <!-- Doctor + Patient Info -->
    <div class="top-row">
        <!-- Doctor Info -->
        <div class="doctor-info">
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
        </div>

        <!-- Patient Info (Right Corner) -->
        <div class="patient-info-right">
            <div><span class="label">Name:</span> {{ $prescription->patient->name ?? '' }}</div>
            <div><span class="label">Age:</span> {{ $prescription->patient->age ?? '' }} Yrs</div>
            <div><span class="label">Weight:</span> {{ $prescription->patient->weight ?? '' }} kg</div>
            <div><span class="label">Blood Group:</span> {{ $prescription->patient->blood_group ?? '' }}</div>
            <div><span class="label">Date:</span> {{ $prescription->created_at->format('d.m.Y') }}</div>
        </div>

        <div class="clearfix"></div>
    </div>

    <hr>

    <!-- Main Content -->
    <div class="row mt-3">
        <!-- Clinical Records -->
        <div class="col-6 history-section">
            @foreach ($prescription->clinicalRecord ?? [] as $record)
                @if ($record->subscriptionType)
                    <div>
                        <strong>{{ $record->subscriptionType->subscription_type }}:</strong>
                        <div class="ms-3">{{ $record->subscription_details }}</div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Rx -->
        <div class="col-6">
            <div class="rx-title">Rx</div>
            <ol class="medicine-list">
                @foreach ($prescription->medication ?? [] as $m)
                    <li>
                        <strong>{{ $m->drugType->drug_type ?? '' }}</strong>.
                        <strong>
                            {{ $m->drug->trade_name ?? '' }}
                            {{-- {{ $m->drug->generic_name ? '(' . $m->drug->generic_name . ')' : '' }} --}}
                        </strong>
                        <strong> - {{ $m->drugStrength->drug_strength ?? '' }}</strong><br>

                        {{ $m->drugDose->drug_dose ?? '' }}
                        <strong>{{ $m->drugDuration->drug_duration ?? '' }}</strong><br>

                        <strong>Instruction:</strong>
                        {{ $m->drugAdvice->drug_advice ?? '' }}
                    </li>
                @endforeach
            </ol>

            <div class="rx-title">Advice</div>
            {!! $prescription?->doctor_advice !!}

            <div class="rx-title">Follow up</div>
            {{ $prescription?->follow_up }}
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-bar">
        <!-- LEFT: Logo + Doctor Info -->
        <div class="footer-left">
            @if($siteInfo?->file_path)
                <img src="{{ asset($siteInfo->file_path) }}"
                     alt="{{ $siteInfo?->alt_text ?? 'Logo' }}"
                     class="site-logo">
            @endif

            <div class="doctor-footer-info">
                <b>{{ $prescription->doctor->name }}'s online Healthcare Platform.</b><br>
                @php $siteUrl = request()->getSchemeAndHttpHost(); @endphp
                Website: <a href="{{ $siteUrl }}">{{ $siteUrl }}</a><br>
                WhatsApp message: {{ $prescription->doctor->phone }}<br>
                Email: {{ $prescription->doctor->email }}
            </div>
        </div>

        <!-- RIGHT: Schedule -->
        <div class="footer-right">
            <b class="text-success">রোগী দেখার সময় :</b><br>
            @foreach ($prescription->doctor->schedules->groupBy('day_of_week') as $day => $schedules)
                <div>
                    <strong>{{ $day }}:</strong>
                    @foreach ($schedules as $sch)
                        {{ \Carbon\Carbon::parse($sch->start_time)->format('g:i A') }}
                        to
                        {{ \Carbon\Carbon::parse($sch->end_time)->format('g:i A') }}
                    @endforeach
                </div>
            @endforeach
            <div class="mt-2"> <small>স্বাস্থ্য বিষয়ক পরামর্শের জন্য ওয়েবসাইটে গিয়ে রেজিস্ট্রেশন ও এপয়ন্টমেন্ট করুন।</small> </div>
        </div>

        <div class="clearfix"></div>
    </div>

    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function () {
            window.print();
        });
    </script>

</body>
</html>
