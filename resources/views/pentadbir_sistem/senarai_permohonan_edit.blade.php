<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semak Permohonan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        overflow-x: hidden;
    }

    .dashboard-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 2rem;
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 3rem;
        margin-bottom: 2rem;
        width: 100%;
        max-width: 1000px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1), inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    .dashboard-title {
        color: #ffffff;
        text-align: center;
        margin-bottom: 3rem;
        margin-top: 0;
        font-weight: 700;
        font-size: 2.5rem;
        letter-spacing: 2px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #ffffff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    .dashboard-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        border-radius: 2px;
    }

    .info-section {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
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

    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        font-size: 1rem;
        color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-control:focus {
        outline: none;
        border-color: rgba(59, 130, 246, 0.6);
        background: rgba(255, 255, 255, 0.1);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        transform: translateY(-2px);
    }

    select.form-control {
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 3rem;
    }

    select.form-control option {
        background: #1e293b;
        color: white;
    }

    textarea.form-control {
        min-height: 120px;
        resize: vertical;
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

    /* DECISION STEP STYLING - SAMA SEPERTI PENGARAH */
    .decision-step {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .decision-step:hover {
        border-color: rgba(59, 130, 246, 0.3);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.1);
    }

    .step-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .step-number {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(37, 99, 235, 0.3));
        border: 2px solid rgba(59, 130, 246, 0.5);
        border-radius: 50%;
        color: #60a5fa;
        font-weight: 700;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .step-title {
        color: #ffffff;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .step-content {
        padding: 1.5rem;
    }

    /* MAKLUMAT AKSES TITLE - SAMA SEPERTI SECTION TITLE */
    .maklumat-akses-title {
        color: #ffffff;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .maklumat-akses-title i {
        color: #60a5fa;
    }

    .maklumat-akses-title .maklumat-akses-badge {
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

    /* TAB STYLING FOR MAKLUMAT AKSES */
    .tab-nav {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 0;
        flex-wrap: wrap;
    }

    .tab-button {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-bottom: none;
        border-radius: 12px 12px 0 0;
        padding: 0.75rem 1.5rem;
        color: rgba(255, 255, 255, 0.6);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tab-button:hover {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
    }

    .tab-button.active {
        background: rgba(59, 130, 246, 0.3);
        border-color: rgba(59, 130, 246, 0.5);
        color: #60a5fa;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-in;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { 
            opacity: 0; 
            transform: translateY(10px); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
        }
    }

    .akses-item {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        animation: fadeIn 0.3s ease-out;
    }

    .akses-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .akses-item-title {
        color: #60a5fa;
        font-weight: 600;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1rem;
        padding: 1rem 2.5rem;
        font-weight: 600;
        background: rgba(0, 98, 255, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.4);
        border-radius: 15px;
        color: #60a5fa;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        cursor: pointer;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .btn-primary:hover::before {
        left: 100%;
    }

    .btn-primary:hover {
        background: rgba(59, 130, 246, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(59, 130, 246, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        text-decoration: none;
        color: #93c5fd;
        border-color: rgba(59, 130, 246, 0.6);
    }

    .btn-secondary {
        background: rgba(100, 116, 139, 0.3);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(100, 116, 139, 0.4);
        border-radius: 15px;
        color: #cbd5e1;
        padding: 1rem 2.5rem;
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
        cursor: pointer;
    }

    .btn-secondary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .btn-secondary:hover::before {
        left: 100%;
    }

    .btn-secondary:hover {
        background: rgba(100, 116, 139, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(100, 116, 139, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        color: #e2e8f0;
        border-color: rgba(100, 116, 139, 0.6);
    }

    .btn-add {
        background: rgba(34, 197, 94, 0.3);
        border: 1px solid rgba(34, 197, 94, 0.4);
        color: #22c55e;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
    }

    .btn-add:hover {
        background: rgba(34, 197, 94, 0.4);
        transform: translateY(-2px);
    }

    .btn-remove {
        background: rgba(239, 68, 68, 0.3);
        border: 1px solid rgba(239, 68, 68, 0.4);
        color: #f87171;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-remove:hover {
        background: rgba(239, 68, 68, 0.4);
        transform: translateY(-2px);
    }

    .submit-area {
        margin-top: 3rem;
        padding-top: 2.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: center;
        gap: 1rem;
    }

    .status-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        color: #60a5fa;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .workflow-info {
        background: rgba(251, 191, 36, 0.1);
        border: 1px solid rgba(251, 191, 36, 0.3);
        border-radius: 12px;
        padding: 1rem;
        margin: 1rem 0;
        color: #fbbf24;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .form-text {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }

    .text-danger {
        color: #fca5a5;
    }

    .invalid-feedback {
        color: #fca5a5;
        font-weight: 500;
        display: block;
        margin-top: 0.5rem;
    }

    .download-btn {
        background: rgba(34, 197, 94, 0.3);
        border: 1px solid rgba(34, 197, 94, 0.4);
        color: #22c55e;
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
    }

    .add-button-container {
        display: flex;
        justify-content: center;
        margin: 1.5rem 0;
    }

    .char-counter {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.75rem;
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.85rem;
    }

    .char-counter i {
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            margin-top: 1rem;
            padding: 0 0.5rem;
        }

        .glass-card {
            padding: 2rem;
        }

        .dashboard-title {
            font-size: 2rem;
        }

        .submit-area {
            flex-direction: column;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .akses-item-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .tab-nav {
            flex-direction: column;
            gap: 0.5rem;
        }

        .tab-button {
            border-radius: 12px;
        }

        .section-title {
            font-size: 1.2rem;
        }

        .section-title span.section-badge {
            margin-left: 0;
            margin-top: 0.5rem;
        }

        .maklumat-akses-title {
            font-size: 1.2rem;
        }

        .maklumat-akses-title .maklumat-akses-badge {
            margin-left: 0;
            margin-top: 0.5rem;
        }
    }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="glass-card">
            <h1 class="dashboard-title"><i class="fas fa-clipboard-check"></i> Semak Permohonan</h1>

            <!-- Applicant Information -->
            <div class="info-section">
                <h4 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Maklumat Pemohon
                    @if($permohonan->no_kawalan)
                        <span class="section-badge">
                            <i class="fas fa-barcode"></i> No. Kawalan: {{ $permohonan->no_kawalan }}
                        </span>
                    @endif
                </h4>
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
            <div class="info-section">
                <h4 class="section-title">
                    <i class="fas fa-clipboard-list"></i>
                    Maklumat Permohonan
                    @if($permohonan->jenis_permohonan)
                        <span class="section-badge">
                        <i class="fas fa-file-alt"></i> {{ is_array($permohonan->jenis_permohonan) ? implode(', ', $permohonan->jenis_permohonan) : $permohonan->jenis_permohonan }}
                        </span>
                    @endif
                </h4>
                
                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-list"></i> Kategori</span>
                        <div class="info-value">
                            @foreach($allKategori as $kategori)
                                {{ $kategori }}
                                @if(!$loop->last) <br><br> @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-tag"></i> Subkategori</span>
                        <span class="info-value">{{ $permohonan->formatted_subkategori }}</span>
                    </div>
                    @if($permohonan->fail_borang)
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-file-pdf"></i> Borang</span>
                        <div class="info-value">
                            <a href="{{ route('pentadbir_sistem.permohonan.download', $permohonan->id_permohonan) }}" class="download-btn">
                                <i class="fas fa-download"></i>
                                Muat Turun Borang
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Decision Form -->
            <form method="POST" action="{{ route('pentadbir_sistem.permohonan.update', $permohonan->id_permohonan) }}" id="mainForm">
                @csrf
                @method('PUT')

                <div class="info-section">
                    <h4 class="section-title">
                        <i class="fas fa-gavel"></i>
                        Keputusan Pentadbir Sistem
                    </h4>

                    <div class="workflow-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Nota:</strong> Hanya permohonan yang diluluskan akan dihantar ke Admin untuk keputusan akhir. Permohonan KIV atau Tolak akan kekal dengan Pentadbir Sistem.
                        Setiap Pentadbir Sistem hanya perlu mengisi maklumat akses bagi kategori sistem yang dijaga oleh mereka.
                    </div>

                    <!-- Step 1: Status Selection -->
                    <div class="decision-step">
                        <div class="step-header">
                            <span class="step-number">1</span>
                            <span class="step-title">Pilih Status Keputusan</span>
                        </div>
                        <div class="step-content">
                            <select name="status_pentadbir_sistem" id="statusPentadbirSistem" class="form-control @error('status_pentadbir_sistem') is-invalid @enderror" required onchange="toggleStatusInfo()">
                                <option value="">-- Pilih Keputusan --</option>
                                <option value="Lulus" {{ old('status_pentadbir_sistem', $permohonan->status_pentadbir_sistem) == 'Lulus' ? 'selected' : '' }}>
                                    ✅ Lulus - Hantar ke Admin
                                </option>
                                <option value="KIV" {{ old('status_pentadbir_sistem', $permohonan->status_pentadbir_sistem) == 'KIV' ? 'selected' : '' }}>
                                    ⏳ KIV - Simpan untuk Semakan Lanjut
                                </option>
                                <option value="Tolak" {{ old('status_pentadbir_sistem', $permohonan->status_pentadbir_sistem) == 'Tolak' ? 'selected' : '' }}>
                                    ❌ Tolak - Permohonan Ditolak
                                </option>
                            </select>
                            @error('status_pentadbir_sistem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            <div class="status-info" id="statusInfo" style="display: none;">
                                <i class="fas fa-lightbulb"></i>
                                <span id="statusText"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Comments -->
                    <div class="decision-step">
                        <div class="step-header">
                            <span class="step-number">2</span>
                            <span class="step-title">Ulasan Pentadbir Sistem (Pilihan)</span>
                        </div>
                        <div class="step-content">
                            <textarea name="ulasan_pentadbir_sistem" id="ulasanPentadbirSistem" class="form-control @error('ulasan_pentadbir_sistem') is-invalid @enderror" 
                                      rows="4" placeholder="Masukkan ulasan dan sebab keputusan anda...">{{ old('ulasan_pentadbir_sistem', $permohonan->ulasan_pentadbir_sistem) }}</textarea>
                            @error('ulasan_pentadbir_sistem')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="char-counter">
                                <i class="fas fa-keyboard"></i>
                                <span id="charCount">0</span> / 1000 aksara
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Maklumat Akses (Only shows when Lulus) -->
                    <div id="maklumatAksesStep" class="decision-step" style="display: none;">
                        <div class="step-header">
                            <span class="step-number">3</span>
                            <span class="step-title">Tindakan Pentadbir Sistem</span>
                        </div>
                        <div class="step-content">
                            <div class="workflow-info" style="margin-top: 0;">
                                <i class="fas fa-exclamation-triangle"></i>
                                <strong>Penting:</strong> Anda <strong>wajib</strong> mengisi sekurang-kurangnya satu maklumat akses dalam mana-mana kategori sebelum boleh menghantar; jika tidak, permohonan tidak akan dapat diproses. Anda boleh memilih kategori yang berkaitan dengan sistem di bawah jagaan anda. Status permohonan akan kekal <strong>"Dalam Proses"</strong> sehingga semua kategori yang dimohon mempunyai maklumat akses lengkap.
                            </div>

                            <!-- Tab Navigation -->
                            <div class="tab-nav">
                                @foreach($allKategori as $index => $kategori)
                                    @php
                                        $categoryKey = strtolower(str_replace(['/', ' '], ['_', '_'], $kategori));
                                        $iconClass = match($kategori) {
                                            'Server/Pangkalan Data' => 'fa-server',
                                            'Sistem Aplikasi/Modul' => 'fa-desktop',
                                            'Emel Rasmi MBSA' => 'fa-envelope',
                                            default => 'fa-key'
                                        };
                                    @endphp
                                    <button type="button" class="tab-button {{ $index === 0 ? 'active' : '' }}" 
                                            onclick="switchTab('{{ $categoryKey }}')" 
                                            data-category="{{ $categoryKey }}">
                                        <i class="fas {{ $iconClass }}"></i>
                                        {{ $kategori }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Tab Contents -->
                            @foreach($allKategori as $index => $kategori)
                                @php
                                    $categoryKey = strtolower(str_replace(['/', ' '], ['_', '_'], $kategori));
                                @endphp
                                <div id="tab-{{ $categoryKey }}" class="tab-content {{ $index === 0 ? 'active' : '' }}" data-category="{{ $categoryKey }}">
                                   <h5 class="maklumat-akses-title">
                                        <i class="fas fa-list-check"></i>
                                        Maklumat Akses: {{ $kategori }}
                                        @if($permohonan->jenis_permohonan)
                                            <span class="maklumat-akses-badge">
                                                <i class="fas fa-file-alt"></i> {{ is_array($permohonan->jenis_permohonan) ? implode(', ', $permohonan->jenis_permohonan) : $permohonan->jenis_permohonan }}
                                            </span>
                                        @endif
                                    </h5>

                                    <div class="akses-container" id="container-{{ $categoryKey }}">
                                        <!-- Items will be dynamically added here -->
                                    </div>

                                    <div class="add-button-container">
                                        <button type="button" class="btn-add" onclick="addAksesItem('{{ $categoryKey }}', '{{ $kategori }}')">
                                            <i class="fas fa-plus-circle"></i>
                                            Tambah Maklumat Akses
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="submit-area">
                    <a href="{{ route('pentadbir_sistem.senarai-permohonan') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Kembali
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i>
                        Hantar Keputusan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Category counters
        const categoryCounters = {};
        const allKategori = @json($allKategori);
        const existingData = @json($existingMaklumatAkses);

        // Initialize counters
        allKategori.forEach(kategori => {
            const key = getCategoryKey(kategori);
            categoryCounters[key] = 0;
        });

        function getCategoryKey(kategori) {
            return kategori.toLowerCase().replace(/[\/\s]/g, '_');
        }

        function toggleStatusInfo() {
            const statusSelect = document.getElementById('statusPentadbirSistem');
            const statusInfo = document.getElementById('statusInfo');
            const statusText = document.getElementById('statusText');
            const maklumatAksesStep = document.getElementById('maklumatAksesStep');

            if (statusSelect.value) {
                statusInfo.style.display = 'block';
                
                if (statusSelect.value === 'Lulus') {
                    statusText.innerHTML = '✅ Permohonan akan dihantar ke <strong>Admin</strong> untuk keputusan akhir.';
                    maklumatAksesStep.style.display = 'block';
                    
                    // Pentadbir boleh tambah maklumat akses secara manual mengikut kategori yang dijaga
                } else if (statusSelect.value === 'KIV') {
                    statusText.innerHTML = '⏳ Permohonan <strong>disimpan</strong> untuk semakan lanjut. Permohonan tidak akan dihantar ke Admin dan akan kekal dengan Pentadbir Sistem untuk tindakan selanjutnya.';
                    maklumatAksesStep.style.display = 'none';
                } else if (statusSelect.value === 'Tolak') {
                    statusText.innerHTML = '❌ Permohonan ditolak oleh <strong>Pentadbir Sistem</strong>. Permohonan tidak akan diproses lebih lanjut dan tidak akan dihantar ke Admin.';
                    maklumatAksesStep.style.display = 'none';
                }
            } else {
                statusInfo.style.display = 'none';
                maklumatAksesStep.style.display = 'none';
            }
        }

        function switchTab(categoryKey) {
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.querySelector(`.tab-button[data-category="${categoryKey}"]`).classList.add('active');

            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            document.getElementById(`tab-${categoryKey}`).classList.add('active');
        }

        function addAksesItem(categoryKey, kategori) {
            const container = document.getElementById(`container-${categoryKey}`);
            const counter = categoryCounters[categoryKey];
            const itemNumber = counter + 1;
            
            let fieldsHTML = '';
            
            if (kategori === 'Server/Pangkalan Data' || kategori === 'Sistem Aplikasi/Modul') {
                fieldsHTML = `
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-user"></i>
                                ID Pengguna <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="maklumat_akses[${categoryKey}][${counter}][id_pengguna]" 
                                   class="form-control" 
                                   placeholder="Masukkan ID Pengguna"
                                   required>
                        </div>

                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-lock"></i>
                                Kata Laluan <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   name="maklumat_akses[${categoryKey}][${counter}][kata_laluan]" 
                                   class="form-control" 
                                   placeholder="Masukkan Kata Laluan"
                                   minlength="8"
                                   required>
                            <small class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Minimum 8 aksara
                            </small>
                        </div>

                        <div class="info-item" style="grid-column: 1 / -1;">
                            <label class="info-label">
                                <i class="fas fa-users-cog"></i>
                                Kumpulan Capaian <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   name="maklumat_akses[${categoryKey}][${counter}][kumpulan_capaian]" 
                                   class="form-control" 
                                   placeholder="Masukkan Kumpulan Capaian"
                                   required>
                        </div>
                    </div>
                `;
            } else if (kategori === 'Emel Rasmi MBSA') {
                fieldsHTML = `
                    <div class="info-grid">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-envelope"></i>
                                ID Emel <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   name="maklumat_akses[${categoryKey}][${counter}][id_emel]" 
                                   class="form-control" 
                                   placeholder="contoh@mbsa.gov.my"
                                   required>
                        </div>

                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-lock"></i>
                                Kata Laluan <span class="text-danger">*</span>
                            </label>
                            <input type="password" 
                                   name="maklumat_akses[${categoryKey}][${counter}][kata_laluan]" 
                                   class="form-control" 
                                   placeholder="Masukkan Kata Laluan"
                                   minlength="8"
                                   required>
                            <small class="form-text">
                                <i class="fas fa-info-circle"></i>
                                Minimum 8 aksara
                            </small>
                        </div>
                    </div>
                `;
            }

            const itemHTML = `
                <div class="akses-item" data-category="${categoryKey}" data-index="${counter}">
                    <div class="akses-item-header">
                        <div class="akses-item-title">
                            <i class="fas fa-key"></i>
                            Akaun ${itemNumber}
                        </div>
                        <button type="button" class="btn-remove" onclick="removeAksesItem('${categoryKey}', ${counter})">
                            <i class="fas fa-trash-alt"></i>
                            Buang
                        </button>
                    </div>
                    ${fieldsHTML}
                </div>
            `;

            container.insertAdjacentHTML('beforeend', itemHTML);
            categoryCounters[categoryKey]++;
        }

        function removeAksesItem(categoryKey, index) {
            const item = document.querySelector(`.akses-item[data-category="${categoryKey}"][data-index="${index}"]`);
            if (item) {
                const container = document.getElementById(`container-${categoryKey}`);
                item.style.animation = 'fadeOut 0.3s ease-out';
                setTimeout(() => {
                    item.remove();
                    updateItemNumbers(categoryKey);
                }, 300);
            }
        }

        function updateItemNumbers(categoryKey) {
            const container = document.getElementById(`container-${categoryKey}`);
            const items = container.querySelectorAll('.akses-item');
            items.forEach((item, index) => {
                const title = item.querySelector('.akses-item-title');
                title.innerHTML = `<i class="fas fa-key"></i> Akaun ${index + 1}`;
            });
        }

        // Global current user ID
        const currentUserId = {{ auth()->id() }};

        function loadExistingData() {
            if (!existingData || typeof existingData !== 'object') return;

            Object.keys(existingData).forEach(kategori => {
                const categoryKey = getCategoryKey(kategori);
                const dataArray = existingData[kategori];
                
                if (Array.isArray(dataArray) && dataArray.length > 0) {
                    const container = document.getElementById(`container-${categoryKey}`);
                    if (!container) return;
                    
                    container.innerHTML = '';
                    categoryCounters[categoryKey] = 0;
                    
                    dataArray.forEach(itemData => {
                        // Check ownership
                        const isOtherAdmin = (itemData.entered_by && itemData.entered_by != currentUserId);
                        
                        if (isOtherAdmin) {
                            // Render READ ONLY block
                            renderReadOnlyItem(container, categoryKey, kategori, itemData);
                        } else {
                            // Render EDITABLE block (Own or Legacy)
                            const counter = categoryCounters[categoryKey];
                            const itemNumber = counter + 1;
                            
                            let fieldsHTML = '';
                            
                            if (kategori === 'Server/Pangkalan Data' || kategori === 'Sistem Aplikasi/Modul') {
                                fieldsHTML = `
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <label class="info-label">
                                                <i class="fas fa-user"></i>
                                                ID Pengguna <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="maklumat_akses[${categoryKey}][${counter}][id_pengguna]" 
                                                   class="form-control" 
                                                   value="${itemData.id_pengguna || ''}"
                                                   placeholder="Masukkan ID Pengguna"
                                                   required>
                                        </div>

                                        <div class="info-item">
                                            <label class="info-label">
                                                <i class="fas fa-lock"></i>
                                                Kata Laluan <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group" style="position: relative;">
                                                <input type="password" 
                                                       name="maklumat_akses[${categoryKey}][${counter}][kata_laluan]" 
                                                       class="form-control" 
                                                       value="${itemData.kata_laluan || ''}"
                                                       placeholder="Masukkan Kata Laluan"
                                                       minlength="8"
                                                       required>
                                                <!-- Optional: Add toggle visibility button here if needed -->
                                            </div>
                                            <small class="form-text">
                                                <i class="fas fa-info-circle"></i>
                                                Minimum 8 aksara
                                            </small>
                                        </div>

                                        <div class="info-item" style="grid-column: 1 / -1;">
                                            <label class="info-label">
                                                <i class="fas fa-users-cog"></i>
                                                Kumpulan Capaian <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   name="maklumat_akses[${categoryKey}][${counter}][kumpulan_capaian]" 
                                                   class="form-control" 
                                                   value="${itemData.kumpulan_capaian || ''}"
                                                   placeholder="Masukkan Kumpulan Capaian"
                                                   required>
                                        </div>
                                    </div>
                                `;
                            } else if (kategori === 'Emel Rasmi MBSA') {
                                fieldsHTML = `
                                    <div class="info-grid">
                                        <div class="info-item">
                                            <label class="info-label">
                                                <i class="fas fa-envelope"></i>
                                                ID Emel <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" 
                                                   name="maklumat_akses[${categoryKey}][${counter}][id_emel]" 
                                                   class="form-control" 
                                                   value="${itemData.id_emel || ''}"
                                                   placeholder="contoh@mbsa.gov.my"
                                                   required>
                                        </div>

                                        <div class="info-item">
                                            <label class="info-label">
                                                <i class="fas fa-lock"></i>
                                                Kata Laluan <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" 
                                                   name="maklumat_akses[${categoryKey}][${counter}][kata_laluan]" 
                                                   class="form-control" 
                                                   value="${itemData.kata_laluan || ''}"
                                                   placeholder="Masukkan Kata Laluan"
                                                   minlength="8"
                                                   required>
                                            <small class="form-text">
                                                <i class="fas fa-info-circle"></i>
                                                Minimum 8 aksara
                                            </small>
                                        </div>
                                    </div>
                                `;
                            }

                            const itemHTML = `
                                <div class="akses-item" data-category="${categoryKey}" data-index="${counter}">
                                    <div class="akses-item-header">
                                        <div class="akses-item-title">
                                            <i class="fas fa-key"></i>
                                            Akaun ${itemNumber}
                                            <span class="badge badge-info" style="font-size: 0.7em; background: rgba(59, 130, 246, 0.2); color: #93c5fd; padding: 2px 8px; border-radius: 10px; margin-left: 8px;">Anda</span>
                                        </div>
                                        <button type="button" class="btn-remove" onclick="removeAksesItem('${categoryKey}', ${counter})">
                                            <i class="fas fa-trash-alt"></i>
                                            Buang
                                        </button>
                                    </div>
                                    ${fieldsHTML}
                                </div>
                            `;

                            container.insertAdjacentHTML('beforeend', itemHTML);
                            categoryCounters[categoryKey]++;
                        }
                    });
                }
            });
        }
        
        function renderReadOnlyItem(container, categoryKey, kategori, itemData) {
            let fieldsHTML = '';
            
            if (kategori === 'Server/Pangkalan Data' || kategori === 'Sistem Aplikasi/Modul') {
                fieldsHTML = `
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-user"></i> ID Pengguna</span>
                            <span class="info-value" style="background: rgba(255, 255, 255, 0.03); color: #cbd5e1;">
                                ${itemData.id_pengguna || '-'}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-lock"></i> Kata Laluan</span>
                            <span class="info-value" style="background: rgba(255, 255, 255, 0.03); color: #cbd5e1; font-family: monospace;">
                                ${itemData.kata_laluan || '********'}
                            </span>
                        </div>
                        <div class="info-item" style="grid-column: 1 / -1;">
                            <span class="info-label"><i class="fas fa-users-cog"></i> Kumpulan Capaian</span>
                            <span class="info-value" style="background: rgba(255, 255, 255, 0.03); color: #cbd5e1;">
                                ${itemData.kumpulan_capaian || '-'}
                            </span>
                        </div>
                    </div>
                `;
            } else if (kategori === 'Emel Rasmi MBSA') {
                fieldsHTML = `
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-envelope"></i> ID Emel</span>
                            <span class="info-value" style="background: rgba(255, 255, 255, 0.03); color: #cbd5e1;">
                                ${itemData.id_emel || '-'}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label"><i class="fas fa-lock"></i> Kata Laluan</span>
                            <span class="info-value" style="background: rgba(255, 255, 255, 0.03); color: #cbd5e1; font-family: monospace;">
                                ${itemData.kata_laluan || '********'}
                            </span>
                        </div>
                    </div>
                `;
            }
            
            const itemHTML = `
                <div class="akses-item" style="border-color: rgba(255, 255, 255, 0.05); background: rgba(0, 0, 0, 0.2);">
                    <div class="akses-item-header" style="border-bottom-color: rgba(255, 255, 255, 0.05);">
                        <div class="akses-item-title" style="color: #94a3b8;">
                            <i class="fas fa-user-shield"></i>
                            Diisi oleh Pentadbir Sistem Yang Lain
                        </div>
                        <!-- No delete button for read-only items -->
                    </div>
                    ${fieldsHTML}
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', itemHTML);
        }

        // WAJIB: Sekurang-kurangnya satu maklumat akses bila status Lulus
        function hasAtLeastOneMaklumatAkses() {
            const containers = document.querySelectorAll('[id^="container-"]');
            for (const container of containers) {
                const items = container.querySelectorAll('.akses-item');
                for (const item of items) {
                    const idPengguna = item.querySelector('input[name*="[id_pengguna]"]');
                    const idEmel = item.querySelector('input[name*="[id_emel]"]');
                    const kataLaluan = item.querySelector('input[name*="[kata_laluan]"]');
                    const kumpulanCapaian = item.querySelector('input[name*="[kumpulan_capaian]"]');
                    if (idPengguna && kataLaluan && kumpulanCapaian) {
                        if ((idPengguna.value || '').trim() && (kataLaluan.value || '').trim() && (kumpulanCapaian.value || '').trim()) return true;
                    }
                    if (idEmel && kataLaluan) {
                        if ((idEmel.value || '').trim() && (kataLaluan.value || '').trim()) return true;
                    }
                }
            }
            return false;
        }

        document.getElementById('mainForm').addEventListener('submit', function(e) {
            const status = document.querySelector('select[name="status_pentadbir_sistem"]').value;
            if (status === 'Lulus' && !hasAtLeastOneMaklumatAkses()) {
                e.preventDefault();
                alert('Anda wajib mengisi sekurang-kurangnya satu maklumat akses dalam mana-mana kategori (ID Pengguna/Emel, Kata Laluan, dsb.) sebelum boleh menghantar permohonan dengan status Lulus.');
                return false;
            }
        });

        // Character counter
        function updateCharCount() {
            const textarea = document.getElementById('ulasanPentadbirSistem');
            const charCount = document.getElementById('charCount');
            
            if (textarea && charCount) {
                const count = textarea.value.length;
                charCount.textContent = count;
                
                if (count > 900) {
                    charCount.style.color = '#fca5a5';
                } else if (count > 700) {
                    charCount.style.color = '#fbbf24';
                } else {
                    charCount.style.color = 'rgba(255, 255, 255, 0.7)';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            toggleStatusInfo();
            
            const textarea = document.getElementById('ulasanPentadbirSistem');
            if (textarea) {
                textarea.addEventListener('input', updateCharCount);
                updateCharCount();
            }
            
            const statusSelect = document.querySelector('select[name="status_pentadbir_sistem"]');
            if (statusSelect.value === 'Lulus') {
                if (existingData && Object.keys(existingData).length > 0) {
                    loadExistingData();
                }
            }
        });
    </script>
</body>
</html>