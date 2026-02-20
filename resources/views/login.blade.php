<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Masuk - eBorang JDTM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg,  #003366 0%, #000000ff 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        @keyframes pulse {
            0% { transform: scale(1) rotate(0deg); opacity: 0.3; }
            100% { transform: scale(1.5) rotate(180deg); opacity: 0.1; }
        }

        .login-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 2;
            animation: slideInUp 1s ease-out;
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-with-bg {
            width: 200px;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
            transition: all 0.3s ease;
        }

        .login-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            width: 420px;
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            animation: cardFloat 8s ease-in-out infinite 0.5s;
        }

        .login-title {
            text-align: center;
            margin-bottom: 2rem;
            color: #ffffff;
            font-size: 2.5rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            animation: titleGlow 2s ease-in-out infinite alternate;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, transparent, #0099FF, transparent);
            border-radius: 2px;
        }

        @keyframes titleGlow {
            0% { text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); }
            100% { text-shadow: 0 4px 30px rgba(255, 255, 255, 0.2); }
        }

        .form-group {
            position: relative;
            margin-bottom: 2rem;
            animation: fadeInLeft 0.6s ease-out both;
        }

        .form-group:nth-child(1) { animation-delay: 0.7s; }
        .form-group:nth-child(2) { animation-delay: 0.9s; }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-group input {
            width: 100%;
            padding: 1.2rem 1.5rem;
            font-size: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            color: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 4px 15px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
        }

        .form-group input::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-group input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.6);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 0 0 4px rgba(59, 130, 246, 0.1),
                0 8px 25px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .form-group label {
            position: absolute;
            left: 1.5rem;
            top: 1.2rem;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -8px;
            left: 1.2rem;
            font-size: 0.85rem;
            background: rgba(59, 130, 246, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            padding: 0.3rem 0.8rem;
            border-radius: 10px;
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(59, 130, 246, 0.3);
        }

        .form-group {
            transform: translateZ(0);
        }

        .form-group:hover input {
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.15);
        }

        .input-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.6);
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .form-group input:focus ~ .input-icon {
            color: #60a5fa;
            transform: translateY(-50%) scale(1.1);
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .password-toggle:hover {
            color: #60a5fa;
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-50%) scale(1.1);
        }

        .forgot-password-link {
            display: block;
            text-align: right;
            margin-top: -1rem;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .forgot-password-link:hover {
            color: #60a5fa;
            text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
        }

        .login-button {
            width: 100%;
            background: rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(59, 130, 246, 0.4);
            padding: 1.2rem;
            color: #60a5fa;
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 1px;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 4px 15px rgba(59, 130, 246, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            text-transform: uppercase;
            animation: fadeInUp 0.6s ease-out 1.1s both;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }

        .login-button:hover::before {
            left: 100%;
        }

        .login-button:hover {
            background: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(59, 130, 246, 0.6);
        }

        .login-button:active {
            transform: translateY(-1px) scale(1.01);
        }

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

        .error-container {
            margin-bottom: 1.5rem;
            animation: shakeIn 0.6s ease-out;
        }

        @keyframes shakeIn {
            0% { transform: translateX(-10px); opacity: 0; }
            25% { transform: translateX(10px); }
            50% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
            100% { transform: translateX(0); opacity: 1; }
        }

        .error-message {
            background: rgba(239, 68, 68, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #f87171;
            font-size: 0.9rem;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            box-shadow: 
                0 4px 15px rgba(239, 68, 68, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }

        .error-message ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .error-message li {
            margin: 0.25rem 0;
            position: relative;
            padding-left: 1.5rem;
        }

        .error-message li::before {
            content: '⚠️';
            position: absolute;
            left: 0;
            top: 0;
        }

        /* Modal Styles */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            z-index: 1000;
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }

        .modal-overlay.active {
            display: flex;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 2.5rem;
            width: 90%;
            max-width: 450px;
            position: relative;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
            animation: modalSlideIn 0.4s ease-out;
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(-50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
        }

        .modal-close:hover {
            background: rgba(239, 68, 68, 0.3);
            border-color: rgba(239, 68, 68, 0.4);
            color: #f87171;
            transform: rotate(90deg);
        }

        .modal-title {
            color: #ffffff;
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .modal-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            text-align: center;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .success-message {
            background: rgba(34, 197, 94, 0.2);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(34, 197, 94, 0.4);
            color: #4ade80;
            font-size: 0.9rem;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            box-shadow: 
                0 4px 15px rgba(34, 197, 94, 0.2),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            animation: successSlideIn 0.5s ease-out;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        @keyframes successSlideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-message i {
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                gap: 2rem;
                padding: 1rem;
            }

            .logo-with-bg {
                width: 200px;
            }

            .login-box, .modal-content {
                width: 100%;
                max-width: 400px;
                padding: 2rem 1.5rem;
            }

            .login-title, .modal-title {
                font-size: 2rem;
            }

            .form-group input {
                padding: 1rem 1.25rem;
            }

            .form-group label {
                left: 1.25rem;
                top: 1rem;
            }

            .form-group input:focus + label,
            .form-group input:not(:placeholder-shown) + label {
                left: 1rem;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 0.5rem;
            }

            .login-box, .modal-content {
                padding: 1.5rem 1rem;
            }

            .login-title, .modal-title {
                font-size: 1.8rem;
                letter-spacing: 1px;
            }

            .logo-with-bg {
                width: 150px;
            }
        }

        .custom-notification {
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
        }
        
        .custom-notification-error {
            background: rgba(239, 68, 68, 0.2);
            border-color: rgba(239, 68, 68, 0.4);
        }
        
        .custom-notification-success {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.4);
        }
        
        .notification-content {
            padding: 1rem 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        }
        
        .notification-close {
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            padding: 0.25rem;
            margin-left: auto;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
        }
        
        .notification-close:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
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
</head>
<body>
    <div class="login-container">
        <div class="logo-section">
            <img src='{{ asset('images/logo_JDTM.png') }}' alt='Logo JDTM' class="logo-with-bg">
        </div>
        
        <div class="login-box">
            <h2 class="login-title">Log Masuk</h2>
            
            {{-- Display errors --}}
            @if ($errors->any())
                <div class="error-container">
                    <div class="error-message">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Display success message --}}
            @if (session('status'))
                <div class="error-container">
                    <div class="success-message">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                </div>
            @endif
            
            <form method="POST" action="{{ url('/login') }}" id="loginForm">
                @csrf
                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           placeholder=" "
                           autocomplete="email">
                    <label>Emel</label>
                    <i class="input-icon fas fa-envelope"></i>
                </div>
                
                <div class="form-group">
                    <input type="password" 
                           name="kata_laluan" 
                           required 
                           placeholder=" "
                           autocomplete="current-password"
                           id="passwordInput">
                    <label>Kata Laluan</label>
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        <i class="fas fa-eye" id="passwordToggleIcon"></i>
                    </button>
                </div>

                <a class="forgot-password-link" onclick="openForgotPasswordModal()">
                    Terlupa Kata Laluan?
                </a>
                
                <button type="submit" class="login-button" id="loginButton">
                    <i class="fas fa-sign-in-alt"></i> Masuk ke Sistem
                </button>
            </form>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal-overlay" id="forgotPasswordModal">
        <div class="modal-content">
            <button class="modal-close" onclick="closeForgotPasswordModal()">
                <i class="fas fa-times"></i>
            </button>
            
            <h2 class="modal-title">
                <i class="fas fa-key"></i> Reset Kata Laluan
            </h2>
            <p class="modal-description">
                Masukkan alamat email anda yang terdaftar. Kami akan menghantar pautan untuk menetapkan semula kata laluan anda.
            </p>

            <div id="resetSuccessMessage" style="display: none;">
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>Pautan reset kata laluan telah dihantar ke email anda. Sila semak inbox atau folder spam anda.</span>
                </div>
            </div>
            
            <form method="POST" action="{{ url('/forgot-password') }}" id="forgotPasswordForm">
                @csrf
                <div class="form-group">
                    <input type="email" 
                           name="email" 
                           required 
                           placeholder=" "
                           autocomplete="email"
                           id="resetEmail">
                    <label>Email</label>
                    <i class="input-icon fas fa-envelope"></i>
                </div>
                
                <button type="submit" class="login-button" id="resetButton">
                    <i class="fas fa-paper-plane"></i> Hantar Pautan Reset
                </button>
            </form>
        </div>
    </div>

<script>
    // =========================
    // Toggle password visibility
    // =========================
    function togglePassword() {
        const passwordInput = document.getElementById('passwordInput');
        const toggleIcon = document.getElementById('passwordToggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // =========================
    // Open forgot password modal
    // =========================
    function openForgotPasswordModal() {
        const modal = document.getElementById('forgotPasswordModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Reset form and hide success message when opened again
        const form = document.getElementById('forgotPasswordForm');
        const successDiv = document.getElementById('resetSuccessMessage');
        if (form) form.style.display = 'block';
        if (successDiv) successDiv.style.display = 'none';
        if (form) form.reset();
    }

    // =========================
    // Close forgot password modal
    // =========================
    function closeForgotPasswordModal() {
        const modal = document.getElementById('forgotPasswordModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    document.getElementById('forgotPasswordModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeForgotPasswordModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeForgotPasswordModal();
        }
    });

    // =========================
    // Login form submission
    // =========================
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const loginButton = document.getElementById('loginButton');
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="kata_laluan"]').value;

        // Basic validation
        if (!email || !password) {
            e.preventDefault();
            showNotification('Sila isi semua ruangan yang diperlukan.', 'error');
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            showNotification('Sila masukkan alamat email yang sah.', 'error');
            document.querySelector('input[name="email"]').focus();
            return;
        }

        // Loading state
        loginButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Log Masuk...';
        loginButton.classList.add('loading');
        loginButton.disabled = true;
    });

    // =========================
    // Forgot password form submission
    // =========================
    document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const resetButton = document.getElementById('resetButton');
        const email = document.getElementById('resetEmail').value.trim();

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            showNotification('Sila masukkan alamat email yang sah.', 'error');
            document.getElementById('resetEmail').focus();
            return;
        }

        // Show loading state
        resetButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghantar...';
        resetButton.disabled = true;

        // Submit to backend
        this.submit();
    });

    // =========================
    // Custom notification system
    // =========================
    function showNotification(message, type = 'info') {
        // Remove existing notifications
        document.querySelectorAll('.custom-notification').forEach(el => el.remove());
        
        const notification = document.createElement('div');
        notification.className = `custom-notification custom-notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas ${type === 'error' ? 'fa-exclamation-circle' : type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
                <button class="notification-close" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `;
        document.body.appendChild(notification);

        // Auto remove after 5s
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }

    // =========================
    // Real-time input validation
    // =========================
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.addEventListener('blur', function() { validateInput(this); });
            input.addEventListener('input', function() {
                this.style.borderColor = '';
                this.style.boxShadow = '';
            });
        });
    });

    function validateInput(input) {
        const value = input.value.trim();
        let isValid = true;
        
        if (input.hasAttribute('required') && !value) isValid = false;
        else if (input.type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) isValid = false;
        }

        if (!isValid) {
            input.style.borderColor = 'rgba(239, 68, 68, 0.6)';
            input.style.boxShadow = '0 0 0 4px rgba(239, 68, 68, 0.1)';
        } else {
            input.style.borderColor = 'rgba(34, 197, 94, 0.4)';
            input.style.boxShadow = '0 0 0 4px rgba(34, 197, 94, 0.1)';
        }

        return isValid;
    }

    // =========================
    // Auto-hide error messages
    // =========================
    setTimeout(() => {
        document.querySelectorAll('.error-message').forEach(error => {
            error.style.transition = 'all 0.5s ease';
            error.style.opacity = '0';
            error.style.transform = 'translateY(-20px)';
            setTimeout(() => error.parentElement?.remove(), 500);
        });
    }, 8000);

    // =========================
    // Show success after password reset (from session)
    // =========================
    @if (session('reset_success'))
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('forgotPasswordForm');
        const successDiv = document.getElementById('resetSuccessMessage');

        if (form) form.style.display = 'none';
        if (successDiv) successDiv.style.display = 'block';

        showNotification(
            'Pautan reset kata laluan telah dihantar ke email anda. Sila semak inbox atau folder spam anda.',
            'success'
        );
    });
    {{ session()->forget('reset_success') }}
    @endif

</script>

</body>
</html>