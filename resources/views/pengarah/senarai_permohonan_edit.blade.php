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

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
                max-height: 0;
            }
            to {
                opacity: 1;
                transform: translateY(0);
                max-height: 500px;
            }
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

            .section-title {
                font-size: 1.2rem;
            }

            .section-title span.section-badge {
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
                        <span class="info-value">{{ $permohonan->formatted_kategori }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-tag"></i> Subkategori</span>
                        <span class="info-value">{{ $permohonan->formatted_subkategori }}</span>
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

            <!-- Decision Form -->
            <form method="POST" action="{{ route('pengarah.permohonan.update', $permohonan->id_permohonan) }}">
                @csrf
                @method('PUT')

                <div class="info-section">
                    <h4 class="section-title">
                        <i class="fas fa-gavel"></i>
                        Keputusan Pengarah
                    </h4>

                    <div class="workflow-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Nota:</strong> Hanya permohonan yang diluluskan akan dihantar ke Pegawai untuk semakan. Permohonan KIV atau Tolak akan kekal dengan Pengarah.
                    </div>

                    <!-- Step 1: Status Selection -->
                    <div class="decision-step">
                        <div class="step-header">
                            <span class="step-number">1</span>
                            <span class="step-title">Pilih Status Keputusan</span>
                        </div>
                        <div class="step-content">
                            <select name="status_pengarah" id="statusPengarah" class="form-control @error('status_pengarah') is-invalid @enderror" required onchange="toggleStatusInfo()">
                                <option value="">-- Pilih Keputusan --</option>
                                <option value="Lulus" {{ old('status_pengarah', $permohonan->status_pengarah) == 'Lulus' ? 'selected' : '' }}>
                                    ✅ Lulus - Hantar ke Pegawai
                                </option>
                                <option value="KIV" {{ old('status_pengarah', $permohonan->status_pengarah) == 'KIV' ? 'selected' : '' }}>
                                    ⏳ KIV - Simpan untuk Semakan Lanjut
                                </option>
                                <option value="Tolak" {{ old('status_pengarah', $permohonan->status_pengarah) == 'Tolak' ? 'selected' : '' }}>
                                    ❌ Tolak - Permohonan Ditolak
                                </option>
                            </select>
                            @error('status_pengarah')
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
                            <span class="step-title">Ulasan Pengarah (Pilihan)</span>
                        </div>
                        <div class="step-content">
                            <textarea name="ulasan_pengarah" id="ulasanPengarah" class="form-control @error('ulasan_pengarah') is-invalid @enderror" 
                                      rows="4" placeholder="Masukkan ulasan dan sebab keputusan anda...">{{ old('ulasan_pengarah', $permohonan->ulasan_pengarah) }}</textarea>
                            @error('ulasan_pengarah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="char-counter">
                                <i class="fas fa-keyboard"></i>
                                <span id="charCount">0</span> / 1000 aksara
                            </div>
                        </div>
                    </div>
                </div>

                <div class="submit-area">
                     <a href="{{ route('pengarah.senarai-permohonan') }}" class="btn-secondary">
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
        function toggleStatusInfo() {
            const statusSelect = document.getElementById('statusPengarah');
            const statusInfo = document.getElementById('statusInfo');
            const statusText = document.getElementById('statusText');

            if (statusSelect.value) {
                statusInfo.style.display = 'block';
                
                switch(statusSelect.value) {
                    case 'Lulus':
                        statusText.innerHTML = '✅ Permohonan akan dihantar ke <strong>Pegawai</strong> untuk semakan.';
                        break;
                    case 'KIV':
                        statusText.innerHTML = '⏳ Permohonan <strong>disimpan</strong> untuk semakan lanjut. Permohonan tidak akan dihantar ke Pegawai dan akan kekal dengan Pengarah untuk tindakan selanjutnya.';
                        break;
                    case 'Tolak':
                        statusText.innerHTML = '❌ Permohonan ditolak oleh <strong>Pengarah</strong>. Permohonan tidak akan diproses lebih lanjut dan tidak akan dihantar ke Pegawai.';
                        break;
                }
            } else {
                statusInfo.style.display = 'none';
            }
        }

        function updateCharCount() {
            const textarea = document.getElementById('ulasanPengarah');
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
            
            const textarea = document.getElementById('ulasanPengarah');
            if (textarea) {
                textarea.addEventListener('input', updateCharCount);
                updateCharCount();
            }
        });
    </script>
</body>
</html>