<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 40px 30px;
        }
        .success-icon {
            text-align: center;
            font-size: 48px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .alert {
            background-color: #fee;
            border-left: 4px solid #ef4444;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Kata Laluan Berjaya Dikemaskini</h1>
        </div>
        <div class="content">
            <div class="success-icon">✓</div>
            
            <p>Assalamualaikum dan Salam Sejahtera,</p>
            
            <p>Kata laluan anda untuk akaun <strong>eBorang JDTM</strong> telah berjaya dikemaskini.</p>
            
            <p><strong>Tarikh & Masa:</strong> {{ now()->format('d/m/Y') }}</p>
            
            <div class="alert">
                <strong>Adakah ini anda?</strong>
                <p style="margin: 10px 0 0 0;">
                    Jika anda <strong>TIDAK</strong> membuat perubahan ini, sila hubungi pentadbir sistem dengan segera kerana akaun anda mungkin telah diakses tanpa kebenaran.
                </p>
            </div>
            
            <p>Sekiranya anda mengalami sebarang masalah, sila hubungi pasukan sokongan kami.</p>
            
            <p style="margin-top: 30px;">
                Terima kasih,<br>
                <strong>Pasukan eBorang JDTM</strong>
            </p>
        </div>
        <div class="footer">
            <p><strong>Email automatik - Sila jangan balas</strong></p>
            <p>Email ini dihantar secara automatik oleh Sistem eBorang JDTM.</p>
            <p>&copy; {{ date('Y') }} eBorang JDTM. Hak Cipta Terpelihara.</p>
        </div>
    </div>
</body>
</html>