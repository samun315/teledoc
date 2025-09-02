<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prescription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 13px; }
        .header-bar {
            background: #c80000;
            color: #fff;
            padding: 6px 10px;
            font-weight: bold;
            font-size: 14px;
            text-align: center;
        }
        .doctor-info {
            font-size: 12px;
            line-height: 1.4;
        }
        .patient-info {
            font-size: 13px;
            white-space: nowrap;
            overflow-x: auto;
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
            margin: 0;
            padding-left: 20px;
            text-align: left; /* <-- changed from right to left */
            list-style-position: inside;
        }
        .history-section div {
            margin-bottom: 5px;
        }
        .advice-list {
            margin-top: 10px;
            padding-left: 20px;
        }
        .footer-bar {
            background: #006400;
            color: #fff;
            padding: 10px;
            font-size: 11px;
            margin-top: 30px;
        }
        .footer-bar .left { float: left; width: 50%; }
        .footer-bar .right { float: right; width: 50%; text-align: right; }
        .clearfix { clear: both; }
    </style>
</head>
<body class="p-4">

    <!-- Red Header -->
    <div class="header-bar">
        ডাক্তার এর পরামর্শ ছাড়া কোন ঔষধ খাওয়া বা ব্যবহার করা রোগীর জন্য ঝুঁকিপূর্ণ
    </div>

    <!-- Doctor Info -->
    <div class="row mt-2">
        <div class="col-8 doctor-info">
            <strong>Dr. Monowara Begum</strong><br>
            MBBS, DGO, FCPS (Obs & Gynae)<br>
            FCPS (Gynaecological Oncology)<br>
            Advanced Training in Laparoscopic Surgery,<br>
            Hysteroscopy, Gynae Oncology
        </div>
        <div class="col-4 text-end doctor-info">
            Asst. Professor (Obs & Gynae Oncology)<br>
            Bangabandhu Sheikh Mujib Medical University<br>
            Reg: BMC-12345
        </div>
    </div>

    <hr>

    <!-- Patient Info Horizontal -->
    <div class="patient-info">
        <div><b>Name:</b> Mrs. Y</div>
        <div><b>Age:</b> 28 Yrs</div>
        <div><b>Weight:</b> 70 kg</div>
        <div><b>Blood Group:</b> O+</div>
        <div><b>Date:</b> 24.04.2025</div>
        <div><b>Follow up:</b> After 1 Month</div>
    </div>

    <!-- Main Content Row -->
    <div class="row mt-3">
        <!-- Left Side: C/C, History, Dx, Advice -->
        <div class="col-6 history-section">
            <div>
                <b>C/C:</b>
                <ul>
                    <li>Irregular menses</li>
                    <li>Fatigue</li>
                </ul>
            </div>
            <div>
                <b>Present History:</b>
                Patient reports irregular cycles for the last 6 months.
            </div>
            <div>
                <b>Past History:</b>
                No significant past illness.
            </div>
            <div>
                <b>Dx:</b>
                Hypothyroidism
            </div>
            <div class="advice-section">
                <b>Advice:</b>
                <ul class="advice-list">
                    <li>TVS</li>
                    <li>FSH + FT4</li>
                    <li>FSH + LH</li>
                    <li>Prolactin</li>
                    <li>AMH</li>
                    <li>Pl. do count 20%</li>
                </ul>
            </div>
        </div>

        <!-- Right Side: Rx (Left-aligned now) -->
        <div class="col-6">
            <div class="rx-title">Rx</div>
            <ul class="medicine-list">
                <li>Thyrox (25 mcg) — 1+0+0 (3 Months)</li>
                <li>Metfo (500 mg) — 0+1+0 (6 Months)</li>
                <li>Folic-3 — 0+1+0 (6 Months)</li>
            </ul>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer-bar mt-5">
        <div class="left">
            <b>Hospital Name</b><br>
            Address: 123, Green Road, Dhaka<br>
            Phone: +8801XXXXXXXXX
        </div>
        <div class="right">
            <b>Chamber Time:</b><br>
            Sat - Thu: 5:00 PM – 9:00 PM<br>
            Friday: Closed
        </div>
        <div class="clearfix"></div>
    </div>

</body>
</html>
