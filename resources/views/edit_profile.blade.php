@extends('layout.app')
@section('title', 'Edit Profil')
@section('content')
<style>
    body {
        background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    .profile-container {
        max-width: 900px;
        margin: 2rem auto;
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }
    
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
        animation: fadeInDown 0.8s ease-out;
    }
    
    .profile-header h1 {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #ffffff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 2px;
    }

    .profile-header h1::after {
        content: '';
        display: block;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        margin: 1rem auto;
        border-radius: 2px;
    }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 3rem;
        margin-bottom: 2rem;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .profile-avatar {
        text-align: center;
        margin-bottom: 3rem;
        animation: fadeInScale 0.8s ease-out 0.2s both;
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }
    
    .avatar-container {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
    }
    
    .avatar {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid rgba(255, 255, 255, 0.4);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 3.5rem;
        font-weight: 800;
        text-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.2),
            inset 0 2px 0 rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .avatar::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
        animation: avatarShine 3s ease-in-out infinite;
    }

    @keyframes avatarShine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
        50% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        100% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    }
    
    .avatar:hover {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.3),
            inset 0 2px 0 rgba(255, 255, 255, 0.4);
    }
    
    .avatar-upload {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: rgba(59, 130, 246, 0.9);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        width: 45px;
        height: 45px;
        color: white;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 
            0 4px 15px rgba(59, 130, 246, 0.4),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }
    
    .avatar-upload:hover {
        background: rgba(59, 130, 246, 1);
        transform: scale(1.15) rotate(15deg);
        box-shadow: 
            0 8px 25px rgba(59, 130, 246, 0.6),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
    }

    /* Tab Navigation Styles */
    .tab-navigation {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        animation: fadeInUp 0.6s ease-out;
    }

    .tab-button {
        background: none;
        border: none;
        padding: 1rem 1.5rem;
        color: rgba(255, 255, 255, 0.6);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        position: relative;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border-radius: 10px 10px 0 0;
    }

    .tab-button:hover {
        color: rgba(255, 255, 255, 0.9);
        background: rgba(255, 255, 255, 0.05);
    }

    .tab-button.active {
        color: #60a5fa;
        background: rgba(59, 130, 246, 0.1);
    }

    .tab-button.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, #60a5fa, transparent);
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.3s ease-out;
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
    
    .form-group {
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease-out both;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }
    .form-group:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
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

    .form-control[readonly] {
        background: rgba(255, 255, 255, 0.05);
        cursor: not-allowed;
        opacity: 0.7;
    }
    
    .password-container {
        position: relative;
    }
    
    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        font-size: 1.2rem;
        padding: 5px;
        transition: all 0.3s ease;
        border-radius: 5px;
    }
    
    .password-toggle:hover {
        color: #60a5fa;
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-50%) scale(1.1);
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

    .btn-danger {
        background: rgba(239, 68, 68, 0.3);
        color: #f87171;
        border: 1px solid rgba(239, 68, 68, 0.4);
        box-shadow: 
            0 4px 15px rgba(239, 68, 68, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .btn-danger:hover {
        background: rgba(239, 68, 68, 0.4);
        color: #fca5a5;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(239, 68, 68, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border-color: rgba(239, 68, 68, 0.6);
    }

    .btn-warning {
        background: rgba(255, 193, 7, 0.3);
        color: #fbbf24;
        border: 1px solid rgba(255, 193, 7, 0.4);
        box-shadow: 
            0 4px 15px rgba(255, 193, 7, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .btn-warning:hover {
        background: rgba(255, 193, 7, 0.4);
        color: #fcd34d;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 
            0 8px 25px rgba(255, 193, 7, 0.3),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 193, 7, 0.6);
    }
    
    .btn-group {
        display: flex;
        gap: 1.5rem;
        justify-content: center;
        margin-top: 3rem;
        animation: fadeInUp 0.8s ease-out 0.6s both;
    }
    
    .alert {
        padding: 1.25rem 1.75rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        border: none;
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        position: relative;
        animation: slideInDown 0.5s ease-out;
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

    
    .alert-danger {
        background: rgba(239, 68, 68, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(239, 68, 68, 0.4);
        border-radius: 15px;
        color: #ffffff;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
    }

    .alert ul {
        margin: 0.5rem 0 0 1rem;
        padding: 0;
        list-style-type: none;
    }

    .alert li {
        margin: 0.25rem 0;
        position: relative;
        padding-left: 1rem;
    }

    .alert li::before {
        content: '•';
        position: absolute;
        left: 0;
        color: inherit;
    }
    
    .section-divider {
        border: none;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        margin: 3rem 0;
        border-radius: 2px;
        position: relative;
    }

    .section-divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }
    
    .section-title {
        color: #ffffff;
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: 0.5px;
        animation: fadeInLeft 0.6s ease-out both;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .section-title i {
        color: #60a5fa;
        font-size: 1.2rem;
    }

    small {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.9rem;
        display: block;
        margin-top: 0.5rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .signature-preview {
        background: rgba(255, 255, 255, 0.1);
        border: 2px dashed rgba(255, 255, 255, 0.3);
        border-radius: 15px;
        padding: 2rem;
        text-align: center;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        margin-bottom: 1.5rem;
    }

    .info-box {
        background: rgba(59, 130, 246, 0.15);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 15px;
        padding: 1.25rem;
        margin-top: 1.5rem;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }

    .info-box strong {
        color: #60a5fa;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }

    .info-box ul {
        margin: 0;
        padding-left: 1.5rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.8;
    }

    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        z-index: 9999;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        animation: fadeIn 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 90%;
        max-width: 800px;
        animation: slideIn 0.3s ease-out;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translate(-50%, -60%);
        }
        to {
            opacity: 1;
            transform: translate(-50%, -50%);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-header h3 {
        color: #ffffff;
        margin: 0;
        font-size: 1.5rem;
    }

    .modal-close {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #ffffff;
        transform: rotate(90deg);
    }
    
    @media (max-width: 768px) {
        .profile-container {
            padding: 1rem;
            margin: 1rem auto;
        }
        
        .glass-card {
            padding: 2rem;
            border-radius: 20px;
        }
        
        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
        
        .profile-header h1 {
            font-size: 2.2rem;
        }
        
        .btn-group {
            flex-direction: column;
            gap: 1rem;
        }
        
        .avatar {
            width: 120px;
            height: 120px;
            font-size: 3rem;
        }

        .avatar-upload {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .section-title {
            font-size: 1.3rem;
        }

        .modal-content {
            width: 95%;
        }

        .tab-navigation {
            overflow-x: auto;
            flex-wrap: nowrap;
        }

        .tab-button {
            white-space: nowrap;
            padding: 0.875rem 1.25rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 480px) {
        .glass-card {
            padding: 1.5rem;
            margin: 0.5rem;
        }

        .profile-header h1 {
            font-size: 2rem;
        }

        .avatar {
            width: 100px;
            height: 100px;
            font-size: 2.5rem;
        }

        .form-control {
            padding: 0.875rem 1rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            font-size: 0.9rem;
        }
    }

    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        <h1><i class="fas fa-user-edit"></i> Profil Anda</h1>
    </div>
    
    <div class="glass-card">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> Sila betulkan ralat berikut:
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Tab Navigation -->
        @if(in_array(auth()->user()->peranan, ['pengarah', 'pegawai', 'pentadbir_sistem']))
        <div class="tab-navigation">
            <button class="tab-button active" onclick="switchTab('profile')">
                <i class="fas fa-user"></i> Profil
            </button>
            <button class="tab-button" onclick="switchTab('signature')">
                <i class="fas fa-signature"></i> Tandatangan Digital
            </button>
        </div>
        @endif
        
        <!-- Profile Tab Content -->
        <div id="profileTab" class="tab-content active">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Profile Avatar -->
                <div class="profile-avatar">
                    <div class="avatar-container">
                        <div class="avatar" id="avatarDisplay">
                            @if(auth()->user()->gambar_profil_url)
                                <img src="{{ auth()->user()->gambar_profil_url }}" alt="Profile Photo" id="avatarImage" style="width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; border-radius: 50%;">
                            @else
                                <span id="avatarInitial">{{ auth()->user()->initial }}</span>
                            @endif
                        </div>
                        <button class="avatar-upload" type="button" onclick="document.getElementById('gambar_profil').click();">
                            <i class="fas fa-camera"></i>
                        </button>
                    </div>
                    <input type="file" id="gambar_profil" name="gambar_profil" accept="image/*" style="display: none;" onchange="previewAvatar(event)">
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.95rem; margin: 0; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);">Klik ikon kamera untuk kemaskini gambar profil</p>
                </div>
                
                <!-- Personal Information Section -->
                <div class="section-title">
                    <i class="fas fa-user"></i> Maklumat Peribadi
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama" class="form-label">Nama <span style="color: #f87171;">*</span></label>
                        <input type="text" 
                            id="nama" 
                            name="nama" 
                            class="form-control" 
                            value="{{ old('nama', auth()->user()->nama ?? '') }}" 
                            required
                            placeholder="Masukkan nama penuh">
                    </div>
                    
                    <div class="form-group">
                        <label for="email" class="form-label">Emel <span style="color: #f87171;">*</span></label>
                        <input type="email" 
                            id="email" 
                            name="email" 
                            class="form-control" 
                            value="{{ old('email', auth()->user()->email) }}" 
                            required
                            placeholder="Masukkan Email Anda">
                    </div>
                </div>
                
                <hr class="section-divider">
                
                <!-- Security Section -->
                <div class="section-title">
                    <i class="fas fa-lock"></i> Ketetapan Keselamatan
                </div>
                
                <div class="form-group">
                    <label for="kata_laluan_semasa" class="form-label">Kata Laluan Sekarang <span style="color: #f87171;">*</span></label>
                    <div class="password-container">
                        <input type="password" 
                            id="kata_laluan_semasa" 
                            name="kata_laluan_semasa" 
                            class="form-control" 
                            placeholder="Masukkan kata laluan semasa">
                        <button type="button" class="password-toggle" onclick="togglePassword('kata_laluan_semasa')">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                    <small>Diperlukan jika ingin menukar kata laluan</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="kata_laluan" class="form-label">Kata Laluan Baharu <span style="color: #f87171;">*</span></label>
                        <div class="password-container">
                            <input type="password" 
                                id="kata_laluan" 
                                name="kata_laluan" 
                                class="form-control" 
                                placeholder="Masukkan kata laluan baharu">
                            <button type="button" class="password-toggle" onclick="togglePassword('kata_laluan')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small>Biarkan kosong jika tidak mahu menukar</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="kata_laluan_confirmation" class="form-label">Sahkan Kata Laluan Baharu <span style="color: #f87171;">*</span></label>
                        <div class="password-container">
                            <input type="password" 
                                id="kata_laluan_confirmation" 
                                name="kata_laluan_confirmation" 
                                class="form-control" 
                                placeholder="Sahkan kata laluan baharu">
                            <button type="button" class="password-toggle" onclick="togglePassword('kata_laluan_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <small>Mesti sama dengan kata laluan baharu</small>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="btn-group">
                    @if(Auth::user())
                        @php $user = Auth::user(); @endphp
                        
                        @if($user->peranan === 'admin')
                            <a href="{{ route('dashboard.admin') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        @elseif($user->peranan === 'pengarah')
                            <a href="{{ route('dashboard.pengarah') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        @elseif($user->peranan === 'pegawai')
                            <a href="{{ route('dashboard.pegawai') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        @elseif($user->peranan === 'pentadbir_sistem')
                            <a href="{{ route('dashboard.pentadbir_sistem') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                            </a>
                        @endif
                    @endif

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <!-- Signature Tab Content -->
        @if(in_array(auth()->user()->peranan, ['pengarah', 'pegawai', 'pentadbir_sistem']))
        <div id="signatureTab" class="tab-content">
            <!-- Digital Signature Section -->
            <div class="section-title">
                <i class="fas fa-signature"></i> Tandatangan Digital
            </div>
            
            <div class="form-group">
                <label class="form-label">Tandatangan Semasa</label>
                <div class="signature-preview">
                    @if(auth()->user()->tandatangan)
                        <div>
                            <img src="{{ auth()->user()->tandatangan_url }}" 
                                 alt="Tandatangan" 
                                 style="max-width: 100%; max-height: 150px; background: white; padding: 15px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);">
                            <div style="margin-top: 1rem;">
                                <small style="color: rgba(255, 255, 255, 0.8);">
                                    <i class="fas fa-info-circle"></i> Tandatangan akan dipaparkan dalam laporan PDF
                                </small>
                            </div>
                        </div>
                    @else
                        <div style="color: rgba(255, 255, 255, 0.6);">
                            <i class="fas fa-file-signature" style="font-size: 48px; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                            <p style="margin: 0; font-size: 1rem;">Tiada tandatangan. Sila muat naik atau lakar tandatangan anda.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-row" style="margin-top: 1.5rem;">
                <div class="form-group" style="margin-bottom: 0;">
                    <button type="button" class="btn btn-primary" style="width: 100%;" onclick="document.getElementById('signature_file_input').click();">
                        <i class="fas fa-upload"></i> Muat Naik Tandatangan
                    </button>
                    <input type="file" id="signature_file_input" accept="image/png,image/jpeg,image/jpg" style="display: none;" onchange="uploadSignaturePreview(event)">
                </div>
                <div class="form-group" style="margin-bottom: 0;">
                    <button type="button" class="btn btn-secondary" style="width: 100%;" onclick="openDrawSignatureModal()">
                        <i class="fas fa-pen"></i> Lakar Tandatangan
                    </button>
                </div>
            </div>

            @if(auth()->user()->tandatangan)
            <div style="text-align: center; margin-top: 1rem;">
                <button type="button" class="btn btn-danger" onclick="deleteSignature()">
                    <i class="fas fa-trash"></i> Padam Tandatangan
                </button>
            </div>
            @endif

            <div class="info-box">
                <strong>
                    <i class="fas fa-info-circle"></i> Panduan Tandatangan Digital
                </strong>
                <ul>
                    <li>Format yang diterima: PNG, JPG, JPEG</li>
                    <li>Saiz maksimum: 2MB</li>
                    <li>Dimensi minimum: 200x100 pixel</li>
                    <li>Cadangan: Guna background putih atau transparent</li>
                    <li>Tandatangan akan dipaparkan dalam laporan PDF yang anda luluskan</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="btn-group">
                @if(Auth::user())
                    @php $user = Auth::user(); @endphp
                    
                    @if($user->peranan === 'pengarah')
                        <a href="{{ route('dashboard.pengarah') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    @elseif($user->peranan === 'pegawai')
                        <a href="{{ route('dashboard.pegawai') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    @elseif($user->peranan === 'pentadbir_sistem')
                        <a href="{{ route('dashboard.pentadbir_sistem') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                        </a>
                    @endif
                @endif

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </div>
        @endif
    </div>


    <!-- Upload Signature Preview Modal -->
    <div id="uploadSignatureModal" class="modal-overlay">
        <div class="modal-content">
            <div class="glass-card" style="margin: 0;">
                <div class="modal-header">
                    <h3><i class="fas fa-upload"></i> Muat Naik Tandatangan</h3>
                    <button onclick="closeUploadModal()" class="modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div id="uploadPreviewContainer" style="background: white; border-radius: 10px; padding: 2rem; text-align: center; margin-bottom: 1.5rem; display: none;">
                    <img id="uploadPreviewImage" src="" style="max-width: 100%; max-height: 200px;">
                </div>

                <form action="{{ route('profile.signature.upload') }}" method="POST" enctype="multipart/form-data" id="uploadSignatureForm">
                    @csrf
                    <input type="file" name="signature_file" id="signature_file_hidden" accept="image/png,image/jpeg,image/jpg" style="display: none;" required>
                    
                    <div style="display: flex; gap: 1rem; justify-content: center;">
                        <button type="button" onclick="closeUploadModal()" class="btn btn-secondary">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary" id="uploadSubmitBtn">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Draw Signature Modal -->
    <div id="drawSignatureModal" class="modal-overlay">
        <div class="modal-content">
            <div class="glass-card" style="margin: 0;">
                <div class="modal-header">
                    <h3><i class="fas fa-pen"></i> Lakar Tandatangan</h3>
                    <button onclick="closeDrawModal()" class="modal-close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div style="text-align: center; margin-bottom: 1rem;">
                    <small style="color: rgba(255, 255, 255, 0.8);">Lakar tandatangan anda di dalam kotak menggunakan tetikus atau sentuh skrin</small>
                </div>

                <div style="background: white; border-radius: 10px; overflow: hidden; margin-bottom: 1.5rem;">
                    <canvas id="signatureCanvas" width="750" height="300" style="display: block; cursor: crosshair; touch-action: none;"></canvas>
                </div>

                <div style="background: rgba(255, 193, 7, 0.15); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 10px; padding: 1rem; margin-bottom: 1.5rem;">
                    <i class="fas fa-exclamation-triangle" style="color: #fbbf24;"></i>
                    <strong style="color: #fbbf24;"> Penting:</strong>
                    <span style="color: rgba(255, 255, 255, 0.8);"> Pastikan tandatangan anda jelas dan mudah dibaca.</span>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button type="button" onclick="closeDrawModal()" class="btn btn-secondary">
                        Batal
                    </button>
                    <button type="button" onclick="clearSignatureCanvas()" class="btn btn-warning">
                        <i class="fas fa-eraser"></i> Kosongkan
                    </button>
                    <button type="button" onclick="saveDrawnSignature()" class="btn btn-primary" id="saveSignatureBtn">
                        <i class="fas fa-save"></i> Simpan Tandatangan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Signature Pad Library -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
    // ===== TAB SWITCHING =====
    function switchTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });
        
        // Remove active class from all tab buttons
        document.querySelectorAll('.tab-button').forEach(button => {
            button.classList.remove('active');
        });
        
        // Show selected tab content
        if (tabName === 'profile') {
            document.getElementById('profileTab').classList.add('active');
            document.querySelector('[onclick="switchTab(\'profile\')"]').classList.add('active');
        } else if (tabName === 'signature') {
            document.getElementById('signatureTab').classList.add('active');
            document.querySelector('[onclick="switchTab(\'signature\')"]').classList.add('active');
        }
    }

    // ===== PASSWORD TOGGLE =====
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const toggle = field.nextElementSibling.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            toggle.classList.remove('fa-eye');
            toggle.classList.add('fa-eye-slash');
        } else {
            field.type = 'password';
            toggle.classList.remove('fa-eye-slash');
            toggle.classList.add('fa-eye');
        }
    }
    
    // ===== AVATAR PREVIEW =====
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarDisplay = document.getElementById('avatarDisplay');
                let avatarImage = document.getElementById('avatarImage');
                
                if (avatarImage) {
                    avatarImage.src = e.target.result;
                } else {
                    const avatarInitial = document.getElementById('avatarInitial');
                    if (avatarInitial) {
                        avatarInitial.remove();
                    }
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Profile Photo';
                    img.style.width = '100%';
                    img.style.height = '100%';
                    img.style.objectFit = 'cover';
                    img.style.position = 'absolute';
                    img.style.top = '0';
                    img.style.left = '0';
                    img.style.borderRadius = '50%';
                    img.id = 'avatarImage';
                    
                    avatarDisplay.appendChild(img);
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // ===== SIGNATURE PAD INITIALIZATION =====
    let signaturePad = null;

    function initSignaturePad() {
        const canvas = document.getElementById('signatureCanvas');
        if (canvas && !signaturePad) {
            signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1,
                maxWidth: 3
            });
        }
    }

    // ===== UPLOAD SIGNATURE FUNCTIONS =====
    function uploadSignaturePreview(event) {
        const file = event.target.files[0];
        if (file) {
            if (!file.type.match('image/(png|jpg|jpeg)')) {
                showNotification('Hanya format PNG, JPG atau JPEG dibenarkan.', 'error');
                return;
            }

            if (file.size > 2048 * 1024) {
                showNotification('Saiz fail maksimum adalah 2MB.', 'error');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('uploadPreviewImage').src = e.target.result;
                document.getElementById('uploadPreviewContainer').style.display = 'block';
                
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                document.getElementById('signature_file_hidden').files = dataTransfer.files;
                
                document.getElementById('uploadSignatureModal').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function closeUploadModal() {
        document.getElementById('uploadSignatureModal').style.display = 'none';
        document.getElementById('uploadPreviewContainer').style.display = 'none';
        document.getElementById('signature_file_input').value = '';
        document.getElementById('signature_file_hidden').value = '';
    }

    // ===== DRAW SIGNATURE FUNCTIONS =====
    function openDrawSignatureModal() {
        document.getElementById('drawSignatureModal').style.display = 'block';
        setTimeout(() => {
            initSignaturePad();
        }, 100);
    }

    function closeDrawModal() {
        document.getElementById('drawSignatureModal').style.display = 'none';
        if (signaturePad) {
            signaturePad.clear();
        }
    }

    function clearSignatureCanvas() {
        if (signaturePad) {
            signaturePad.clear();
        }
    }

    function saveDrawnSignature() {
        if (!signaturePad || signaturePad.isEmpty()) {
            showNotification('Sila lakar tandatangan anda terlebih dahulu!', 'error');
            return;
        }

        const signatureData = signaturePad.toDataURL('image/png');
        const btn = document.getElementById('saveSignatureBtn');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menyimpan...';
        btn.disabled = true;

        fetch('{{ route('profile.signature.draw') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                signature_data: signatureData
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Ralat tidak diketahui', 'error');
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Ralat: Tidak dapat menyimpan tandatangan', 'error');
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        });
    }

    // ===== DELETE SIGNATURE FUNCTION =====
    function deleteSignature() {
        if (!confirm('Adakah anda pasti ingin memadam tandatangan ini?')) {
            return;
        }

        // Show loading state
        showNotification('Sedang memadam tandatangan...', 'info');

        // Create form data with DELETE method
        const formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'DELETE');

        fetch('{{ route('profile.signature.delete') }}', {
            method: 'POST', // Laravel uses POST with _method spoofing
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            console.log('Response status:', response.status);
            
            // Check if response is ok (200-299)
            if (response.ok) {
                return response.json().catch(() => {
                    // If JSON parsing fails, but status is ok, consider it success
                    return { success: true, message: 'Tandatangan berjaya dipadam!' };
                });
            }
            
            // If not ok, try to get error message
            return response.json().catch(() => {
                throw new Error('Ralat semasa memadam tandatangan');
            }).then(data => {
                throw new Error(data.message || 'Ralat tidak diketahui');
            });
        })
        .then(data => {
            console.log('Response data:', data);
            showNotification(data.message || 'Tandatangan berjaya dipadam!', 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        })
        .catch(error => {
            console.error('Delete signature error:', error);
            showNotification(error.message || 'Ralat: Tidak dapat memadam tandatangan', 'error');
        });
    }

    // ===== FORM VALIDATION =====
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="{{ route('profile.update') }}"]');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                const newPassword = document.getElementById('kata_laluan').value;
                const confirmPassword = document.getElementById('kata_laluan_confirmation').value;
                const currentPassword = document.getElementById('kata_laluan_semasa').value;
                const nama = document.getElementById('nama').value.trim();
                const email = document.getElementById('email').value.trim();
                
                if (!nama || !email) {
                    e.preventDefault();
                    showNotification('Sila isi semua medan yang diperlukan.', 'error');
                    return;
                }
                
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    e.preventDefault();
                    showNotification('Sila masukkan alamat emel yang sah.', 'error');
                    document.getElementById('email').focus();
                    return;
                }
                
                if (newPassword && !currentPassword) {
                    e.preventDefault();
                    showNotification('Sila masukkan kata laluan semasa untuk menukar kata laluan.', 'error');
                    document.getElementById('kata_laluan_semasa').focus();
                    return;
                }
                
                if (newPassword && newPassword.length < 6) {
                    e.preventDefault();
                    showNotification('Kata laluan baru mestilah sekurang-kurangnya 6 aksara.', 'error');
                    document.getElementById('kata_laluan').focus();
                    return;
                }
                
                if (newPassword !== confirmPassword) {
                    e.preventDefault();
                    showNotification('Kata laluan baru dan pengesahan kata laluan tidak sepadan.', 'error');
                    document.getElementById('kata_laluan_confirmation').focus();
                    return;
                }
                
                const submitBtn = e.target.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengemaskini...';
                    submitBtn.disabled = true;
                }
            });
        }

        // Upload form submission
        const uploadForm = document.getElementById('uploadSignatureForm');
        if (uploadForm) {
            uploadForm.addEventListener('submit', function(e) {
                const btn = document.getElementById('uploadSubmitBtn');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat naik...';
                btn.disabled = true;
            });
        }
    });

    // ===== NOTIFICATION SYSTEM =====
    function showNotification(message, type = 'info') {
        const existingNotifications = document.querySelectorAll('.custom-notification');
        existingNotifications.forEach(notification => notification.remove());
        
        const notification = document.createElement('div');
        notification.className = `custom-notification custom-notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            max-width: 400px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            animation: slideInRight 0.3s ease-out;
            background: ${type === 'error' ? 'rgba(239, 68, 68, 0.2)' : type === 'success' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(59, 130, 246, 0.2)'};
            border-color: ${type === 'error' ? 'rgba(239, 68, 68, 0.4)' : type === 'success' ? 'rgba(34, 197, 94, 0.4)' : 'rgba(59, 130, 246, 0.4)'};
        `;
        
        notification.innerHTML = `
            <div style="padding: 1rem 1.5rem; display: flex; align-items: center; gap: 0.75rem; color: #ffffff; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" style="background: none; border: none; color: rgba(255, 255, 255, 0.7); cursor: pointer; padding: 0.25rem; margin-left: auto; border-radius: 50%; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    // ===== CLOSE MODALS ON ESC =====
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeUploadModal();
            closeDrawModal();
        }
    });

    // ===== AUTO-HIDE SUCCESS MESSAGES =====
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert-success');
        alerts.forEach(function(alert) {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.remove();
                }
            }, 500);
        });
    }, 5000);
</script>

@endsection