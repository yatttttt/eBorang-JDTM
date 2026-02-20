<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Laluan - eBorang JDTM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            overflow-y: auto;
            height: auto;
        }

        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            overflow-y: auto;
            position: relative;
        }

        .reset-container {
            max-width: 500px;
            margin: 0 auto;
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

        .logo-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-with-bg {
            width: 200px;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
            transition: all 0.3s ease;
        }

        .reset-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 3rem 2.5rem;
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }

        .reset-header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.6s ease-out 0.3s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .reset-title {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .reset-subtitle {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .form-section {
            margin-bottom: 1.5rem;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
            animation: fadeInLeft 0.6s ease-out both;
        }

        .form-group:nth-child(1) { animation-delay: 0.5s; }
        .form-group:nth-child(2) { animation-delay: 0.7s; }
        .form-group:nth-child(3) { animation-delay: 0.9s; }

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

        .form-label {
            display: block;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            padding-left: 0.25rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.2rem;
            padding-right: 3rem;
            font-size: 0.95rem;
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

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }

        .form-input:focus {
            outline: none;
            border-color: rgba(59, 130, 246, 0.6);
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 
                0 0 0 4px rgba(59, 130, 246, 0.1),
                0 8px 25px rgba(0, 0, 0, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .form-input[readonly] {
            background: rgba(255, 255, 255, 0.05);
            cursor: not-allowed;
            opacity: 0.7;
        }

        .form-group:hover .form-input:not([readonly]) {
            border-color: rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.15);
        }

        .input-icon {
            position: absolute;
            right: 1rem;
            top: 2.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-size: 1rem;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-input:focus ~ .input-icon {
            color: #60a5fa;
            transform: scale(1.1);
        }

        .password-toggle {
            position: absolute;
            right: 0.75rem;
            top: 2.4rem;
            background: none;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 50%;
            transition: all 0.3s ease;
            z-index: 10;
        }

        .password-toggle:hover {
            color: #60a5fa;
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.1);
        }

        .password-strength {
            margin-top: 0.75rem;
            display: none;
            animation: fadeIn 0.3s ease-out;
        }

        .strength-bar {
            height: 4px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
            overflow: hidden;
            margin-bottom: 0.5rem;
        }

        .strength-bar-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak { background: #ef4444; width: 33%; }
        .strength-medium { background: #f59e0b; width: 66%; }
        .strength-strong { background: #22c55e; width: 100%; }

        .strength-text {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .requirements-box {
            background: rgba(59, 130, 246, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1.5rem;
            animation: fadeIn 0.6s ease-out 1s both;
        }

        .requirements-title {
            color: #93c5fd;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .requirements-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .requirements-list li {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.8rem;
            padding: 0.4rem 0;
            display: flex;
            align-items: center;
            gap: 0.6rem;
            transition: all 0.2s ease;
        }

        .requirements-list li i {
            font-size: 0.65rem;
            width: 14px;
            text-align: center;
        }

        .requirements-list li.valid {
            color: #4ade80;
        }

        .requirements-list li.valid i {
            color: #4ade80;
        }

        .requirements-list li.invalid i {
            color: rgba(255, 255, 255, 0.3);
        }

        .reset-button {
            width: 100%;
            background: rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(59, 130, 246, 0.4);
            padding: 1.2rem;
            color: #60a5fa;
            font-weight: 700;
            font-size: 1rem;
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

        .reset-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }

        .reset-button:hover:not(:disabled)::before {
            left: 100%;
        }

        .reset-button:hover:not(:disabled) {
            background: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(59, 130, 246, 0.6);
        }

        .reset-button:active:not(:disabled) {
            transform: translateY(-1px) scale(1.01);
        }

        .reset-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
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

        .back-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            animation: fadeIn 0.6s ease-out 1.3s both;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }

        .back-link a:hover {
            color: #60a5fa;
            background: rgba(255, 255, 255, 0.05);
            text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
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

        @media (max-width: 640px) {
            body {
                padding: 1rem 0.75rem;
            }

            .reset-box {
                padding: 2rem 1.5rem;
            }

            .reset-title {
                font-size: 1.6rem;
            }

            .logo-with-bg {
                width: 150px;
            }
        }

        @media (max-width: 480px) {
            .reset-box {
                padding: 1.5rem 1rem;
            }

            .reset-title {
                font-size: 1.4rem;
            }

            .logo-with-bg {
                width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="logo-section">
            <img src='{{ asset('images/logo_JDTM.png') }}' alt='Logo JDTM' class="logo-with-bg">
        </div>
        
        <div class="reset-box">
            <div class="reset-header">
                <h2 class="reset-title">Reset Kata Laluan</h2>
                <p class="reset-subtitle">Masukkan kata laluan baharu anda</p>
            </div>
            
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
            
            <form method="POST" action="{{ route('password.update') }}" id="resetForm">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                
                <div class="form-section">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-envelope"></i> Email
                        </label>
                        <input type="email" 
                               name="email" 
                               value="{{ $email ?? old('email') }}" 
                               class="form-input"
                               required 
                               readonly
                               autocomplete="email">
                        <i class="input-icon fas fa-lock"></i>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-key"></i> Kata Laluan Baharu
                        </label>
                        <input type="password" 
                               name="kata_laluan" 
                               class="form-input"
                               required 
                               autocomplete="new-password"
                               id="passwordInput"
                               placeholder="Masukkan kata laluan baharu"
                               onkeyup="checkPasswordStrength()">
                        <button type="button" class="password-toggle" onclick="togglePassword('passwordInput', 'passwordToggleIcon')">
                            <i class="fas fa-eye" id="passwordToggleIcon"></i>
                        </button>
                    </div>

                    <div class="password-strength" id="passwordStrength">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strengthBar"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-check-circle"></i> Sahkan Kata Laluan
                        </label>
                        <input type="password" 
                               name="kata_laluan_confirmation" 
                               class="form-input"
                               required 
                               autocomplete="new-password"
                               id="confirmPasswordInput"
                               placeholder="Masukkan semula kata laluan"
                               onkeyup="checkPasswordMatch()">
                        <button type="button" class="password-toggle" onclick="togglePassword('confirmPasswordInput', 'confirmToggleIcon')">
                            <i class="fas fa-eye" id="confirmToggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="requirements-box">
                    <div class="requirements-title">
                        <i class="fas fa-shield-alt"></i>
                        Keperluan Kata Laluan
                    </div>
                    <ul class="requirements-list">
                        <li id="req-length" class="invalid">
                            <i class="fas fa-circle"></i>
                            Sekurang-kurangnya 6 aksara
                        </li>
                        <li id="req-match" class="invalid">
                            <i class="fas fa-circle"></i>
                            Kata laluan sepadan
                        </li>
                    </ul>
                </div>
                
                <button type="submit" class="reset-button" id="resetButton" disabled>
                    <i class="fas fa-key"></i> Reset Kata Laluan
                </button>

                <div class="back-link">
                    <a href="{{ url('/login') }}">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Log Masuk
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
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

        function checkPasswordStrength() {
            const password = document.getElementById('passwordInput').value;
            const strengthDiv = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const lengthReq = document.getElementById('req-length');

            if (password.length === 0) {
                strengthDiv.style.display = 'none';
                lengthReq.classList.remove('valid');
                lengthReq.classList.add('invalid');
                lengthReq.querySelector('i').className = 'fas fa-circle';
                checkFormValidity();
                return;
            }

            strengthDiv.style.display = 'block';

            if (password.length >= 6) {
                lengthReq.classList.remove('invalid');
                lengthReq.classList.add('valid');
                lengthReq.querySelector('i').className = 'fas fa-check-circle';
            } else {
                lengthReq.classList.remove('valid');
                lengthReq.classList.add('invalid');
                lengthReq.querySelector('i').className = 'fas fa-circle';
            }

            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            strengthBar.className = 'strength-bar-fill';
            if (strength <= 2) {
                strengthBar.classList.add('strength-weak');
                strengthText.textContent = 'Kekuatan: Lemah';
                strengthText.style.color = '#ef4444';
            } else if (strength <= 3) {
                strengthBar.classList.add('strength-medium');
                strengthText.textContent = 'Kekuatan: Sederhana';
                strengthText.style.color = '#f59e0b';
            } else {
                strengthBar.classList.add('strength-strong');
                strengthText.textContent = 'Kekuatan: Kuat';
                strengthText.style.color = '#22c55e';
            }

            checkPasswordMatch();
        }

        function checkPasswordMatch() {
            const password = document.getElementById('passwordInput').value;
            const confirmPassword = document.getElementById('confirmPasswordInput').value;
            const matchReq = document.getElementById('req-match');

            if (confirmPassword.length === 0) {
                matchReq.classList.remove('valid');
                matchReq.classList.add('invalid');
                matchReq.querySelector('i').className = 'fas fa-circle';
                checkFormValidity();
                return;
            }

            if (password === confirmPassword && password.length > 0) {
                matchReq.classList.remove('invalid');
                matchReq.classList.add('valid');
                matchReq.querySelector('i').className = 'fas fa-check-circle';
            } else {
                matchReq.classList.remove('valid');
                matchReq.classList.add('invalid');
                matchReq.querySelector('i').className = 'fas fa-times-circle';
            }

            checkFormValidity();
        }

        function checkFormValidity() {
            const password = document.getElementById('passwordInput').value;
            const confirmPassword = document.getElementById('confirmPasswordInput').value;
            const resetButton = document.getElementById('resetButton');

            const isValid = password.length >= 6 && 
                          password === confirmPassword && 
                          confirmPassword.length > 0;

            resetButton.disabled = !isValid;
        }

        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const resetButton = document.getElementById('resetButton');
            const password = document.getElementById('passwordInput').value;
            const confirmPassword = document.getElementById('confirmPasswordInput').value;

            if (password.length < 6) {
                e.preventDefault();
                alert('Kata laluan mestilah sekurang-kurangnya 6 aksara.');
                return;
            }

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Kata laluan tidak sepadan.');
                return;
            }

            resetButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            resetButton.disabled = true;
        });

        setTimeout(function() {
            const errorMessages = document.querySelectorAll('.error-message');
            errorMessages.forEach(function(error) {
                error.style.transition = 'all 0.5s ease';
                error.style.opacity = '0';
                error.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (error.parentElement) {
                        error.parentElement.remove();
                    }
                }, 500);
            });
        }, 8000);
    </script>
</body>
</html>