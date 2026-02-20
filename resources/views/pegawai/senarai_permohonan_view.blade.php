<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maklumat Permohonan</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-gradient: linear-gradient(135deg, #003366 0%, #000000ff 100%);
            --glass-bg: rgba(255, 255, 255, 0.15);
            --glass-border: rgba(255, 255, 255, 0.2);
            --glass-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        body {
            background: var(--primary-gradient) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            position: relative;
            overflow-x: hidden;
            margin: 0 !important;
            padding: 0 !important;
        }

        .modern-container {
            padding: 2rem;
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: slideInDown 0.5s ease;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #22c55e;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
        }

        .alert i {
            font-size: 1.2rem;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: visible !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            z-index: 100;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        }

        .page-header h1 {
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: 2px;
        }

        .detail-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .section-title {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding-bottom: 1rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        .section-title i {
            color: #60a5fa;
        }

        .section-title span {
            background: rgba(71, 85, 105, 0.6);
            padding: 0.5rem 1.2rem;
            border-radius: 25px;
            border: 1px solid rgba(148, 163, 184, 0.5);
            font-size: 0.9rem;
            margin-left: auto;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            color: rgba(226, 232, 240, 0.9);
            font-weight: 500;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .section-title span.section-badge {
            background: rgba(71, 85, 105, 0.6);
            border: 1px solid rgba(148, 163, 184, 0.5);
            color: rgba(226, 232, 240, 0.9);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

         .info-value {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

          .info-value.info-value-status {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 0.4rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .status-selesai, .status-lulus, .status-diluluskan {
            background: rgba(34, 197, 94, 0.3);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        .status-rejected, .status-tolak, .status-ditolak {
            background: rgba(239, 68, 68, 0.3);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .status-kiv {
            background: rgba(251, 191, 36, 0.3);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }

        .status-pending {
            background: rgba(148, 163, 184, 0.3);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.4);
        }

        .download-btn {
            background: rgba(34, 197, 94, 0.3);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #22c55e;
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            background: rgba(34, 197, 94, 0.4);
            transform: translateY(-2px);
            color: #4ade80;
        }

        .comment-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .comment-role {
            color: #60a5fa;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .comment-date {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        .comment-content {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            font-size: 1rem;
        }

        .no-comment {
            color: rgba(255, 255, 255, 0.5);
            font-style: italic;
            text-align: center;
            padding: 2rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .action-btn {
            background: rgba(100, 116, 139, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 116, 139, 0.4);
            border-radius: 15px;
            cursor: pointer;
            color: #cbd5e1;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 
                0 4px 15px rgba(100, 116, 139, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .action-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            background: rgba(100, 116, 139, 0.4);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(100, 116, 139, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            color: #e2e8f0;
            border-color: rgba(100, 116, 139, 0.6);
        }

        .btn-primary {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.4);
            color: #60a5fa;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:hover {
            background: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .comment-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="modern-container">
        <!-- Success Notification -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <div class="page-header">
            <h1><i class="fas fa-file-alt"></i>Maklumat Permohonan</h1>
        </div>

        <!-- Applicant Information -->
        <div class="detail-card">
            <h2 class="section-title">
                <i class="fas fa-user-circle"></i>
                Maklumat Pemohon
                @if($permohonan->no_kawalan)
                    <span class="section-badge">
                    <i class="fas fa-barcode"></i> No. Kawalan: {{ $permohonan->no_kawalan }}
                    </span>
                @endif
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-hashtag"></i> ID Permohonan</span>
                    <span class="info-value">{{ $permohonan->id_permohonan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-user"></i> Nama Pemohon</span>
                    <span class="info-value">{{ $permohonan->nama_pemohon }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-id-card"></i> No. Kad Pengenalan</span>
                    <span class="info-value">{{ $permohonan->no_kp }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-briefcase"></i> Jawatan</span>
                    <span class="info-value">{{ $permohonan->jawatan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-building"></i> Jabatan</span>
                    <span class="info-value">{{ $permohonan->jabatan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-calendar"></i> Tarikh Hantar</span>
                    <span class="info-value">{{ $permohonan->tarikh_hantar ? $permohonan->tarikh_hantar->format('d/m/Y') : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Application Details -->
        <div class="detail-card">
            <h2 class="section-title">
                <i class="fas fa-clipboard-list"></i>
                Maklumat Permohonan
                @if($permohonan->jenis_permohonan)
                    <span class="section-badge">
                    <i class="fas fa-file-alt"></i> {{ is_array($permohonan->jenis_permohonan) ? implode(', ', $permohonan->jenis_permohonan) : $permohonan->jenis_permohonan }}
                    </span>
                @endif
            </h2>
            
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-list"></i> Kategori</span>
                    <span class="info-value">{{ $permohonan->formatted_kategori }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-tag"></i> Subkategori</span>
                    <span class="info-value">{{ $permohonan->formatted_subkategori }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-list-check"></i> Status Permohonan</span>
                    <span class="info-value info-value-status">
                        <span class="status-badge status-{{ strtolower($permohonan->status_permohonan ?? 'pending') }}">
                            {{ $permohonan->status_permohonan ?? 'Dalam Proses' }}
                        </span>
                    </span>
                </div>
                @if($permohonan->fail_borang)
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-file-pdf"></i> Borang</span>
                        <div class="info-value">
                            <a href="{{ route('pengarah.permohonan.download', $permohonan->id_permohonan) }}" class="download-btn">
                                <i class="fas fa-download"></i>
                                Muat Turun Borang
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="detail-card">
            <h2 class="section-title">
                <i class="fas fa-comments"></i>
                Ulasan & Status
            </h2>

            <!-- Pengarah Comment -->
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-role"><i class="fas fa-user-tie"></i> Pengarah</span>
                    @if($permohonan->tarikh_ulasan_pengarah)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pengarah->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pengarah)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pengarah) }}">
                                {{ $permohonan->status_pengarah }}
                            </span>
                        @else
                            <span class="status-badge status-pending">Belum Diulas</span>
                        @endif
                    </span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Ulasan</span>
                    <span class="info-value">
                        @if($permohonan->ulasan_pengarah)
                            <div class="comment-content">{{ $permohonan->ulasan_pengarah }}</div>
                        @else
                            <div class="no-comment">Tiada ulasan daripada Pengarah</div>
                        @endif
                    </span>
                </div>
            </div>

             <!-- Pegawai Comment -->
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-role"><i class="fas fa-user-tie"></i> Pegawai</span>
                    @if($permohonan->tarikh_ulasan_pegawai)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pegawai->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pegawai)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pengarah) }}">
                                {{ $permohonan->status_pegawai }}
                            </span>
                        @else
                            <span class="status-badge status-pending">Belum Diulas</span>
                        @endif
                    </span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Ulasan</span>
                    <span class="info-value">
                        @if($permohonan->ulasan_pegawai)
                            <div class="comment-content">{{ $permohonan->ulasan_pegawai }}</div>
                        @else
                            <div class="no-comment">Tiada ulasan daripada pegawai</div>
                        @endif
                    </span>
                </div>
            </div>


            <!-- Additional Comments from Ulasan table -->
            @if($permohonan->ulasans && $permohonan->ulasans->count() > 0)
                @foreach($permohonan->ulasans as $ulasan)
                    <div class="comment-card">
                        <div class="comment-header">
                            <span class="comment-role"><i class="fas fa-user-cog"></i> Ulasan Tambahan</span>
                            <span class="comment-date">{{ $ulasan->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="comment-content">{{ $ulasan->ulasan }}</div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="button-group">
            <a href="{{ route('pegawai.permohonan.lama') }}" class="action-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            @if($permohonan->fail_borang)
                <a href="{{ route('pengarah.permohonan.download', $permohonan->id_permohonan) }}" class="action-btn btn-primary">
                    <i class="fas fa-download"></i>
                    Muat Turun Borang
                </a>
            @endif
        </div>
    </div>
</body>
</html>