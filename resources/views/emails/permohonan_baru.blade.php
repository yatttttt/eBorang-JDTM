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
            background: linear-gradient(135deg, #8b5cf6 0%, #6d28d9 100%);
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
        
        .info-panel {
            background-color: #fef3c7;
            border-left: 5px solid #f59e0b;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .info-panel h3 {
            color: #92400e;
            font-size: 18px;
            margin-bottom: 18px;
            font-weight: 700;
        }
        
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #fde68a;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 700;
            color: #78350f;
            min-width: 150px;
            font-size: 14px;
        }
        
        .info-value {
            color: #451a03;
            font-size: 14px;
            flex: 1;
        }
        
        .button-wrapper {
            text-align: center;
            margin-top: 20px;
        }
        
        .action-button {
            display: inline-block;
            padding: 15px 45px;
            background-color: #8b5cf6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .action-button:hover {
            background-color: #7c3aed;
        }
        
        .urgency-box {
            background-color: #fee2e2;
            border-left: 5px solid #ef4444;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .urgency-box h3 {
            color: #991b1b;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .urgency-text {
            color: #7f1d1d;
            font-size: 14px;
            line-height: 1.7;
        }
        
        .link-box {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
            border: 1px solid #bfdbfe;
        }
        
        .link-box p {
            margin-bottom: 12px;
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
                <h1>Permohonan Baru</h1>
            </div>
            
            <div class="email-body">
                <p class="greeting">Assalamualaikum dan Salam Sejahtera,</p>
                
                <p class="intro-text">
                    Permohonan baharu telah diterima dan menunggu semakan anda sebagai <strong>{{ ucwords(str_replace('_', ' ', $recipientRole)) }}</strong>.
                </p>
                
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
                        <span class="info-label">Tarikh Hantar:</span>
                        <span class="info-value">{{ $permohonan->tarikh_hantar ? $permohonan->tarikh_hantar->format('d/m/Y') : 'N/A' }}</span>
                    </div>
                </div>
                
                <!-- Tindakan Diperlukan -->
                <div class="urgency-box">
                    <h3>⚠️ Tindakan Diperlukan</h3>
                    <p class="urgency-text">Permohonan ini memerlukan semakan dan kelulusan daripada anda. Sila semak permohonan dan buat keputusan dengan segera.</p>
                </div>

                <div class="button-wrapper">
                    @php
                        $roleRoutes = [
                            'pengarah' => 'pengarah.permohonan.edit',
                            'pegawai' => 'pegawai.permohonan.edit',
                            'pentadbir_sistem' => 'pentadbir_sistem.permohonan.edit'
                        ];
                        $routeName = $roleRoutes[$recipientRole] ?? 'admin.permohonan.show';
                    @endphp
                    <a href="{{ route($routeName, $permohonan->id_permohonan) }}" class="action-button">
                        SEMAK PERMOHONAN
                    </a>
                </div>
                
                <!-- Alternative Link -->
                <div class="link-box">
                    <p><strong>Jika butang tidak berfungsi:</strong></p>
                    <p>Salin dan tampal URL berikut ke dalam pelayar web anda:</p>
                    <span class="link-text">{{ route($routeName, $permohonan->id_permohonan) }}</span>
                </div>
                
                <!-- Signature -->
                <div class="signature">
                    <p>Terima kasih atas kerjasama anda,</p>
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