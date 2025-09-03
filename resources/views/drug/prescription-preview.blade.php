<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Preview - DPMC</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.0;
            color: #000;
            background: #f5f5f5;
            font-size: 9px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .download-section {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .download-btn {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 20px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .download-btn:hover {
            background: #2980b9;
        }

        .prescription-content {
            padding: 15px;
            background: white;
        }

        /* Header Section */
        .header {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 8px;
        }

        .clinic-logo {
            font-size: 20px;
            font-weight: bold;
            color: #000;
            margin-bottom: 2px;
        }

        .bengali-text {
            font-size: 10px;
            color: #000;
            margin-bottom: 2px;
        }

        .clinic-name {
            font-size: 14px;
            font-weight: bold;
            color: #000;
            margin-bottom: 2px;
            text-transform: uppercase;
        }

        .clinic-address {
            font-size: 8px;
            color: #000;
            margin-bottom: 1px;
        }

        .clinic-contact {
            font-size: 7px;
            color: #000;
            line-height: 1.0;
        }

        /* Main Layout */
        .main-layout {
            display: flex;
            gap: 15px;
            margin-bottom: 12px;
        }

        .left-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .right-panel {
            width: 200px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        /* Doctor Section */
        .doctor-section {
            border: 1px solid #000;
            padding: 8px;
            background: #f8f8f8;
            min-height: 80px;
        }

        .doctor-name {
            font-size: 12px;
            font-weight: bold;
            color: #000;
            margin-bottom: 2px;
        }

        .doctor-qualifications {
            font-size: 9px;
            color: #000;
            margin-bottom: 1px;
        }

        .doctor-specialty {
            font-size: 8px;
            color: #000;
            margin-bottom: 1px;
            line-height: 1.0;
        }

        .doctor-affiliation {
            font-size: 7px;
            color: #000;
            margin-bottom: 1px;
        }

        /* Patient Section */
        .patient-section {
            border: 1px solid #000;
            padding: 8px;
            background: #f0f0f0;
            min-height: 80px;
        }

        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #000;
            margin-bottom: 4px;
            text-decoration: underline;
        }

        .patient-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 2px;
        }

        .patient-item {
            display: flex;
            justify-content: space-between;
            font-size: 8px;
        }

        .patient-label {
            font-weight: bold;
            color: #000;
        }

        .patient-value {
            color: #000;
        }

        /* Clinical Details */
        .clinical-section {
            border: 1px solid #000;
            padding: 8px;
            background: #f8f8f8;
        }

        .clinical-item {
            margin-bottom: 6px;
        }

        .clinical-title {
            font-weight: bold;
            color: #000;
            margin-bottom: 2px;
            font-size: 9px;
        }

        .clinical-content {
            background: #fff;
            padding: 4px;
            border: 1px solid #ccc;
            font-size: 7px;
            line-height: 1.1;
            margin-left: 8px;
        }

        /* Prescription Section */
        .prescription-section {
            border: 1px solid #000;
            padding: 8px;
            background: #f8f8f8;
        }

        .prescription-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #000;
            margin-bottom: 8px;
        }

        .prescription-list {
            margin-top: 5px;
        }

        .medication-item {
            margin-bottom: 3px;
            line-height: 1.1;
            display: flex;
            align-items: flex-start;
        }

        .med-number {
            font-weight: bold;
            color: #000;
            font-size: 8px;
            width: 15px;
            margin-right: 5px;
        }

        .med-name {
            font-weight: bold;
            color: #000;
            font-size: 8px;
            width: 160px;
            margin-right: 8px;
        }

        .med-dosage {
            color: #000;
            font-size: 7px;
            width: 35px;
            margin-right: 5px;
        }

        .med-timing {
            color: #000;
            font-size: 7px;
            width: 70px;
            margin-right: 5px;
        }

        .med-instruction {
            color: #000;
            font-size: 7px;
            width: 50px;
            margin-right: 5px;
        }

        .med-duration {
            color: #000;
            font-size: 7px;
            flex: 1;
        }

        /* Follow-up Section */
        .followup-section {
            background: #e8f5e8;
            padding: 8px;
            border: 1px solid #000;
            text-align: center;
            margin-bottom: 8px;
        }

        .followup-title {
            font-size: 10px;
            font-weight: bold;
            color: #000;
            margin-bottom: 4px;
        }

        .followup-content {
            font-size: 8px;
        }

        /* Signature Area */
        .signature-area {
            text-align: right;
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1px solid #000;
        }

        .signature-line {
            width: 120px;
            height: 1px;
            background: #000;
            margin: 4px 0;
            display: inline-block;
        }

        .signature-text {
            font-size: 8px;
            margin-bottom: 2px;
        }

        .footer {
            text-align: center;
            padding: 8px;
            background: #f0f0f0;
            color: #000;
            font-size: 7px;
            border: 1px solid #000;
            margin-top: 12px;
        }

        @media print {
            .download-section {
                display: none;
            }
            .container {
                box-shadow: none;
                margin: 0;
            }
            body {
                background: white;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="download-section">
            <h3>Prescription Preview</h3>
            <p>Review the prescription before downloading</p>
            <button class="download-btn" onclick="downloadPrescription()">Download Prescription</button>
        </div>

        <div class="prescription-content">
            <!-- Header -->
            <div class="header">
                <div class="clinic-logo">DPMC</div>
                <div class="bengali-text">ব্যথা নিরাময়ে আমরাই</div>
                <div class="clinic-name">DHAKA PAIN MANAGEMENT CENTRE</div>
                <div class="clinic-address">Rupayan Prime, Level-5, House No. 2, Road No. 7, Green Road, Dhanmondi R/A, Dhaka-1205</div>
                <div class="clinic-contact">
                    Tel: +88 029614511 | Mobile: +88 01815754345, +88 01785853632, +88 01743322955<br>
                    E-mail: paindhaka.bd@gmail.com | Website: www.dpmcbd.com, www.paindoctor.com.bd
                </div>
            </div>

            <!-- Main Layout -->
            <div class="main-layout">
                <!-- Left Panel -->
                <div class="left-panel">
                    <!-- Doctor Section -->
                    <div class="doctor-section">
                        <div class="doctor-name">Professor AKM Akhtaruzzaman</div>
                        <div class="doctor-qualifications">MBBS, DA, MD</div>
                        <div class="doctor-specialty">Fellow in Pain Medicine (Nihon University, Japan)</div>
                        <div class="doctor-specialty">Division Chief, Regional Anaesthesia & Pain Medicine</div>
                        <div class="doctor-specialty">Interventional Pain Specialist</div>
                        <div class="doctor-affiliation">Bangabandhu Sheikh Mujib Medical University</div>
                        <div class="doctor-affiliation">BMDC Registration No.: A18518</div>
                        <div class="doctor-affiliation">Consultant Pain Physician, Dhaka Pain Management Center</div>
                    </div>

                    <!-- Clinical Details -->
                    <div class="clinical-section">
                        <div class="section-title">Clinical Details</div>

                        <div class="clinical-item">
                            <div class="clinical-title">C/C (Chief Complaint):</div>
                            <div class="clinical-content">
                                Pain at Back radiate to both leg below Knee with Neck radiate to both shoulder with hand fingure<br>
                                Onset of Pain: Gradually<br>
                                Charecter of Pain: Aching, Throbing, Tingling,<br>
                                Aggravating: Sitting to Standing, Walking, Working,<br>
                                Relieving: Rest,
                            </div>
                        </div>

                        <div class="clinical-item">
                            <div class="clinical-title">Present History:</div>
                            <div class="clinical-content">
                                Sevre pain at neck radiate to both hands<br>
                                Back pain radiate to both leg below the knee<br>
                                Bowel/Bladder: need immediate evacuation<br>
                                VAS: 10/10
                            </div>
                        </div>

                        <div class="clinical-item">
                            <div class="clinical-title">Past History:</div>
                            <div class="clinical-content">
                                HTN, Total Thyroidectomy, on Pladex, UROMAX D, Creatinine: 1.24mg/dl<br>
                                Uric acid: 4.7mg/dl
                            </div>
                        </div>

                        <div class="clinical-item">
                            <div class="clinical-title">Dx (Diagnosis):</div>
                            <div class="clinical-content">
                                Cervical myolopathy with LBP with Radiculopathy with listhesis
                            </div>
                        </div>

                        <div class="clinical-item">
                            <div class="clinical-title">Next Plan:</div>
                            <div class="clinical-content">
                                INJ. DENOSIS-60 Mg<br>
                                Cervical Epidural Injection
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel -->
                <div class="right-panel">
                    <!-- Patient Section -->
                    <div class="patient-section">
                        <div class="section-title">Patient Information</div>
                        <div class="patient-grid">
                            <div class="patient-item">
                                <span class="patient-label">Date:</span>
                                <span class="patient-value">21/04/2025</span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Patient's ID:</span>
                                <span class="patient-value">9601</span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Follow up:</span>
                                <span class="patient-value">2</span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Blood Group:</span>
                                <span class="patient-value"></span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Name:</span>
                                <span class="patient-value">Mr. KMA Matin</span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Age:</span>
                                <span class="patient-value">79 Y-0 M-13 D</span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Weight:</span>
                                <span class="patient-value">62 Kg</span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Guardian:</span>
                                <span class="patient-value"></span>
                            </div>
                            <div class="patient-item">
                                <span class="patient-label">Address:</span>
                                <span class="patient-value">Japan Garden, Mohammadpur, Dhaka</span>
                            </div>
                        </div>
                    </div>

                    <!-- Prescription Section -->
                    <div class="prescription-section">
                        <div class="prescription-header">R</div>
                        <div class="prescription-list">
                            <div class="medication-item">
                                <span class="med-number">1.</span>
                                <span class="med-name">TAB. UTRAMAL RTD 50 mg:</span>
                                <span class="med-dosage">1+0+1</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার পরে</span>
                                <span class="med-duration">১৪ দিন।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">2.</span>
                                <span class="med-name">TAB. ONDAN 8 mg:</span>
                                <span class="med-dosage">1+0+1</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার আগে</span>
                                <span class="med-duration">১৪ দিন।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">3.</span>
                                <span class="med-name">TAB. NAPA EXTEND 665 mg:</span>
                                <span class="med-dosage">1+1+1</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার পরে,</span>
                                <span class="med-duration">১৪ দিন।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">4.</span>
                                <span class="med-name">CAP. VITAL-D 40,000 IU:</span>
                                <span class="med-dosage"></span>
                                <span class="med-timing">সপ্তাহে ১ টি করে ক্যাপসুল</span>
                                <span class="med-instruction"></span>
                                <span class="med-duration">৭ সপ্তাহ।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">5.</span>
                                <span class="med-name">TAB. CORALCAL DX:</span>
                                <span class="med-dosage">0+1+0</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার পরে,</span>
                                <span class="med-duration">১ মাস।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">6.</span>
                                <span class="med-name">TAB. NEOBION:</span>
                                <span class="med-dosage">1+0+1</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার পরে,</span>
                                <span class="med-duration">১ মাস।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">7.</span>
                                <span class="med-name">TAB. MAXPRO MUPS 20 mg:</span>
                                <span class="med-dosage">1+0+1</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার আগে,</span>
                                <span class="med-duration">১ মাস।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">8.</span>
                                <span class="med-name">CAP. STRESIN 20 mg:</span>
                                <span class="med-dosage">0+0+1</span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">খাবার পরে</span>
                                <span class="med-duration">১ মাস।</span>
                            </div>
                            <div class="medication-item">
                                <span class="med-number">9.</span>
                                <span class="med-name">POWDER. ISPAHUSK 130g:</span>
                                <span class="med-dosage"></span>
                                <span class="med-timing"></span>
                                <span class="med-instruction">পানিতে গুলিয়ে সঙ্গে সঙ্গে খাবেন ২বার।</span>
                                <span class="med-duration"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Follow-up Section -->
                    <div class="followup-section">
                        <div class="followup-title">Follow-up Information</div>
                        <div class="followup-content">
                            <p>১৪ দিন পর আবার আসবেন। সম্ভাব্য তারিখঃ ০৫/০৫/২০২৫ইং</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Signature Area -->
            <div class="signature-area">
                <div class="signature-line"></div>
                <div class="signature-text"><strong>Professor AKM Akhtaruzzaman</strong></div>
                <div class="signature-text">Consultant Pain Physician</div>
            </div>
        </div>

        <div class="footer">
            <p>Software Developer: CNS Computer, Goalchamot, Faridpur | Email: cnsfrd@gmail.com</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPrescription() {
            const element = document.querySelector('.prescription-content');
            const opt = {
                margin: 10,
                filename: 'prescription_dpmc.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>
</html>
