<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Permohonan</title>
    
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
            max-width: 1000px;
            margin: 0 auto;
        }

        .page-header {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
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

        .form-card {
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .form-label.required::after {
            content: ' *';
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 0.875rem 1rem;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: #ffffff;
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(96, 165, 250, 0.5);
            box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:disabled,
        .form-control[readonly] {
            background: rgba(100, 116, 139, 0.2);
            border-color: rgba(255, 255, 255, 0.15);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .readonly-info {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: rgba(96, 165, 250, 0.15);
            border: 1px solid rgba(96, 165, 250, 0.3);
            border-radius: 10px;
            color: #60a5fa;
            font-size: 0.85rem;
            margin-top: 0.5rem;
        }

        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2.5rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23ffffff' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            cursor: pointer;
        }

        select.form-control:disabled {
            background-image: none;
            cursor: not-allowed;
        }

        select.form-control option {
            background: #1e293b;
            color: #ffffff;
            padding: 0.5rem;
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .file-upload-wrapper {
            position: relative;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            padding: 1rem;
            background: rgba(59, 130, 246, 0.2);
            border: 2px dashed rgba(96, 165, 250, 0.4);
            border-radius: 12px;
            color: #60a5fa;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-upload-label:hover {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(96, 165, 250, 0.6);
            transform: translateY(-2px);
        }

        .file-upload-input {
            position: absolute;
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            z-index: -1;
        }

        .current-file {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            border-radius: 10px;
            color: #22c55e;
            margin-top: 0.75rem;
            font-size: 0.9rem;
        }

        .file-name {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.2);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .alert-warning {
            background: rgba(251, 191, 36, 0.2);
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: #fbbf24;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 15px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            text-align: center;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: rgba(59, 130, 246, 0.3);
            color: #60a5fa;
            border: 1px solid rgba(59, 130, 246, 0.4);
            box-shadow: 
                0 4px 15px rgba(59, 130, 246, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover {
            background: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(59, 130, 246, 0.6);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 4px 15px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        .error-list {
            margin: 0.5rem 0 0 1.5rem;
        }

        .cursor-not-allowed {
            cursor: not-allowed;
        }

        .text-success {
            color: #22c55e;
        }

        .file-help-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin-bottom: 0.75rem;
            margin-top: 0.75rem;
        }
    </style>
</head>
<body>
    <div class="modern-container">
        <div class="page-header">
            <h1><i class="fas fa-edit"></i>Edit Permohonan</h1>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i>
                <div>
                    <strong>Terdapat ralat pada borang:</strong>
                    <ul class="error-list">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('permohonans.update', $permohonan->id_permohonan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Applicant Information -->
            <div class="form-card">
                <h2 class="section-title">
                    <i class="fas fa-user-circle"></i>
                    Maklumat Pemohon
                </h2>

                <div class="form-group">
                    <label for="nama_pemohon" class="form-label required">Nama Pemohon</label>
                    <input 
                        type="text" 
                        class="form-control @error('nama_pemohon') is-invalid @enderror" 
                        id="nama_pemohon" 
                        name="nama_pemohon" 
                        value="{{ old('nama_pemohon', $permohonan->nama_pemohon) }}"
                        placeholder="Masukkan nama penuh"
                        required
                    >
                    @error('nama_pemohon')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="no_kp" class="form-label required">No. Kad Pengenalan</label>
                    <input 
                        type="text" 
                        class="form-control @error('no_kp') is-invalid @enderror" 
                        id="no_kp" 
                        name="no_kp" 
                        value="{{ old('no_kp', $permohonan->no_kp) }}"
                        placeholder="Contoh: 901234-56-7890"
                        required
                    >
                    @error('no_kp')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jawatan" class="form-label required">Jawatan</label>
                    <input 
                        type="text" 
                        class="form-control @error('jawatan') is-invalid @enderror" 
                        id="jawatan" 
                        name="jawatan" 
                        value="{{ old('jawatan', $permohonan->jawatan) }}"
                        placeholder="Contoh: Pegawai Tadbir"
                        required
                    >
                    @error('jawatan')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="jabatan" class="form-label required">Jabatan</label>
                    <select 
                        class="form-control @error('jabatan') is-invalid @enderror" 
                        id="jabatan" 
                        name="jabatan" 
                        required>
                        <option value="">-- Pilih Jabatan --</option>
                        <option value="JABATAN KHIDMAT PENGURUSAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KHIDMAT PENGURUSAN' ? 'selected' : '' }}>JABATAN KHIDMAT PENGURUSAN</option>
                        <option value="JABATAN DIGITAL & TEKNOLOGI MAKLUMAT" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN DIGITAL & TEKNOLOGI MAKLUMAT' ? 'selected' : '' }}>JABATAN DIGITAL & TEKNOLOGI MAKLUMAT</option>
                        <option value="JABATAN PERUNDANGAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PERUNDANGAN' ? 'selected' : '' }}>JABATAN PERUNDANGAN</option>
                        <option value="JABATAN PENILAIAN DAN PENGURUSAN HARTA" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PENILAIAN DAN PENGURUSAN HARTA' ? 'selected' : '' }}>JABATAN PENILAIAN DAN PENGURUSAN HARTA</option>
                        <option value="JABATAN KEBERSIHAN AWAM DAN KELESTARIAN SISA" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KEBERSIHAN AWAM DAN KELESTARIAN SISA' ? 'selected' : '' }}>JABATAN KEBERSIHAN AWAM DAN KELESTARIAN SISA</option>
                        <option value="JABATAN LANSKAP" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN LANSKAP' ? 'selected' : '' }}>JABATAN LANSKAP</option>
                        <option value="JABATAN KONTRAK DAN UKUR BAHAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KONTRAK DAN UKUR BAHAN' ? 'selected' : '' }}>JABATAN KONTRAK DAN UKUR BAHAN</option>
                        <option value="JABATAN PERANCANGAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PERANCANGAN' ? 'selected' : '' }}>JABATAN PERANCANGAN</option>
                        <option value="JABATAN KEJURUTERAAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KEJURUTERAAN' ? 'selected' : '' }}>JABATAN KEJURUTERAAN</option>
                        <option value="JABATAN KEWANGAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KEWANGAN' ? 'selected' : '' }}>JABATAN KEWANGAN</option>
                        <option value="JABATAN PENGUATKUASAAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PENGUATKUASAAN' ? 'selected' : '' }}>JABATAN PENGUATKUASAAN</option>
                        <option value="JABATAN PELESENAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PELESENAN' ? 'selected' : '' }}>JABATAN PELESENAN</option>
                        <option value="JABATAN PEMBANGUNAN KOMUNITI" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PEMBANGUNAN KOMUNITI' ? 'selected' : '' }}>JABATAN PEMBANGUNAN KOMUNITI</option>
                        <option value="JABATAN KORPORAT DAN PERHUBUNGAN AWAM" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KORPORAT DAN PERHUBUNGAN AWAM' ? 'selected' : '' }}>JABATAN KORPORAT DAN PERHUBUNGAN AWAM</option>
                        <option value="JABATAN KESIHATAN PERSEKITARAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN KESIHATAN PERSEKITARAN' ? 'selected' : '' }}>JABATAN KESIHATAN PERSEKITARAN</option>
                        <option value="BAHAGIAN PESURUHJAYA BANGUNAN" {{ old('jabatan', $permohonan->jabatan) == 'BAHAGIAN PESURUHJAYA BANGUNAN' ? 'selected' : '' }}>BAHAGIAN PESURUHJAYA BANGUNAN</option>
                        <option value="JABATAN PENGANGKUTAN BANDAR" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN PENGANGKUTAN BANDAR' ? 'selected' : '' }}>JABATAN PENGANGKUTAN BANDAR</option>
                        <option value="JABATAN BANGUNAN" {{ old('jabatan', $permohonan->jabatan) == 'JABATAN BANGUNAN' ? 'selected' : '' }}>JABATAN BANGUNAN</option>
                        <option value="BAHAGIAN AUDIT DALAM" {{ old('jabatan', $permohonan->jabatan) == 'BAHAGIAN AUDIT DALAM' ? 'selected' : '' }}>BAHAGIAN AUDIT DALAM</option>
                        <option value="BAHAGIAN INTEGRITI" {{ old('jabatan', $permohonan->jabatan) == 'BAHAGIAN INTEGRITI' ? 'selected' : '' }}>BAHAGIAN INTEGRITI</option>
                        <option value="BAHAGIAN PUSAT SETEMPAT" {{ old('jabatan', $permohonan->jabatan) == 'BAHAGIAN PUSAT SETEMPAT' ? 'selected' : '' }}>BAHAGIAN PUSAT SETEMPAT</option>
                        <option value="PEJABAT CAWANGAN KOTA KEMUNING" {{ old('jabatan', $permohonan->jabatan) == 'PEJABAT CAWANGAN KOTA KEMUNING' ? 'selected' : '' }}>PEJABAT CAWANGAN KOTA KEMUNING</option>
                        <option value="PEJABAT CAWANGAN SG.BULOH" {{ old('jabatan', $permohonan->jabatan) == 'PEJABAT CAWANGAN SG.BULOH' ? 'selected' : '' }}>PEJABAT CAWANGAN SG.BULOH</option>
                        <option value="PEJABAT CAWANGAN SETIA ALAM" {{ old('jabatan', $permohonan->jabatan) == 'PEJABAT CAWANGAN SETIA ALAM' ? 'selected' : '' }}>PEJABAT CAWANGAN SETIA ALAM</option>
                    </select>
                    @error('jabatan')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Application Details -->
            <div class="form-card">
                <h2 class="section-title">
                    <i class="fas fa-clipboard-list"></i>
                    Maklumat Permohonan
                </h2>

                <div class="form-group">
                    <label for="kategori" class="form-label required">Kategori</label>
                    @php
                        // Handle both array and string for display only
                        $kategoriDisplay = '';
                        
                        if (is_array($permohonan->kategori)) {
                            $kategoriDisplay = implode(', ', $permohonan->kategori);
                        } else {
                            // Try to decode if it's JSON string
                            $decoded = json_decode($permohonan->kategori, true);
                            if (is_array($decoded)) {
                                $kategoriDisplay = implode(', ', $decoded);
                            } else {
                                $kategoriDisplay = $permohonan->kategori;
                            }
                        }
                    @endphp
                    
                    <input 
                        type="text" 
                        class="form-control" 
                        id="kategori_display" 
                        value="{{ $kategoriDisplay }}"
                        disabled
                        class="form-control cursor-not-allowed"
                    >
                    <!-- KATEGORI TIDAK DIHANTAR - Field ini tidak boleh diubah -->
                    
                    <div class="readonly-info">
                        <i class="fas fa-lock"></i>
                        <span>Kategori tidak boleh diubah setelah permohonan dibuat</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="subkategori" class="form-label">Subkategori</label>
                    <textarea 
                        class="form-control @error('subkategori') is-invalid @enderror" 
                        id="subkategori" 
                        name="subkategori" 
                        rows="3"
                        placeholder="Masukkan subkategori (opsional)"
                        >{{ old('subkategori', isset($permohonan->subkategori) ? trim($permohonan->formatted_subkategori, '[]"') : '') }}</textarea>
                        @error('subkategori')
                        <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="fail_borang" class="form-label">Fail Borang (PDF)</label>
                    
                    @if($permohonan->fail_borang)
                        <div class="current-file">
                            <i class="fas fa-file-pdf"></i>
                            <span class="file-name">Fail Sedia Ada: {{ basename($permohonan->fail_borang) }}</span>
                            <a href="{{ route('permohonans.download', $permohonan->id_permohonan) }}" class="text-success">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        <div class="file-help-text">
                            <i class="fas fa-info-circle"></i> Kosongkan jika tidak ingin mengubah fail
                        </div>
                    @endif

                    <div class="file-upload-wrapper">
                        <input 
                            type="file" 
                            class="file-upload-input" 
                            id="fail_borang" 
                            name="fail_borang"
                            accept=".pdf"
                        >
                        <label for="fail_borang" class="file-upload-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>Pilih Fail Baru (PDF sahaja, max 10MB)</span>
                        </label>
                    </div>

                    @error('fail_borang')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="button-group">
                <a href="{{ route('permohonans.show', $permohonan->id_permohonan) }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

    <script>
        // File upload preview
        document.getElementById('fail_borang').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = document.querySelector('.file-upload-label span');
            if (fileName) {
                label.textContent = 'Fail dipilih: ' + fileName;
            }
        });
    </script>
</body>
</html>