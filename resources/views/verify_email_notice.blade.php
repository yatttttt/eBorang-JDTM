<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - eBorang JDTM</title>
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

        .verification-container {
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

        .verification-box {
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

        .icon-container {
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeIn 0.6s ease-out 0.3s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .email-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3) 0%, rgba(37, 99, 235, 0.3) 100%);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 2px solid rgba(59, 130, 246, 0.4);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            color: #60a5fa;
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        .verification-title {
            color: #ffffff;
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
            letter-spacing: 1px;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            background: linear-gradient(135deg, #ffffff, #e0e7ff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .verification-message {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            line-height: 1.7;
            text-align: center;
            margin-bottom: 2rem;
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
            display: flex;
            align-items: center;
            gap: 0.75rem;
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

        .email-display {
            background: rgba(59, 130, 246, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 15px;
            padding: 1.2rem;
            text-align: center;
            margin-bottom: 2rem;
            animation: fadeInLeft 0.6s ease-out 0.5s both;
        }

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

        .email-address {
            color: #60a5fa;
            font-size: 1rem;
            font-weight: 600;
            word-break: break-all;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 193, 7, 0.3);
            border-left: 3px solid #fbbf24;
            padding: 1.25rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            animation: fadeInLeft 0.6s ease-out 0.7s both;
        }

        .info-box-title {
            color: #fbbf24;
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-box li {
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.85rem;
            padding: 0.5rem 0;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .info-box li i {
            color: #60a5fa;
            margin-top: 0.2rem;
            flex-shrink: 0;
        }

        .resend-section {
            text-align: center;
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 1.5rem;
            animation: fadeInUp 0.6s ease-out 0.9s both;
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

        .resend-text {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .resend-form {
            display: inline-block;
            width: 100%;
        }

        .resend-button {
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
        }

        .resend-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.6s ease;
        }

        .resend-button:hover:not(:disabled)::before {
            left: 100%;
        }

        .resend-button:hover:not(:disabled) {
            background: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(59, 130, 246, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            border-color: rgba(59, 130, 246, 0.6);
        }

        .resend-button:active:not(:disabled) {
            transform: translateY(-1px) scale(1.01);
        }

        .resend-button:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        .back-link {
            text-align: center;
            animation: fadeIn 0.6s ease-out 1.1s both;
        }

        .back-link a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.95rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: #60a5fa;
            background: rgba(255, 255, 255, 0.05);
            text-shadow: 0 0 10px rgba(96, 165, 250, 0.5);
        }

        @media (max-width: 640px) {
            body {
                padding: 1rem 0.75rem;
            }

            .verification-box {
                padding: 2rem 1.5rem;
            }

            .verification-title {
                font-size: 1.6rem;
            }

            .email-icon {
                width: 80px;
                height: 80px;
                font-size: 38px;
            }

            .logo-with-bg {
                width: 150px;
            }
        }

        @media (max-width: 480px) {
            .verification-box {
                padding: 1.5rem 1rem;
            }

            .verification-title {
                font-size: 1.4rem;
            }

            .logo-with-bg {
                width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="verification-container">
        <div class="logo-section">
            <img src='{{ asset('images/logo_JDTM.png') }}' alt='Logo JDTM' class="logo-with-bg">
        </div>
        
        <div class="verification-box">
            <div class="icon-container">
                <div class="email-icon">
                    <i class="fas fa-envelope-open-text"></i>
                </div>
            </div>

            <h2 class="verification-title">Sila Sahkan Email Anda</h2>
            
            <p class="verification-message">
                Email verifikasi telah dihantar ke alamat email anda. Sila semak inbox atau folder spam.
            </p>

            @if (session('status'))
                <div class="success-message">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <div class="email-display">
                <i class="fas fa-envelope" style="color: #60a5fa; margin-right: 0.5rem;"></i>
                <span class="email-address">{{ $email }}</span>
            </div>

            <div class="info-box">
                <div class="info-box-title">
                    <i class="fas fa-info-circle"></i>
                    Langkah Seterusnya
                </div>
                <ul>
                    <li>
                        <i class="fas fa-circle fa-xs"></i>
                        <span>Buka email dari <strong>eBorang JDTM</strong></span>
                    </li>
                    <li>
                        <i class="fas fa-circle fa-xs"></i>
                        <span>Klik pada pautan verifikasi</span>
                    </li>
                    <li>
                        <i class="fas fa-circle fa-xs"></i>
                        <span>Log masuk ke sistem selepas email disahkan</span>
                    </li>
                </ul>
            </div>

            <div class="resend-section">
                <p class="resend-text">Tidak menerima email?</p>
                <form method="POST" action="{{ route('verification.resend') }}" class="resend-form" id="resendForm">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" class="resend-button" id="resendButton">
                        <i class="fas fa-paper-plane"></i> Hantar Semula Email
                    </button>
                </form>
            </div>

            <div class="back-link">
                <a href="{{ url('/login') }}">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Log Masuk
                </a>
            </div>
        </div>
    </div>

    <script>
        // Handle resend form submission
        document.getElementById('resendForm').addEventListener('submit', function(e) {
            const button = document.getElementById('resendButton');
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghantar...';
            button.disabled = true;
        });

        // Auto-hide success message after 5 seconds
        setTimeout(function() {
            const successMessages = document.querySelectorAll('.success-message');
            successMessages.forEach(function(message) {
                message.style.transition = 'opacity 0.5s ease';
                message.style.opacity = '0';
                setTimeout(() => {
                    if (message.parentElement) {
                        message.remove();
                    }
                }, 500);
            });
        }, 5000);
    </script>
</body>
</html>