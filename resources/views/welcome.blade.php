<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eBorang JDTM</title>
    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        .animation-bg {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
        }
        
        .logo-animation {
            animation: fadeInLogo 2s cubic-bezier(.68,-0.55,.27,1.55);
            width: 320px;
            max-width: 80vw;
            opacity: 1;
            transition: opacity 0.8s ease;
        }

        .fade-out {
            opacity: 0 !important;
        }
        
        @keyframes fadeInLogo {
            0% { opacity: 0; transform: scale(0.7) rotate(-10deg); }
            60% { opacity: 1; transform: scale(1.1) rotate(5deg); }
            100% { opacity: 1; transform: scale(1) rotate(0deg); }
        }
    </style>
</head>
<body>
    <div class="animation-bg">
        <img src="{{ asset('images/logo_mbsa.png') }}" alt="Majlis Bandaraya Shah Alam Logo" class="logo-animation">
    </div>

    <script>

        // Fade out logo before redirect
        setTimeout(function() {
            var logo = document.querySelector('.logo-animation');
            if (logo) {
                logo.classList.add('fade-out');
            }
            setTimeout(function() {
                window.location.href = "{{ url('/login') }}";
            }, 800); 
        }, 1800); 
    </script>
</body>
</html>
