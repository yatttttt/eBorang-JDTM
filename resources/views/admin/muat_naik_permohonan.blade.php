@extends('layout.app')
@section('title', 'Muat Naik Permohonan')
@section('content')

<style>
    body {
        background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
        min-height: 100vh;
        position: relative;
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
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 3rem;
        margin-bottom: 2rem;
        width: 100%;
        max-width: 900px;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .dashboard-title {
        color: #ffffff;
        text-align: center;
        margin-bottom: 5rem;
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

    .alert-success {
        background: rgba(34, 197, 94, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(34, 197, 94, 0.4);
        border-radius: 15px;
        color: #ffffff;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
    }

    .form-group {
        margin-bottom: 2rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 600;
        color: #ffffff;
        font-size: 1rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        letter-spacing: 0.5px;
    }

    .form-label i {
        margin-right: 0.5rem;
        opacity: 0.9;
    }

    .form-control {
        width: 100%;
        padding: 1rem 1.25rem;
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        font-size: 1rem;
        color: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
        box-shadow: 
            0 4px 15px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    .form-control:focus {
        outline: none;
        border-color: rgba(59, 130, 246, 0.6);
        background: rgba(255, 255, 255, 0.2);
        box-shadow: 
            0 0 0 4px rgba(59, 130, 246, 0.1),
            0 8px 25px rgba(0, 0, 0, 0.15),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    select.form-control {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 3rem;
    }

    select.form-control option {
        background: #1e293b;
        color: white;
        padding: 0.5rem;
    }

    .section-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 600;
        margin: 3rem 0 2rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: 0.5px;
    }

    .section-title::before {
        content: '';
        display: inline-block;
        width: 5px;
        height: 2rem;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        border-radius: 3px;
    }

    .section-title i {
        color: #ffffffff;
        font-size: 1.2rem;
    }

    .category-row {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        display: grid;
        grid-template-columns: 1fr 1fr auto;
        gap: 1rem;
        align-items: center;
    }

    .category-row:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-success {
        background: linear-gradient(135deg, #10b981, #06d6a0);
        color: white;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 1.2rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #05a085);
        transform: scale(1.15) rotate(90deg);
    }

    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        font-size: 1.2rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        transform: scale(1.15) rotate(-90deg);
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 1.1rem;
        padding: 1.3rem 2.5rem;
        border-radius: 12px;
        font-weight: 600;
        background: rgba(0, 98, 255, 0.3);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.4);
        border-radius: 15px;
        color: #60a5fa;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 4px 15px rgba(59, 130, 246, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        border: none;
        width: 100%;
        justify-content: center;
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

    .btn-primary:disabled,
    .disabled-btn {
        cursor: not-allowed;
        opacity: 0.6;
        transform: none !important;
        box-shadow: none !important;
    }

    .btn-secondary{
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

    .btn-secondary:before {
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
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .text-danger {
        color: #fca5a5;
    }

    .invalid-feedback {
        color: #fca5a5;
        font-weight: 500;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .submit-area {
        margin-top: 3rem;
        padding-top: 2.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        display: flex;
        justify-content: center;
    }

    .file-upload-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }

    .file-upload-wrapper .form-control[type="file"] {
        position: absolute;
        left: -9999px;
    }

    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        padding: 2rem;
        border: 2px dashed rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all 0.3s ease;
        text-align: center;
    }

    .file-upload-label:hover {
        border-color: rgba(59, 130, 246, 0.6);
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-2px);
    }

    .file-upload-icon {
        font-size: 2.5rem;
        color: #60a5fa;
        opacity: 0.8;
    }

    .file-upload-text {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .file-upload-text .main-text {
        color: #ffffff;
        font-weight: 600;
        font-size: 1.1rem;
    }

    .file-upload-text .sub-text {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
    }

    .file-name-display {
        margin-top: 1rem;
        padding: 1rem;
        background: rgba(34, 197, 94, 0.1);
        border: 1px solid rgba(34, 197, 94, 0.3);
        border-radius: 12px;
        color: #22c55e;
        display: none;
        align-items: center;
        gap: 0.5rem;
    }

    .file-name-display.show {
        display: flex;
    }

    .remove-file-btn {
        background: transparent;
        border: none;
        color: #ef4444;
        font-size: 1rem;
        margin-left: 10px;
        cursor: pointer;
    }

    .remove-file-btn:hover {
        color: #dc2626;
    }

    .back-area {
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
        text-align: center;
    }

    .checkbox-container {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        padding: 1.5rem;
    }

    .checkbox-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        cursor: pointer;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .checkbox-label:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateX(5px);
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #3b82f6;
    }

    .checkbox-label span {
        color: #ffffff;
        font-weight: 500;
        font-size: 1rem;
    }

    .checkbox-label i {
        margin-right: 0.5rem;
    }

    @media (max-width: 768px) {
        .dashboard-container {
            margin-top: 1rem;
            padding: 0 0.5rem;
        }

        .glass-card {
            padding: 2rem;
            border-radius: 20px;
        }

        .dashboard-title {
            font-size: 2.2rem;
        }

        .category-row {
            grid-template-columns: 1fr;
        }

        .btn-success, .btn-danger {
            width: 45px;
            height: 45px;
            font-size: 1rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="glass-card">
        <h1 class="dashboard-title"><i class="fas fa-upload"></i> Muat Naik Permohonan</h1>
        
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

        <form method="POST" action="{{ route('admin.permohonan.store') }}" enctype="multipart/form-data" id="permohonanForm">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-hashtag"></i>
                    No. Kawalan <span class="text-danger">*</span>
                </label>
                <input type="text" name="no_kawalan" class="form-control @error('no_kawalan') is-invalid @enderror" 
                       value="{{ old('no_kawalan') }}" required placeholder="Masukkan nombor kawalan" maxlength="255">
                @error('no_kawalan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user"></i>
                    Nama Pemohon <span class="text-danger">*</span>
                </label>
                <input type="text" name="nama_pemohon" class="form-control @error('nama_pemohon') is-invalid @enderror" 
                       value="{{ old('nama_pemohon') }}" required placeholder="Masukkan nama penuh">
                @error('nama_pemohon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-id-card"></i>
                    No. Kad Pengenalan <span class="text-danger">*</span>
                </label>
                <input type="text" name="no_kp" class="form-control @error('no_kp') is-invalid @enderror" 
                       value="{{ old('no_kp') }}" required placeholder="Contoh: 901234567890">
                @error('no_kp')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-briefcase"></i>
                    Jawatan <span class="text-danger">*</span>
                </label>
                <input type="text" name="jawatan" class="form-control @error('jawatan') is-invalid @enderror" 
                       value="{{ old('jawatan') }}" required placeholder="Contoh: Penolong Pegawai Tadbir">
                @error('jawatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

           <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-building"></i>
                    Jabatan <span class="text-danger">*</span>
                </label>
                <select name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="JABATAN KHIDMAT PENGURUSAN" {{ old('jabatan') == 'JABATAN KHIDMAT PENGURUSAN' ? 'selected' : '' }}>JABATAN KHIDMAT PENGURUSAN</option>
                    <option value="JABATAN DIGITAL & TEKNOLOGI MAKLUMAT" {{ old('jabatan') == 'JABATAN DIGITAL & TEKNOLOGI MAKLUMAT' ? 'selected' : '' }}>JABATAN DIGITAL & TEKNOLOGI MAKLUMAT</option>
                    <option value="JABATAN PERUNDANGAN" {{ old('jabatan') == 'JABATAN PERUNDANGAN' ? 'selected' : '' }}>JABATAN PERUNDANGAN</option>
                    <option value="JABATAN PENILAIAN DAN PENGURUSAN HARTA" {{ old('jabatan') == 'JABATAN PENILAIAN DAN PENGURUSAN HARTA' ? 'selected' : '' }}>JABATAN PENILAIAN DAN PENGURUSAN HARTA</option>
                    <option value="JABATAN KEBERSIHAN AWAM DAN KELESTARIAN SISA" {{ old('jabatan') == 'JABATAN KEBERSIHAN AWAM DAN KELESTARIAN SISA' ? 'selected' : '' }}>JABATAN KEBERSIHAN AWAM DAN KELESTARIAN SISA</option>
                    <option value="JABATAN LANSKAP" {{ old('jabatan') == 'JABATAN LANSKAP' ? 'selected' : '' }}>JABATAN LANSKAP</option>
                    <option value="JABATAN KONTRAK DAN UKUR BAHAN" {{ old('jabatan') == 'JABATAN KONTRAK DAN UKUR BAHAN' ? 'selected' : '' }}>JABATAN KONTRAK DAN UKUR BAHAN</option>
                    <option value="JABATAN PERANCANGAN" {{ old('jabatan') == 'JABATAN PERANCANGAN' ? 'selected' : '' }}>JABATAN PERANCANGAN</option>
                    <option value="JABATAN KEJURUTERAAN" {{ old('jabatan') == 'JABATAN KEJURUTERAAN' ? 'selected' : '' }}>JABATAN KEJURUTERAAN</option>
                    <option value="JABATAN KEWANGAN" {{ old('jabatan') == 'JABATAN KEWANGAN' ? 'selected' : '' }}>JABATAN KEWANGAN</option>
                    <option value="JABATAN PENGUATKUASAAN" {{ old('jabatan') == 'JABATAN PENGUATKUASAAN' ? 'selected' : '' }}>JABATAN PENGUATKUASAAN</option>
                    <option value="JABATAN PELESENAN" {{ old('jabatan') == 'JABATAN PELESENAN' ? 'selected' : '' }}>JABATAN PELESENAN</option>
                    <option value="JABATAN PEMBANGUNAN KOMUNITI" {{ old('jabatan') == 'JABATAN PEMBANGUNAN KOMUNITI' ? 'selected' : '' }}>JABATAN PEMBANGUNAN KOMUNITI</option>
                    <option value="JABATAN KORPORAT DAN PERHUBUNGAN AWAM" {{ old('jabatan') == 'JABATAN KORPORAT DAN PERHUBUNGAN AWAM' ? 'selected' : '' }}>JABATAN KORPORAT DAN PERHUBUNGAN AWAM</option>
                    <option value="JABATAN KESIHATAN PERSEKITARAN" {{ old('jabatan') == 'JABATAN KESIHATAN PERSEKITARAN' ? 'selected' : '' }}>JABATAN KESIHATAN PERSEKITARAN</option>
                    <option value="BAHAGIAN PESURUHJAYA BANGUNAN" {{ old('jabatan') == 'BAHAGIAN PESURUHJAYA BANGUNAN' ? 'selected' : '' }}>BAHAGIAN PESURUHJAYA BANGUNAN</option>
                    <option value="JABATAN PENGANGKUTAN BANDAR" {{ old('jabatan') == 'JABATAN PENGANGKUTAN BANDAR' ? 'selected' : '' }}>JABATAN PENGANGKUTAN BANDAR</option>
                    <option value="JABATAN BANGUNAN" {{ old('jabatan') == 'JABATAN BANGUNAN' ? 'selected' : '' }}>JABATAN BANGUNAN</option>
                    <option value="BAHAGIAN AUDIT DALAM" {{ old('jabatan') == 'BAHAGIAN AUDIT DALAM' ? 'selected' : '' }}>BAHAGIAN AUDIT DALAM</option>
                    <option value="BAHAGIAN INTEGRITI" {{ old('jabatan') == 'BAHAGIAN INTEGRITI' ? 'selected' : '' }}>BAHAGIAN INTEGRITI</option>
                    <option value="BAHAGIAN PUSAT SETEMPAT" {{ old('jabatan') == 'BAHAGIAN PUSAT SETEMPAT' ? 'selected' : '' }}>BAHAGIAN PUSAT SETEMPAT</option>
                    <option value="PEJABAT CAWANGAN KOTA KEMUNING" {{ old('jabatan') == 'PEJABAT CAWANGAN KOTA KEMUNING' ? 'selected' : '' }}>PEJABAT CAWANGAN KOTA KEMUNING</option>
                    <option value="PEJABAT CAWANGAN SG.BULOH" {{ old('jabatan') == 'PEJABAT CAWANGAN SG.BULOH' ? 'selected' : '' }}>PEJABAT CAWANGAN SG.BULOH</option>
                    <option value="PEJABAT CAWANGAN SETIA ALAM" {{ old('jabatan') == 'PEJABAT CAWANGAN SETIA ALAM' ? 'selected' : '' }}>PEJABAT CAWANGAN SETIA ALAM</option>
                </select>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <h4 class="section-title">
                <i class="fas fa-file-alt"></i>
                Jenis Permohonan <span class="text-danger">*</span>
            </h4>

            <div class="form-group">
                <div class="checkbox-container">
                    <div class="checkbox-wrapper">
                        <label class="checkbox-label">
                            <input type="checkbox" name="jenis_permohonan[]" value="Pendaftaran Baru" class="jenis-checkbox"
                                   {{ is_array(old('jenis_permohonan')) && in_array('Pendaftaran Baru', old('jenis_permohonan')) ? 'checked' : '' }}>
                            <span>
                                <i class="fas fa-user-plus" style="color: #22c55e;"></i>
                                Pendaftaran Baru
                            </span>
                        </label>

                        <label class="checkbox-label">
                            <input type="checkbox" name="jenis_permohonan[]" value="Kemaskini Akaun" class="jenis-checkbox"
                                   {{ is_array(old('jenis_permohonan')) && in_array('Kemaskini Akaun', old('jenis_permohonan')) ? 'checked' : '' }}>
                            <span>
                                <i class="fas fa-user-edit" style="color: #3b82f6;"></i>
                                Kemaskini Akaun
                            </span>
                        </label>

                        <label class="checkbox-label">
                            <input type="checkbox" name="jenis_permohonan[]" value="Penamatan Akaun" class="jenis-checkbox"
                                   {{ is_array(old('jenis_permohonan')) && in_array('Penamatan Akaun', old('jenis_permohonan')) ? 'checked' : '' }}>
                            <span>
                                <i class="fas fa-user-times" style="color: #ef4444;"></i>
                                Penamatan Akaun
                            </span>
                        </label>
                    </div>
                </div>
                @error('jenis_permohonan')
                    <div class="invalid-feedback" style="display: block;">{{ $message }}</div>
                @enderror
                <div id="jenisError" class="invalid-feedback" style="display: none;">
                    Sila pilih sekurang-kurangnya satu jenis permohonan
                </div>
            </div>

            <h4 class="section-title">
                <i class="fas fa-tags"></i>
                Kategori Permohonan <span class="text-danger">*</span>
            </h4>

            <div id="kategoriContainer">
                <div class="category-row">
                    <div>
                        <select name="kategori[]" class="form-control @error('kategori.0') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori (Diperlukan) --</option>
                            <option value="Sistem Aplikasi/Modul" {{ old('kategori.0') == 'Sistem Aplikasi/Modul' ? 'selected' : '' }}>
                                Sistem Aplikasi/Modul
                            </option>
                            <option value="Server/Pangkalan Data" {{ old('kategori.0') == 'Server/Pangkalan Data' ? 'selected' : '' }}>
                                Server/Pangkalan Data
                            </option>
                            <option value="Emel Rasmi MBSA" {{ old('kategori.0') == 'Emel Rasmi MBSA' ? 'selected' : '' }}>
                                Emel Rasmi MBSA
                            </option>
                        </select>
                        @error('kategori.0')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <input type="text" name="subkategori[]" class="form-control" 
                               placeholder="Subkategori (Opsyenal)" value="{{ old('subkategori.0') }}">
                    </div>
                    <div>
                        <button type="button" class="btn-success" onclick="tambahKategori()" title="Tambah Kategori">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

             <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-file-upload"></i>
                    Muat Naik Borang <span class="text-danger">*</span>
                </label>
                <div class="file-upload-wrapper">
                    <input type="file" 
                           id="fail_borang" 
                           name="fail_borang" 
                           class="form-control @error('fail_borang') is-invalid @enderror" 
                           required 
                           accept=".pdf"
                           onchange="displayFileName(this)">
                    <label for="fail_borang" class="file-upload-label">
                        <div class="file-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file-upload-text">
                            <span class="main-text">Klik untuk memilih fail</span>
                            <span class="sub-text">atau seret dan lepas fail di sini</span>
                        </div>
                    </label>
                    <div id="fileNameDisplay" class="file-name-display">
                        <i class="fas fa-file-check"></i>
                        <span id="fileName"></span>
                        <button type="button" id="removeFileBtn" class="remove-file-btn" onclick="removeFile()">❌</button>
                    </div>
                </div>
                @error('fail_borang')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">
                    <i class="fas fa-info-circle me-1"></i>
                    Format yang dibenarkan: PDF sahaja. Saiz maksimum: 10MB
                </small>
            </div>

            <div class="submit-area">
                <button type="submit" id="submitBtn" class="btn-primary disabled-btn" disabled>
                    <i class="fas fa-paper-plane"></i>
                    Hantar Permohonan
                </button>
            </div>
        </form>
        
        <div class="back-area">
            <a href="{{ route('dashboard.admin') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<script>

     // Auto-hide success messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.transition = 'opacity 0.5s';
                successAlert.style.opacity = '0';
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 5000);
        }
    });

    // Form validation untuk jenis permohonan
    document.getElementById('permohonanForm').addEventListener('submit', function(e) {
        const checkboxes = document.querySelectorAll('.jenis-checkbox');
        const checked = Array.from(checkboxes).some(cb => cb.checked);
        const errorDiv = document.getElementById('jenisError');
        
        if (!checked) {
            e.preventDefault();
            errorDiv.style.display = 'block';
            
            // Scroll to error
            errorDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            return false;
        } else {
            errorDiv.style.display = 'none';
        }
    });

    // Hide error when checkbox is checked
    document.querySelectorAll('.jenis-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.jenis-checkbox');
            const checked = Array.from(checkboxes).some(cb => cb.checked);
            const errorDiv = document.getElementById('jenisError');
            
            if (checked) {
                errorDiv.style.display = 'none';
            }
        });
    });

    function tambahKategori() {
        let container = document.getElementById("kategoriContainer");
        let row = document.createElement("div");
        row.classList.add("category-row");
        row.innerHTML = `
            <div>
                <select name="kategori[]" class="form-control">
                    <option value="">-- Pilih Kategori (Diperlukan) --</option>
                    <option value="Sistem Aplikasi/Modul">Sistem Aplikasi/Modul</option>
                    <option value="Server/Pangkalan Data">Server/Pangkalan Data</option>
                    <option value="Emel Rasmi MBSA">Emel Rasmi MBSA</option>
                </select>
            </div>
            <div>
                <input type="text" name="subkategori[]" class="form-control" placeholder="Subkategori (Opsyenal)">
            </div>
            <div>
                <button type="button" class="btn-danger" onclick="buangKategori(this)" title="Buang Kategori">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        setTimeout(() => {
            row.style.transition = 'all 0.4s ease';
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 100);
    }

    function buangKategori(element) {
        const row = element.closest('.category-row');
        row.style.transition = 'all 0.4s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateY(-20px) scale(0.9)';
        setTimeout(() => {
            row.remove();
        }, 400);
    }

    function displayFileName(input) {
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const fileNameSpan = document.getElementById('fileName');
        const submitBtn = document.getElementById('submitBtn');

        if (input.files && input.files.length > 0) {
            const fileName = input.files[0].name;
            fileNameSpan.textContent = fileName;
            fileNameDisplay.classList.add('show');

            // Enable button
            submitBtn.disabled = false;
            submitBtn.classList.remove('disabled-btn');
        } else {
            resetFileSelection();
        }
    }

    function removeFile() {
        const fileInput = document.getElementById('fail_borang');
        fileInput.value = ""; // clear file input
        resetFileSelection();
    }

    function resetFileSelection() {
        const fileNameDisplay = document.getElementById('fileNameDisplay');
        const fileNameSpan = document.getElementById('fileName');
        const submitBtn = document.getElementById('submitBtn');

        fileNameSpan.textContent = '';
        fileNameDisplay.classList.remove('show');

        submitBtn.disabled = true;
        submitBtn.classList.add('disabled-btn');
    }

</script>

@endsection