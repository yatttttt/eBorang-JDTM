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
            max-width: 650px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            padding: 40px 30px;
            text-align: center;
            border-radius: 12px 12px 0 0;
        }
        
        .email-header h1 {
            color: #ffffff;
            text-align: center;
            margin: 0;
            font-size: 30px;
            font-weight: 700;
        }
        
        .email-body {
            padding: 40px 35px;
            color: #333333;
        }
        
        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #374151;
        }
        
        .intro-text {
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 25px;
            color: #4b5563;
        }
        
        .success-panel {
            background-color: #d1fae5;
            border-left: 5px solid #10b981;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .success-panel h3 {
            color: #065f46;
            font-size: 18px;
            margin-bottom: 12px;
            font-weight: 700;
        }
        
        .success-panel p {
            color: #047857;
            font-size: 14px;
            line-height: 1.7;
            margin: 0;
        }
        
        .info-panel {
            background-color: #f0f9ff;
            border-left: 5px solid #3b82f6;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .info-panel h3 {
            color: #1e40af;
            font-size: 18px;
            margin-bottom: 18px;
            font-weight: 700;
        }
        
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #dbeafe;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 700;
            color: #1e3a8a;
            min-width: 150px;
            font-size: 14px;
        }
        
        .info-value {
            color: #1e40af;
            font-size: 14px;
            flex: 1;
        }
        
        .button-wrapper {
            text-align: center;
            margin: 30px 0;
        }
        
        .action-button {
            display: inline-block;
            padding: 15px 45px;
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .action-button:hover {
            background-color: #2563eb;
        }
        
        .signature {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #e5e7eb;
        }
        
        .signature p {
            margin: 8px 0;
            color: #4b5563;
            font-size: 15px;
        }
        
        .email-footer {
            background-color: #f8f9fa;
            padding: 30px 25px;
            text-align: center;
            border-radius: 0 0 12px 12px;
            border-top: 1px solid #e5e7eb;
        }
        
        .email-footer p {
            margin: 10px 0;
            color: #6b7280;
            font-size: 13px;
            line-height: 1.6;
        }
        
        .email-footer strong {
            color: #374151;
        }
        
        @media only screen and (max-width: 640px) {
            body {
                padding: 15px 10px !important;
            }
            
            .email-body {
                padding: 30px 20px !important;
            }
            
            .email-header {
                padding: 30px 20px !important;
            }
            
            .email-header h1 {
                font-size: 26px !important;
            }
            
            .info-row {
                flex-direction: column;
            }
            
            .info-label {
                min-width: 100%;
                margin-bottom: 5px;
            }
            
            .action-button {
                padding: 14px 35px !important;
                font-size: 15px !important;
            }
        }
    </style>
</head>
<body>
    <div class="outer-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Permohonan Berjaya Dihantar</h1>
            </div>
            
            <div class="email-body">
                <p class="greeting">Assalamualaikum dan Salam Sejahtera,</p>
                
                <p class="intro-text">
                    Permohonan <strong>{{ $permohonan->id_permohonan }}</strong> telah berjaya diterima oleh sistem kami.
                </p>
                
                <!-- Success Message -->
                <div class="success-panel">
                    <h3>Permohonan Diterima</h3>
                    <p>Permohonan anda telah berjaya dihantar pada <strong>{{ $permohonan->tarikh_hantar ? $permohonan->tarikh_hantar->format('d/m/Y') : now()->format('d/m/Y') }}</strong> dan sedang menunggu untuk semakan selanjutnya.</p>
                </div>
                
                <!-- Maklumat Permohonan -->
                <div class="info-panel">
                    <h3>Maklumat Permohonan</h3>
                    
                    <div class="info-row">
                        <span class="info-label">ID Permohonan:</span>
                        <span class="info-value"><strong>{{ $permohonan->id_permohonan }}</strong></span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Nama Pemohon:</span>
                        <span class="info-value">{{ $permohonan->nama_pemohon }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">No. Kad Pengenalan:</span>
                        <span class="info-value">{{ $permohonan->no_kp }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Jawatan:</span>
                        <span class="info-value">{{ $permohonan->jawatan ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Jabatan:</span>
                        <span class="info-value">{{ $permohonan->jabatan ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Kategori:</span>
                        <span class="info-value">{{ $permohonan->formatted_kategori ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="info-row">
                        <span class="info-label">Status Semasa:</span>
                        <span class="info-value"><strong>Menunggu Semakan</strong></span>
                    </div>
                </div>
                
                <!-- View Application Button -->
                <div class="button-wrapper">
                    <a href="{{ route('admin.permohonan.show', $permohonan->id_permohonan) }}" class="action-button">
                        SEMAK STATUS PERMOHONAN
                    </a>
                </div>
                
                <!-- Signature -->
                <div class="signature">
                    <p>Sekian, terima kasih.</p>
                    <p><strong>Pasukan {{ config('app.name', 'Sistem eBorang JDTM') }}</strong></p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="email-footer">
                <p><strong>Email automatik - Sila jangan balas</strong></p>
                <p>Email ini dihantar secara automatik oleh Sistem eBorang JDTM.</p>
                <p>&copy; {{ date('Y') }} Sistem eBorang JDTM. Hak Cipta Terpelihara.</p>
            </div>
        </div>
    </div>
</body>
</html>