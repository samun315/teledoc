<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <title>Prescription</title>
    <style nonce="{{ $cspNonce }}">
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            margin-bottom: 100px;
        }

        .patient-info {
            font-size: 13px;
            white-space: nowrap;
            margin-bottom: 15px;
        }

        .patient-info div {
            display: inline-block;
            margin-right: 20px;
        }

        .rx-title {
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            color: #000;
        }

        .medicine-list {
            list-style: decimal;
            /* normal numbers */
            padding-left: 20px;
        }

        .medicine-list li {
            font-weight: normal;
            /* keep content normal */
        }

        .medicine-list li::marker {
            font-weight: bold;
            /* only numbers bold */
        }


        .history-section div {
            margin-bottom: 10px;
        }

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

        .footer-bar .left {
            float: left;
            width: 50%;
        }

        .footer-bar .right {
            float: right;
            width: 50%;
            text-align: right;
        }

        .clearfix {
            clear: both;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .bg-danger {
                background-color: #dc3545 !important;
                color: #fff !important;
            }

            .footer-bar {
                background: #defce5 !important;
                color: #eb0707 !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
</head>

<body class="p-4">

    <!-- Red Header -->
    <div class="bg-danger text-center text-white p-2 fw-bold">
        ডাক্তার এর পরামর্শ ছাড়া কোন ঔষধ খাওয়া বা ব্যবহার করা রোগীর জন্য ঝুঁকিপূর্ণ
    </div>

    <!-- Doctor Info -->
    <div class="row mt-2">
        <div class="col-8 col-md-6">
            <span class="text-info doctor-name">{{ $prescription?->doctor->title }}
                {{ $prescription?->doctor->name }}</span><br>
            <span class="doctor-degree">
                @if ($prescription->doctor->degrees && $prescription->doctor->degrees->count())
                    @foreach ($prescription->doctor->degrees as $deg)
                        <div>
                            {{ $deg->degree_title }} - {{ $deg->degree_description }}
                        </div>
                    @endforeach
                @endif
            </span>
        </div>
        <div class="col-4 col-md-6 text-end">
            <a class="btn btn-sm btn-success text-nowrap no-print" href="{{ route('drug.prescription.index') }}">
                <i class="fas fa-list"></i> Prescription List
            </a>
        </div>
    </div>

    <hr>

    <!-- Patient Info Horizontal -->
    <div class="patient-info">
        <div><b>Name:</b> {{ $prescription->patient->name ?? '' }}</div>
        <div><b>Age:</b> {{ $prescription->patient->age ?? '' }} Yrs</div>
        <div><b>Weight:</b> {{ $prescription->patient->weight ?? '' }} kg</div>
        <div><b>Blood Group:</b> {{ $prescription->patient->blood_group ?? '' }}</div>
        <div><b>Date:</b> {{ $prescription->created_at->format('d.m.Y') }}</div>
    </div>
    <hr>
    <!-- Main Content Row -->
    <div class="row mt-3">
        <!-- Left Side: Subscription Type + Details -->
        <div class="col-6 history-section">
            @foreach ($prescription->clinicalRecord ?? [] as $record)
                @if ($record->subscriptionType)
                    <div>
                        <strong>{{ $record->subscriptionType->subscription_type }}</strong>
                        <ul>
                            <li>{{ $record->subscription_details }}</li>
                        </ul>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Right Side: Rx -->
        <div class="col-6">
            <div class="rx-title">Rx</div>
            <ol class="medicine-list">
                @foreach ($prescription->medication ?? [] as $m)
                    <li>
                        <strong>{{ $m->drugType->drug_type ?? '' }}</strong>.
                        <strong>{{ $m->drug->trade_name ?? '' }}
                            {{ $m->drug->generic_name ? '(' . $m->drug->generic_name . ')' : '' }} </strong>
                        <strong>{{ $m->drugStrength->drug_strength ?? '' }}</strong><br>
                        {{ $m->drugDose->drug_dose ?? '' }}
                        <strong> {{ $m->drugDuration->drug_duration ?? '' }}</strong> <br>
                        <strong>Instruction:</strong> {{ $m->drugAdvice->drug_advice ?? '' }}
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
        <div class="left">
            <b>{{ $prescription->doctor->hospital_name ?? 'Hospital Name' }}</b><br>
            Address: {{ $prescription->doctor->hospital_address ?? 'N/A' }}<br>
            Phone: {{ $prescription->doctor->hospital_phone ?? '' }}
        </div>
        <div class="right">
            <b class="text-success">রোগী দেখার সময় :</b><br>
            @php
                // Group schedules by day
                $groupedSchedules = $prescription->doctor->schedules->groupBy('day_of_week');
            @endphp

            @foreach ($groupedSchedules as $day => $schedules)
                <div>
                    <strong>{{ $day }}:</strong>
                    @foreach ($schedules as $index => $sch)
                        @php
                            $start = \Carbon\Carbon::parse($sch->start_time)->format('g:i A');
                            $end = \Carbon\Carbon::parse($sch->end_time)->format('g:i A');
                        @endphp
                        <span class="text-success">{{ $start }} to {{ $end }}@if (!$loop->last)
                                ,</span>
                    @endif
            @endforeach
        </div>
        @endforeach
    </div>

    <div class="clearfix"></div>
    </div>

    <!-- CSP-safe Auto Print -->
    <script nonce="{{ $cspNonce }}">
        document.addEventListener("DOMContentLoaded", function() {
            window.print();
        });
    </script>

</body>

</html>
