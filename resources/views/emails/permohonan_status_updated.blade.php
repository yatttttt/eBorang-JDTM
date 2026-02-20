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
            background: linear-gradient(135deg, #003366 0%, #0066cc 100%);
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
            background-color: #f8fafc;
            border-left: 5px solid #3b82f6;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .info-panel h3 {
            color: #1e3a8a;
            font-size: 18px;
            margin-bottom: 18px;
            font-weight: 700;
        }
        
        .info-row {
            display: flex;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 700;
            color: #374151;
            min-width: 150px;
            font-size: 14px;
        }
        
        .info-value {
            color: #1f2937;
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
            background-color: #3b82f6;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        
        .action-button:hover {
            background-color: #1d4fb9ff;
        }
        
        .comment-box {
            background-color: #fffbeb;
            border-left: 5px solid #f59e0b;
            padding: 25px;
            margin: 30px 0;
            border-radius: 8px;
        }
        
        .comment-box h3 {
            color: #92400e;
            font-size: 16px;
            margin-bottom: 15px;
            font-weight: 700;
        }
        
        .comment-text {
            color: #78350f;
            font-size: 14px;
            line-height: 1.7;
            font-style: italic;
        }
        
        .details-panel {
            background-color: #f9fafb;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
            border: 1px solid #e5e7eb;
        }
        
        .details-panel h3 {
            color: #374151;
            font-size: 16px;
            margin-bottom: 18px;
            font-weight: 700;
        }
        
        .details-panel ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .details-panel li {
            padding: 10px 0;
            color: #4b5563;
            font-size: 14px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .details-panel li:last-child {
            border-bottom: none;
        }
        
        .details-panel strong {
            color: #1f2937;
            font-weight: 700;
            min-width: 160px;
            display: inline-block;
        }

        .status-text-lulus {
            color: #10b981;
            font-weight: bold;
        }

        .status-text-kiv {
            color: #f59e0b;
            font-weight: bold;
        }

        .status-text-tolak {
            color: #ef4444;
            font-weight: bold;
        }

        .status-text-selesai {
            color: #10b981;
            font-weight: bold;
        }

        .status-text-ditolak {
            color: #ef4444;
            font-weight: bold;
        }

        .status-text-dalam-proses {
            color: #3b82f6;
            font-weight: bold;
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
            text-align: center;
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
            
            .status-badge {
                padding: 12px 30px !important;
                font-size: 16px !important;
            }
            
            .action-button {
                padding: 14px 35px !important;
                font-size: 15px !important;
            }
            
            .details-panel strong {
                min-width: 100%;
                display: block;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="outer-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Kemas Kini Status Permohonan</h1>
            </div>
            
            <div class="email-body">
                <p class="greeting">Assalamualaikum dan Salam Sejahtera,</p>
                
                <p class="intro-text">
                    Permohonan telah dikemas kini oleh <strong>{{ $updatedBy->nama }}</strong> ({{ ucfirst($role) }}).
                </p>
                
                <!-- Maklumat Permohonan -->
                <div class="info-panel">
                    <h3>Maklumat Permohonan</h3>
                    
                    <div class="info-row">
                        <span class="info-label">ID Permohonan:</span>
                        <span class="info-value">{{ $permohonan->id_permohonan }}</span>
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
                </div>
                
                <!-- Butiran Kemaskini -->
                <div class="details-panel">
                    <h3>Butiran Kemaskini</h3>
                    <ul>
                        <li>
                            <strong>Dikemaskini oleh:</strong> {{ $updatedBy->nama }}
                        </li>
                        <li>
                            <strong>Peranan:</strong> {{ ucfirst($role) }}
                        </li>
                        <li>
                            <strong>Jawatan:</strong> {{ $updatedBy->jawatan ?? 'N/A' }}
                        </li>
                        <li>
                            <strong>Tarikh & Masa:</strong> {{ now()->format('d/m/Y') }}
                        </li>
                    </ul>
                </div>

                <!-- Ulasan -->
                @if($ulasan)
                <div class="comment-box">
                    <h3>💬 Ulasan {{ ucfirst($role) }}</h3>
                    <p class="comment-text">"{{ $ulasan }}"</p>
                </div>
                @endif

                <!-- Status Workflow (Overall) -->
                <div class="details-panel">
                    <h3>Status Keseluruhan Permohonan</h3>
                    <ul>
                        @if($permohonan->status_pengarah)
                        <li>
                            <strong>Pengarah:</strong> 
                            @php
                                $statusClass = '';
                                $statusLower = strtolower($permohonan->status_pengarah);
                                if ($statusLower === 'lulus') {
                                    $statusClass = 'status-text-lulus';
                                } elseif ($statusLower === 'kiv') {
                                    $statusClass = 'status-text-kiv';
                                } elseif ($statusLower === 'tolak') {
                                    $statusClass = 'status-text-tolak';
                                }
                            @endphp
                            <span class="{{ $statusClass }}">{{ $permohonan->status_pengarah }}</span>
                        </li>
                        @endif

                        @if($permohonan->status_pegawai)
                        <li>
                            <strong>Pegawai:</strong> 
                            @php
                                $statusClass = '';
                                $statusLower = strtolower($permohonan->status_pegawai);
                                if ($statusLower === 'lulus') {
                                    $statusClass = 'status-text-lulus';
                                } elseif ($statusLower === 'kiv') {
                                    $statusClass = 'status-text-kiv';
                                } elseif ($statusLower === 'tolak') {
                                    $statusClass = 'status-text-tolak';
                                }
                            @endphp
                            <span class="{{ $statusClass }}">{{ $permohonan->status_pegawai }}</span>
                        </li>
                        @endif

                        @if($permohonan->status_pentadbir_sistem)
                        <li>
                            <strong>Pentadbir Sistem:</strong> 
                            @php
                                $statusClass = '';
                                $statusLower = strtolower($permohonan->status_pentadbir_sistem);
                                if ($statusLower === 'lulus') {
                                    $statusClass = 'status-text-lulus';
                                } elseif ($statusLower === 'kiv') {
                                    $statusClass = 'status-text-kiv';
                                } elseif ($statusLower === 'tolak') {
                                    $statusClass = 'status-text-tolak';
                                }
                            @endphp
                            <span class="{{ $statusClass }}">{{ $permohonan->status_pentadbir_sistem }}</span>
                        </li>
                        @endif

                        <li>
                            <strong>Status Permohonan:</strong> 
                            @php
                                $statusClass = '';
                                $statusLower = strtolower($permohonan->status_permohonan ?? '');
                                if ($statusLower === 'selesai') {
                                    $statusClass = 'status-text-selesai';
                                } elseif ($statusLower === 'kiv') {
                                    $statusClass = 'status-text-kiv';
                                } elseif ($statusLower === 'ditolak') {
                                    $statusClass = 'status-text-ditolak';
                                } elseif ($statusLower === 'dalam proses') {
                                    $statusClass = 'status-text-dalam-proses';
                                }
                            @endphp
                            <span class="{{ $statusClass }}">{{ $permohonan->status_permohonan }}</span>
                        </li>
                    </ul>
                </div>

                 <div class="button-wrapper">
                        <a href="{{ route('admin.permohonan.show', $permohonan->id_permohonan) }}" class="action-button">
                            LIHAT PERMOHONAN
                        </a>
                    </div>
                
                <!-- Alternative Link -->
                <div class="link-box">
                    <p><strong>Jika butang tidak berfungsi:</strong></p>
                    <p>Salin dan tampal URL berikut ke dalam pelayar web anda:</p>
                    <span class="link-text">{{ route('admin.permohonan.show', $permohonan->id_permohonan) }}</span>
                </div>
                
                <!-- Signature -->
                <div class="signature">
                    <p>Terima kasih,</p>
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