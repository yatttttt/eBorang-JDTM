<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maklumat Permohonan</title>
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
            background: linear-gradient(135deg, #003366 0%, #000000ff 100%) !important;
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif !important;
            overflow-x: hidden;
            margin: 0 !important;
            padding: 0 !important;
        }

        .modern-container {
            padding: 2rem;
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
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .page-header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.3);
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
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.2);
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

         .info-value:hover {
            background: rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease;
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
            padding: 0.5rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
        }

        .status-selesai, .status-lulus, .status-diluluskan {
            background: rgba(34, 197, 94, 0.3);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        .status-ditolak, .status-tolak {
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

        .password-toggle .toggle-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1.1rem;
            z-index: 10;
            padding: 0.5rem;
        }

        .password-toggle:hover .toggle-icon {
            color: #60a5fa !important;
            transform: translateY(-50%) scale(1.15);
        }

        .info-value.password-toggle {
            position: relative;
            padding-right: 3rem !important;
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

        .mb-3 {
            margin-bottom: 1rem;
        }

        /* CATEGORY TABS STYLING */
        .category-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 0;
            flex-wrap: wrap;
        }

        .category-tab {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: none;
            border-radius: 12px 12px 0 0;
            padding: 0.75rem 1.5rem;
            color: rgba(255, 255, 255, 0.6);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
        }

        .category-tab:hover {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.8);
        }

        .category-tab.active {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.5);
            color: #60a5fa;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        .category-tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, #0099FF, transparent);
        }

        .category-content {
            display: none;
        }

        .category-content.active {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .akses-count-badge {
            background: rgba(34, 197, 94, 0.3);
            color: #22c55e;
            padding: 0.2rem 0.6rem;
            border-radius: 12px;
            font-size: 0.75rem;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        /* Pentadbir Sistem Ditugaskan */
        .pentadbir-assigned-full {
            grid-column: 1 / -1;
        }

        .pentadbir-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .pentadbir-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.25rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .pentadbir-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #60a5fa, #3b82f6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pentadbir-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            border-color: rgba(96, 165, 250, 0.3);
        }

        .pentadbir-card:hover::before {
            opacity: 1;
        }

        .pentadbir-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .pentadbir-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.2), rgba(59, 130, 246, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 1.2rem;
        }

        .pentadbir-card-name {
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
        }

        .pentadbir-card-body {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
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
            .category-tabs {
                flex-direction: column;
                gap: 0.5rem;
            }
            .category-tab {
                border-radius: 12px;
            }
            .pentadbir-cards-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="modern-container">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        
        <div class="page-header">
            <h1><i class="fas fa-file-alt"></i> Maklumat Permohonan</h1>
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
                    <span class="info-value">
                        <span class="status-badge status-{{ strtolower($permohonan->status_permohonan ?? 'pending') }}">
                            {{ $permohonan->status_permohonan ?? 'Dalam Proses' }}
                        </span>
                    </span>
                </div>
                @if($permohonan->fail_borang)
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-file-pdf"></i> Borang</span>
                        <div class="info-value">
                            <a href="{{ route('permohonans.download', $permohonan->id_permohonan) }}" class="download-btn">
                                <i class="fas fa-download"></i> Muat Turun Borang
                            </a>
                        </div>
                    </div>
                @endif

                @if(isset($assignedPentadbir) && $assignedPentadbir->count() > 0)
                    <div class="info-item pentadbir-assigned-full">
                        <span class="info-label"><i class="fas fa-user-shield"></i> Pentadbir Sistem Ditugaskan</span>
                        
                        <div class="pentadbir-cards-grid">
                            @foreach($assignedPentadbir as $pentadbir)
                                <div class="pentadbir-card">
                                    <div class="pentadbir-card-header">
                                        <div class="pentadbir-card-icon">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div class="pentadbir-card-name">{{ $pentadbir->nama }}</div>
                                    </div>
                                    <div class="pentadbir-card-body">
                                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                            <i class="fas fa-envelope" style="color: rgba(255,255,255,0.6); width: 16px;"></i>
                                            <span style="font-size: 0.85rem;">{{ $pentadbir->email ?? 'Tiada email' }}</span>
                                        </div>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <i class="fas fa-briefcase" style="color: rgba(255,255,255,0.6); width: 16px;"></i>
                                            <span style="font-size: 0.85rem;">{{ $pentadbir->jawatan ?? 'Pentadbir Sistem' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
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
                    <span class="comment-role"><i class="fas fa-user"></i> Pegawai</span>
                    @if($permohonan->tarikh_ulasan_pegawai)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pegawai->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pegawai)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pegawai) }}">
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
                            <div class="no-comment">Tiada ulasan daripada Pegawai</div>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Pentadbir Sistem Comment -->
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-role"><i class="fas fa-user-cog"></i> Pentadbir Sistem</span>
                    @if($permohonan->tarikh_ulasan_pentadbir_sistem)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pentadbir_sistem->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pentadbir_sistem)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pentadbir_sistem) }}">
                                {{ $permohonan->status_pentadbir_sistem }}
                            </span>
                        @else
                            <span class="status-badge status-pending">Belum Diulas</span>
                        @endif
                    </span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Ulasan</span>
                    <span class="info-value">
                        @if($permohonan->ulasan_pentadbir_sistem)
                            <div class="comment-content">{{ $permohonan->ulasan_pentadbir_sistem }}</div>
                        @else
                            <div class="no-comment">Tiada ulasan daripada Pentadbir Sistem</div>
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- MULTI-CATEGORY MAKLUMAT AKSES SECTION -->
        @if($permohonan->status_pentadbir_sistem === 'Lulus' && $permohonan->hasMaklumatAkses())
            <div class="detail-card">
                @php
                    $allMaklumatAkses = $permohonan->maklumat_akses ?? [];
                    
                    // Count total accounts across all categories
                    $totalAccounts = 0;
                    if (is_array($allMaklumatAkses)) {
                        foreach ($allMaklumatAkses as $kategori => $aksesArray) {
                            if (is_array($aksesArray)) {
                                $totalAccounts += count($aksesArray);
                            }
                        }
                    }
                @endphp

                <h2 class="section-title">
                    <i class="fas fa-key"></i>
                    Maklumat Akses 
                    <span>{{ $totalAccounts }} Akaun Keseluruhan</span>
                </h2>

                @if(is_array($allMaklumatAkses) && count($allMaklumatAkses) > 0)
                    
                    <!-- Category Tabs -->
                    <div class="category-tabs">
                        @foreach($allMaklumatAkses as $kategori => $aksesArray)
                            @php
                                $categoryKey = strtolower(str_replace(['/', ' '], ['_', '_'], $kategori));
                                $accountCount = is_array($aksesArray) ? count($aksesArray) : 0;
                                $iconClass = match($kategori) {
                                    'Server/Pangkalan Data' => 'fa-server',
                                    'Sistem Aplikasi/Modul' => 'fa-desktop',
                                    'Emel Rasmi MBSA' => 'fa-envelope',
                                    default => 'fa-key'
                                };
                            @endphp
                            <button type="button" 
                                    class="category-tab {{ $loop->first ? 'active' : '' }}" 
                                    onclick="switchCategory('{{ $categoryKey }}')"
                                    data-category="{{ $categoryKey }}">
                                <i class="fas {{ $iconClass }}"></i>
                                {{ $kategori }}
                                <span class="akses-count-badge">{{ $accountCount }}</span>
                            </button>
                        @endforeach
                    </div>

                    <!-- Category Contents -->
                    @foreach($allMaklumatAkses as $kategori => $aksesArray)
                        @php
                            $categoryKey = strtolower(str_replace(['/', ' '], ['_', '_'], $kategori));
                        @endphp
                        
                        <div id="content-{{ $categoryKey }}" 
                             class="category-content {{ $loop->first ? 'active' : '' }}"
                             data-category="{{ $categoryKey }}">
                            
                            @if(is_array($aksesArray) && count($aksesArray) > 0)
                                @foreach($aksesArray as $index => $akses)
                                    
                                    @if($kategori === 'Sistem Aplikasi/Modul' || $kategori === 'Server/Pangkalan Data')
                                        <!-- Sistem/Server Account Card -->
                                        <div class="comment-card">
                                            <div class="comment-header">
                                                <span class="comment-role">
                                                    <i class="fas fa-server"></i> 
                                                    Akaun {{ $index + 1 }}
                                                </span>
                                                <span class="comment-date">
                                                    {{ $permohonan->tarikh_maklumat_akses ? $permohonan->tarikh_maklumat_akses->format('d/m/Y') : 'N/A' }}
                                                </span>
                                            </div>
                                            
                                            <div class="info-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;"> 
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-user"></i> ID Pengguna</span>
                                                    <span class="info-value">
                                                        {{ $akses['id_pengguna'] ?? '-' }}
                                                    </span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-lock"></i> Kata Laluan</span>
                                                    <span class="info-value password-toggle">
                                                        @if(isset($akses['kata_laluan']) && !empty($akses['kata_laluan']))
                                                            <span class="password-mask" data-password="{{ $akses['kata_laluan'] }}">••••••••</span>
                                                            <i class="fas fa-eye-slash toggle-icon"></i>
                                                        @else
                                                            <span style="color: rgba(255,255,255,0.5); font-style: italic;">Tiada</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="info-item">
                                                <span class="info-label"><i class="fas fa-users-cog"></i> Kumpulan Capaian</span>
                                                <span class="info-value">
                                                    {{ $akses['kumpulan_capaian'] ?? '-' }}
                                                </span>
                                            </div>
                                        </div>

                                    @elseif($kategori === 'Emel Rasmi MBSA')
                                        <!-- Email Account Card -->
                                        <div class="comment-card">
                                            <div class="comment-header">
                                                <span class="comment-role">
                                                    <i class="fas fa-envelope"></i> 
                                                    Akaun Emel {{ $index + 1 }}
                                                </span>
                                                <span class="comment-date">
                                                    {{ $permohonan->tarikh_maklumat_akses ? $permohonan->tarikh_maklumat_akses->format('d/m/Y') : 'N/A' }}
                                                </span>
                                            </div>
                                            
                                            <div class="info-grid" style="grid-template-columns: 1fr 1fr; gap: 1rem;">
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-envelope"></i> ID Emel</span>
                                                    <span class="info-value">
                                                        {{ $akses['id_emel'] ?? '-' }}
                                                    </span>
                                                </div>
                                                
                                                <div class="info-item">
                                                    <span class="info-label"><i class="fas fa-lock"></i> Kata Laluan</span>
                                                    <span class="info-value password-toggle">
                                                        @if(isset($akses['kata_laluan']) && !empty($akses['kata_laluan']))
                                                            <span class="password-mask" data-password="{{ $akses['kata_laluan'] }}">••••••••</span>
                                                            <i class="fas fa-eye-slash toggle-icon"></i>
                                                        @else
                                                            <span style="color: rgba(255,255,255,0.5); font-style: italic;">Tiada</span>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                @endforeach
                            @else
                                <div class="no-comment">
                                    <i class="fas fa-info-circle"></i> 
                                    Tiada maklumat akses untuk kategori ini
                                </div>
                            @endif
                        </div>
                    @endforeach

                @else
                    <div class="no-comment">
                        <i class="fas fa-info-circle"></i> 
                        Tiada maklumat akses tersedia
                    </div>
                @endif
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="button-group">
            <a href="{{ route('admin.senarai_permohonan_lama') }}" class="action-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            @if($permohonan->fail_borang)
                <a href="{{ route('admin.permohonan.pdf', $permohonan->id_permohonan) }}" class="action-btn btn-primary">
                    <i class="fas fa-download"></i>
                    Muat Turun Laporan PDF
                </a>
            @endif
            
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const toggleElements = document.querySelectorAll('.password-toggle');

            toggleElements.forEach(toggleElement => {
                const passwordMask = toggleElement.querySelector('.password-mask');
                const toggleIcon = toggleElement.querySelector('.toggle-icon');

                if (passwordMask && toggleIcon) {
                    toggleIcon.addEventListener('click', function() {
                        const actualPassword = passwordMask.getAttribute('data-password');

                        if (passwordMask.textContent.trim() === '••••••••') {
                            passwordMask.textContent = actualPassword;
                            toggleIcon.classList.remove('fa-eye-slash');
                            toggleIcon.classList.add('fa-eye');
                        } else {
                            passwordMask.textContent = '••••••••';
                            toggleIcon.classList.remove('fa-eye');
                            toggleIcon.classList.add('fa-eye-slash');
                        }
                    });
                }
            });
        });

        // Category tab switching
        function switchCategory(categoryKey) {
            // Update tab buttons
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            document.querySelector(`.category-tab[data-category="${categoryKey}"]`).classList.add('active');

            // Update content sections
            document.querySelectorAll('.category-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`content-${categoryKey}`).classList.add('active');
        }
    </script>
</body>
</html>