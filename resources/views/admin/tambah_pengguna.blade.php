<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna Baru</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
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
            margin: 0;
            padding: 0;
        }

        .modern-container {
            padding: 2rem;
            position: relative;
            z-index: 1;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.18);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .form-header {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1.5rem;
        }

        .form-header h4 {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-body {
            padding: 2rem;
        }

        .form-label {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            color: #ffffff;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: rgba(59, 130, 246, 0.6);
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
            color: #ffffff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-select option {
            background: #003366;
            color: #ffffff;
        }

        .form-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.875rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(239, 68, 68, 0.4);
            border-radius: 15px;
            color: #ffffff;
            padding: 1rem 1.5rem;
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .alert-danger ul {
            margin-bottom: 0;
            padding-left: 1.5rem;
        }

        .invalid-feedback {
            color: #fca5a5;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            display: block;
        }

        .btn-secondary {
            background: rgba(100, 116, 139, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(100, 116, 139, 0.4);
            border-radius: 15px;
            color: #cbd5e1;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
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

        .btn-primary {
            background: rgba(0, 98, 255, 0.3);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.4);
            border-radius: 15px;
            color: #60a5fa;
            padding: 0.8rem 1.5rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 
                0 4px 15px rgba(59, 130, 246, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
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


        .text-danger {
            color: #fca5a5 !important;
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .form-body {
                padding: 1.5rem;
            }

            .form-header h4 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="modern-container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <div class="form-header">
                       <h4><i class="bi bi-person-plus-fill"></i> Tambah Pengguna Baru</h4>
                    </div>
                    <div class="form-body">
                        {{-- Error Messages --}}
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pengguna.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="nama" class="form-label">
                                    <i class="bi bi-person-fill"></i> Nama <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" value="{{ old('nama') }}" required maxlength="100"
                                       placeholder="Masukkan nama penuh">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope-fill"></i> Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required maxlength="100"
                                       placeholder="contoh@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kata_laluan" class="form-label">
                                    <i class="bi bi-lock-fill"></i> Kata Laluan <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control @error('kata_laluan') is-invalid @enderror" 
                                       id="kata_laluan" name="kata_laluan" required minlength="6" maxlength="100"
                                       placeholder="Masukkan kata laluan">
                                @error('kata_laluan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Kata laluan mestilah sekurang-kurangnya 6 aksara.</div>
                            </div>

                            <div class="mb-3">
                                <label for="kata_laluan_confirmation" class="form-label">
                                    <i class="bi bi-shield-lock-fill"></i> Sahkan Kata Laluan <span class="text-danger">*</span>
                                </label>
                                <input type="password" class="form-control" 
                                       id="kata_laluan_confirmation" name="kata_laluan_confirmation" required maxlength="100"
                                       placeholder="Masukkan semula kata laluan">
                            </div>

                            <div class="mb-3">
                                <label for="peranan" class="form-label">
                                    <i class="bi bi-person-badge-fill"></i> Peranan <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('peranan') is-invalid @enderror" 
                                        id="peranan" name="peranan" required>
                                    <option value="">Pilih Peranan</option>
                                    <option value="admin" {{ old('peranan') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="pengarah" {{ old('peranan') == 'pengarah' ? 'selected' : '' }}>Pengarah</option>
                                    <option value="pegawai" {{ old('peranan') == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                                    <option value="pentadbir_sistem" {{ old('peranan') == 'pentadbir_sistem' ? 'selected' : '' }}>Pentadbir Sistem</option>
                                </select>
                                @error('peranan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('pengurusan.pengguna') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Pengguna
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>