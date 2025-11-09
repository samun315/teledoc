<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Prescription</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }

        .container {
            background: #ffffff;
            max-width: 800px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        .download-section {
            background: #2c3e50;
            color: white;
            padding: 15px;
            text-align: center;
        }

        .prescription {
            background: #ffffff;
            max-width: 800px;
            margin: 0 auto;
            padding: 50px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            /*border-bottom: 2px solid #333;*/
            padding-bottom: 15px;
        }

        .doctor-info {
            flex: 1;
        }

        .doctor-info h1 {
            font-size: 20px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0 0 5px 0;
        }

        .doctor-info .credentials {
            font-size: 12px;
            color: #666;
            margin: 0 0 3px 0;
        }

        .specialist-info {
            text-align: right;
            flex: 0 0 200px;
        }

        .specialist-info h2 {
            font-size: 18px;
            color: #2c3e50;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .specialist-info .reg-no {
            font-size: 12px;
            color: #666;
            margin: 5px 0;
        }

        .patient-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            /*background-color: rgb(255, 255, 255);*/
            padding: 10px;
            /*border-radius: 5px;*/
            border-bottom: 2px solid #333;
        }

        .patient-details {
            flex: 1;
        }

        .visit-details {
            flex: 0 0 150px;
            text-align: right;
        }

        .patient-details p, .visit-details p {
            margin: 2px 0;
            font-size: 12px;
        }

        .software-info {
            font-size: 10px;
            color: #666;
            text-align: center;
            margin-bottom: 15px;
        }



        .content {
            display: flex;
            gap: 20px;
        }

        .left-column {
            flex: 1;
        }

        .right-column {
            flex: 1;
            background-color: rgb(255, 255, 255);
            padding: 15px;
            border-radius: 5px;
        }

        .section {
            margin-bottom: 15px;
        }

        .section h3 {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin: 0 0 5px 0;
        }

        .section p {
            font-size: 11px;
            margin: 2px 0;
            line-height: 1.4;
        }

        .prescription-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px dotted #ffffff;
            font-size: 11px;
        }

        .prescription-item:last-child {
            border-bottom: none;
        }

        .med-name {
            font-weight: bold;
            flex: 1;
        }

        .dosage {
            color: #666;
            margin: 0 10px;
        }

        .bengali {
            color: #2c3e50;
        }

        .rx-symbol {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
            font-size: 10px;
            color: #666;
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
    </div>

    <div class="prescription">


        <div class="header">
            <div class="doctor-info">
                <h1>Professor AKM Akhtaruzzaman</h1>
                <p class="credentials">MBBS, DA, MD</p>
                <p class="credentials">Fellow in Pain Medicine (Nihon University, Japan)</p>
                <p class="credentials">Division Chief</p>
                <p class="credentials">Regional Anaesthesia & Pain Medicine</p>
                <p class="credentials">Bangabandhu Sheikh Mujib Medical University</p>
            </div>
            <div class="specialist-info">
                <h2>Interventional<br>Pain Specialist</h2>
                <p class="reg-no">BMDC Reg No: A18518</p>
            </div>
        </div>

        <div class="patient-info">
            <div class="patient-details">
                <p><strong>Name :</strong> Mr. KMA Matin</p>
                <p><strong>Age :</strong> 73 Y- 0 M- 13 D &nbsp;&nbsp; <strong>Weight :</strong> 62 Kg</p>
                <p><strong>Guardian :</strong></p>
                <p><strong>Address :</strong> Japan Garden, Mohammadpur, Dhaka</p>
            </div>
            <div class="visit-details">
                <p><strong>Date :</strong> 21/04/2025</p>
                <p><strong>Patient's ID :</strong> 9801</p>
                <p><strong>Follow-up :</strong> 2</p>
                <p><strong>Blood Group :</strong></p>
            </div>
        </div>

        <div class="software-info">
            Software developed by: CNS Computer, Gaziakandi, Fardpur. Email: cns@ho@gmail.com
        </div>

        <div class="content">
            <div class="left-column">
                <div class="section">
                    <h3>C/C :</h3>
                    <p>Pain at Back radiate to both leg below Knee with</p>
                    <p>Neck radiate to both shoulder with hand tingure</p>
                    <p>• Onset of Pain : Gradually</p>
                    <p>• Character of Pain : Aching Throbing Tingiling</p>
                    <p>• Aggregating : Sitting to Standing , Walking,</p>
                    <p>Working</p>
                    <p>• Releving : Rest.</p>
                </div>

                <div class="section">
                    <h3>Present History :</h3>
                    <p>Serve pain at neck radiate to both hands</p>
                    <p>Back pain radiate to both leg below the knee</p>
                    <p>Baoai / Bladder- need immediate evacuation</p>
                    <p>VAS: 10/10</p>
                </div>

                <div class="section">
                    <h3>Past History :</h3>
                    <p>HTN , Total Thyroidectomy, on Pladex, UROMAX</p>
                    <p>D. Crestinine : 1.34mg/dl</p>
                    <p>Uric acid: 4.7mg/dl</p>
                </div>

                <div class="section">
                    <h3>Dx :</h3>
                    <p>Cervical myelopathy with LEP with</p>
                    <p>Radiculopathy with listhesis</p>
                </div>

                <div class="section">
                    <h3>Next Plan :</h3>
                    <p>• INJ. DENOSIS-50 Mg</p>
                    <p>• Cervical Epidural injection</p>
                </div>
            </div>

            <div class="right-column">
                <div class="rx-symbol">℞</div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">1. TAB. UTRAMAL RTD 60 mg</div>
                        <div class="dosage">১ + ০ + ১</div>
                    </div>
                    <div class="bengali">খাবার পরে ১৫ দিন |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">2. TAB. ONDANSETRON</div>
                        <div class="dosage">১ + ০ + ১</div>
                    </div>
                    <div class="bengali">খাবার আগে ১৫ দিন |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">3. TAB. NAPA EXTEND 045 mg</div>
                        <div class="dosage">১ + ১ + ১</div>
                    </div>
                    <div class="bengali">খাবার পরে ১৫ দিন |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">4. CAP. VITAL-D 40,000 IU</div>
                    </div>
                    <div class="bengali">সপ্তাহে ১ টি করে ক্যাপসুল ৭ সপ্তাহ |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">5. TAB. CORALCAL DX</div>
                        <div class="dosage">০ + ১ + ০</div>
                    </div>
                    <div class="bengali">খাবার পরে ১ মাস |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">6. TAB. NEOBION</div>
                        <div class="dosage">১ + ০ + ১</div>
                    </div>
                    <div class="bengali">খাবার পরে ১ মাস |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">7. TAB. MAXPRO MUPS 20 mg</div>
                        <div class="dosage">১ + ০ + ১</div>
                    </div>
                    <div class="bengali">খাবার আগে ১ মাস |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">8. CAP. STRESIN 20 mg</div>
                        <div class="dosage">০+ ০ + ১</div>
                    </div>
                    <div class="bengali">খাবার পরে ১ মাস |</div>
                </div>

                <div class="prescription-item">
                    <div>
                        <div class="med-name">9. POWDER. ISPAHUSK 130g</div>
                        <div class="dosage">০+ ০ + ১</div>
                    </div>
                    <div class="bengali">শোবার পূর্বে সব সাথে খাবেন ২ মাস |</div>
                </div>
            </div>
        </div>

        <div class="footer">
            <p>১৬ দিন পর আবার আসবেন | <span class="bengali">পরবর্তী ভিজিট ০৭/০৫/২০২৫ ইং</span></p>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadPrescription() {
            const element = document.querySelector('.prescription');
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
