<!DOCTYPE html>
<html style="height: auto !important; overflow: visible !important;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        html {
            height: auto !important;
            min-height: 100% !important;
            overflow: visible !important;
            overflow-y: auto !important;
        }
        
        body {
            height: auto !important;
            min-height: 100% !important;
            overflow: visible !important;
            overflow-y: auto !important;
            margin: 0 !important;
            padding: 30px 15px !important;
            font-family: Arial, Helvetica, sans-serif;
            background-color: #f4f4f4;
        }
        
        .outer-wrapper {
            width: 100%;
            height: auto;
            min-height: 100vh;
            overflow: visible;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #003366 0%, #0066cc 100%);
            padding: 35px 25px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        
        .email-header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        
        .email-body {
            padding: 35px 30px;
            color: #333333;
        }
        
        .email-body p {
            margin-bottom: 18px;
            font-size: 15px;
            line-height: 1.7;
        }
        
        .button-wrapper {
            text-align: center;
            margin: 35px 0;
        }
        
        .reset-button {
            display: inline-block;
            padding: 15px 45px;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
        }
        
        .warning-box {
            background-color: #fff9e6;
            border-left: 5px solid #ffc107;
            padding: 20px 25px;
            margin: 30px 0;
            border-radius: 6px;
        }
        
        .warning-box strong {
            color: #856404;
            font-size: 15px;
            display: block;
            margin-bottom: 15px;
        }
        
        .warning-box ul {
            margin: 0;
            padding-left: 25px;
        }
        
        .warning-box li {
            margin: 12px 0;
            color: #555555;
            font-size: 14px;
            line-height: 1.6;
        }
        
        .link-box {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            border: 1px solid #bfdbfe;
        }
        
        .link-box p {
            margin-bottom: 15px;
            color: #374151;
            font-size: 13px;
        }
        
        .link-text {
            word-wrap: break-word;
            word-break: break-all;
            overflow-wrap: break-word;
            color: #3b82f6;
            font-size: 13px;
            line-height: 1.8;
            display: block;
        }
        
        .signature {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #e5e7eb;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 25px 20px;
            text-align: center;
            border-radius: 0 0 10px 10px;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            margin: 10px 0;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }
        
        @media only screen and (max-width: 640px) {
            body {
                padding: 15px 10px !important;
            }
            
            .email-body {
                padding: 25px 20px !important;
            }
            
            .email-header {
                padding: 25px 20px !important;
            }
            
            .email-header h1 {
                font-size: 24px !important;
            }
            
            .reset-button {
                padding: 14px 35px !important;
            }
        }
    </style>
</head>
<body>
    <div class="outer-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Reset Kata Laluan</h1>
            </div>
            
            <div class="email-body">
                <p>Assalamualaikum dan Salam Sejahtera,</p>
                
                <p>Kami menerima permintaan untuk menetapkan semula kata laluan akaun <strong>eBorang JDTM</strong> anda.</p>
                
                <p>Klik butang di bawah untuk menetapkan semula kata laluan anda:</p>
                
                <div class="button-wrapper">
                    <a href="{{ $resetLink }}" class="reset-button">RESET KATA LALUAN</a>
                </div>
                
                <div class="warning-box">
                    <strong>⚠️ Nota Penting:</strong>
                    <ul>
                        <li>Pautan ini akan <strong>tamat tempoh dalam 60 minit</strong></li>
                        <li>Jika anda tidak membuat permintaan ini, sila abaikan email ini</li>
                        <li>Kata laluan anda tidak akan berubah sehingga anda mengakses pautan di atas dan mencipta kata laluan baharu</li>
                    </ul>
                </div>
                
                <div class="link-box">
                    <p><strong>Jika butang tidak berfungsi:</strong></p>
                    <p>Salin dan tampal URL berikut ke dalam pelayar web anda:</p>
                    <span class="link-text">{{ $resetLink }}</span>
                </div>
                
                <div class="signature">
                    <p>Terima kasih,</p>
                    <p><strong>Pasukan eBorang JDTM</strong></p>
                </div>
            </div>
            
            <div class="email-footer">
                <p><strong>Email automatik - Sila jangan balas</strong></p>
                <p>Email ini dihantar secara automatik oleh Sistem eBorang JDTM.</p>
                <p>&copy; {{ date('Y') }} eBorang JDTM. Hak Cipta Terpelihara.</p>
            </div>
        </div>
    </div>
</body>
</html>