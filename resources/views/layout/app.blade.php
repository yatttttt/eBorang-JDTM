<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Eborang JDTM')</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-MBSAicon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/MBSAicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/MBSAicon-16x16.png') }}">
    <link rel="icon" type="image/ico" href="{{ asset('images/MBSAicon.ico') }}">
    <link rel="manifest" href="{{ asset('images/site.webmanifest') }}">

    {{-- Font Awesome untuk icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    {{-- Bootstrap Icons (untuk alert icons) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    @stack('styles')
    <style>
        body {
            background:linear-gradient(135deg, #003366 0%, #000000ff 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            margin: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Untuk modal (termasuk notification), kita hanya kunci scroll tanpa ubah layout/background */
        body.modal-open {
            overflow: hidden !important;
        }

       .sidebar {
            top: 0;
            left: 0;
            width: 70px;
            background: linear-gradient(180deg, rgba(0, 153, 255, 0.95) 0%, rgba(0, 51, 102, 0.98) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            color: #fff;
            display: flex;
            overflow: hidden;
            flex-direction: column;
            align-items: center;
            padding: 20px 10px 15px 10px;
            border-bottom-right-radius: 25px;
            border-top-right-radius: 25px;
            box-shadow: 
                0 10px 40px rgba(0, 0, 0, 0.3),
                inset -1px 0 0 rgba(255, 255, 255, 0.1);
            position: fixed;
            height: calc(100vh - 35px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 100;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar.expanded {
            width: 280px;
            padding: 20px 20px 20px 20px;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.4),
                inset -1px 0 0 rgba(255, 255, 255, 0.2);
        }

        /* Navigation container */
        .sidebar .nav-container {
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        /* User section at TOP */
        .sidebar .user-section {
            width: 100%;
            border-bottom: 1px solid rgba(255, 255, 255, 0.15);
            padding-bottom: 20px;
            margin-bottom: 20px;
            position: relative;
        }

        .sidebar .user-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        /* Main navigation section */
        .sidebar .main-nav {
            width: 100%;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            -webkit-overflow-scrolling: touch;
            /* scroll-behavior:smooth boleh buat rasa lag pada scroll, jadi kita kekalkan scroll native */
        }

        /* Custom scrollbar for navigation */
        .sidebar .main-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar .main-nav::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
        }

        .sidebar .main-nav::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .sidebar .main-nav::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Logout section at bottom */
        .sidebar .logout-section {
            width: 100%;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            padding-top: 15px;
            margin-top: auto;
            position: relative;
        }

        .sidebar .logout-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        }

        /* User info display with photo and name */
        .user-info {
            padding: 0;
            opacity: 0;
            transition: opacity 0.6s cubic-bezier(0.4, 0, 0.2, 1) 0.1s;
            margin-bottom: 0;
            display: none;
            flex-direction: column;
            align-items: center;
            gap: 0;
            position: relative;
        }

        .sidebar.expanded .user-info {
            display: flex;
            opacity: 1;
        }

        /* Collapsed state - show only icon */
        .user-icon-collapsed {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            margin: 0 auto 10px auto;
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 1;
        }

        .sidebar.expanded .user-icon-collapsed {
            display: none;
            opacity: 0;
        }

        /* User photo container with glow effect */
        .user-photo-container {
            position: relative;
            margin-bottom: 12px;
            animation: fadeInScale 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes fadeInScale {
            0% {
                opacity: 0;
                transform: scale(0.8);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .user-photo-wrapper {
            position: relative;
            width: 80px;
            height: 80px;
        }

        /* Animated ring around photo */
        .user-photo-wrapper::before {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border-radius: 50%;
            background: linear-gradient(45deg, #60a5fa, #a855f7, #ec4899, #60a5fa);
            background-size: 300% 300%;
            animation: gradientRotate 4s ease infinite;
            z-index: -1;
            opacity: 0.7;
        }

        @keyframes gradientRotate {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Pulsing glow effect */
        .user-photo-wrapper::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(96, 165, 250, 0.4) 0%, transparent 70%);
            animation: pulse 2s ease-in-out infinite;
            z-index: -2;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                opacity: 0.5;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.8;
            }
        }

        /* User photo styling */
        .user-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.9);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.4),
                inset 0 0 10px rgba(255, 255, 255, 0.2);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .user-photo:hover {
            transform: scale(1.08) rotate(3deg);
            border-color: #60a5fa;
            box-shadow: 
                0 12px 35px rgba(96, 165, 250, 0.6),
                inset 0 0 15px rgba(255, 255, 255, 0.3);
        }

        /* Placeholder for users without photo */
        .user-photo-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 3px solid rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 700;
            color: #ffffff;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
            box-shadow: 
                0 8px 25px rgba(0, 0, 0, 0.4),
                inset 0 0 10px rgba(255, 255, 255, 0.2);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            z-index: 1;
        }

        .user-photo-placeholder:hover {
            transform: scale(1.08) rotate(-3deg);
            border-color: #60a5fa;
            box-shadow: 
                0 12px 35px rgba(96, 165, 250, 0.6),
                inset 0 0 15px rgba(255, 255, 255, 0.3);
        }

        /* Collapsed icon styling */
        .user-icon-small {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-icon-small:hover {
            transform: scale(1.1);
            border-color: #60a5fa;
        }

        .user-placeholder-small {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: 2px solid rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            font-weight: 700;
            color: #ffffff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .user-placeholder-small:hover {
            transform: scale(1.1);
            border-color: #60a5fa;
        }

        /* Notification count badge on user icon when collapsed */
        .notification-count-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            background: #ef4444;
            color: #fff;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6);
            animation: pulse-badge 2s ease-in-out infinite;
            padding: 0 4px;
        }

        .notification-count-badge.hidden {
            display: none;
        }

        @keyframes pulse-badge {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6);
            }
            50% {
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(239, 68, 68, 0.8);
            }
        }

        /* User text info container */
        .user-text-info {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            width: 100%;
            padding: 0 10px;
            animation: fadeInUp 0.7s cubic-bezier(0.4, 0, 0.2, 1) 0.15s both;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(15px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .user-info .username {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.1rem;
            color: #ffffff;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
            max-width: 100%;
        }

        .user-info .role {
            font-size: 0.8rem;
            opacity: 0.9;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            max-width: 100%;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
            margin: 0;
        }

        .sidebar ul li {
            width: 100%;
            margin-bottom: 8px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar .logout-section ul li {
            margin-bottom: 0;
        }

        .sidebar ul li a {
            display: flex;
            align-items: center;
            padding: 12px 12px;
            color: #fff;
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
            font-size: 0;
            white-space: nowrap;
            overflow: hidden;
            position: relative;
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar ul li a::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(180deg, #60a5fa, #a855f7);
            opacity: 0;
            transition: opacity 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px 0 0 12px;
        }

        .sidebar.expanded ul li a {
            padding: 12px 15px;
            font-size: 0.95rem;
        }

       .sidebar ul li a:hover, .sidebar ul li a.active {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            transform: translateX(4px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .sidebar ul li a:hover::before, .sidebar ul li a.active::before {
            opacity: 1;
        }

        /* Special styling for logout button */
        .sidebar ul li a.logout-btn {
            color: #fca5a5;
            background: rgba(239, 68, 68, 0.1);
        }

        .sidebar ul li a.logout-btn:hover {
            background: rgba(239, 68, 68, 0.25);
            color: #fff;
        }

        .sidebar ul li a .icon {
            font-size: 20px;
            margin-right: 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
        }

        .sidebar.expanded ul li a .icon {
            margin-right: 12px;
        }

        .sidebar ul li a:hover .icon {
            transform: scale(1.08) rotate(5deg); 
        }

        /* Notification Bell Icon Styles */
        .notification-container {
            position: absolute;
            top: 5px;
            right: 10px;
            display: none;
        }

        .sidebar.expanded .notification-container {
            display: block;
        }

        .notification-bell {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            cursor: pointer;
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.1);
        }

        .notification-bell:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .notification-bell i {
            font-size: 18px;
            color: #fff;
            transition: all 0.3s ease;
        }

        .notification-bell:hover i {
            transform: scale(1.1);
            animation: bellRing 0.5s ease-in-out;
        }

        @keyframes bellRing {
            0%, 100% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            75% { transform: rotate(-15deg); }
        }

        .notification-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #ef4444;
            color: #fff;
            border-radius: 50%;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            font-weight: 700;
            border: 2px solid #0099ff;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.6);
            /* Buang animasi berulang untuk elak FPS drop bila ada banyak notifikasi belum dibaca */
            padding: 0 4px;
        }

        .notification-badge.hidden {
            display: none;
        }

        .notification-modal {
            display: none;
            position: fixed !important;
            inset: 0 !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            bottom: 0 !important;
            width: 100vw !important;
            height: 100vh !important;
            /* Kurangkan blur supaya scroll lebih ringan/smooth */
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 99999 !important;
            animation: fadeIn 0.3s ease;
            margin: 0 !important;
            padding: 0 !important;
        }

        .notification-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .notification-modal-content {
            background: #fff;
            border-radius: 20px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            /* Guna auto supaya browser urus flow scroll tanpa clip tambahan */
            overflow: auto;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.35);
            animation: slideUp 0.25s ease-out;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 100000;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .notification-modal-header {
            padding: 25px 30px;
            background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
            color: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .notification-modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .notification-modal-header h2 i {
            font-size: 1.3rem;
        }

        .notification-modal-header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .notification-mark-all-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            padding: 8px 16px;
            border-radius: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .notification-mark-all-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .notification-mark-all-btn i {
            font-size: 0.95rem;
        }

        .notification-mark-all-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .notification-mark-all-btn:disabled:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: none;
            box-shadow: none;
        }

        .notification-modal-close {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .notification-modal-close:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: rotate(90deg);
        }

        .notification-modal-body {
            padding: 0;
            overflow-y: auto;
            max-height: calc(80vh - 110px);
            -webkit-overflow-scrolling: touch;
        }

        .notification-modal-body::-webkit-scrollbar {
            width: 8px;
        }

        .notification-modal-body::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .notification-modal-body::-webkit-scrollbar-thumb {
            background: rgba(185, 185, 185, 1);
            border-radius: 10px;
        }

        .notification-modal-body::-webkit-scrollbar-thumb:hover {
            background: rgba(170, 168, 168, 1);
        }

        .notification-modal-item {
            padding: 20px 30px;
            border-bottom: 1px solid #f3f4f6;
            cursor: pointer;
            /* Hanya animasikan warna untuk kurangkan kerja layout semasa hover */
            transition: background-color 0.2s ease;
            text-decoration: none;
            display: block;
            color: #1f2937;
        }

        .notification-modal-item:hover {
            background: #f9fafb;
        }

        .notification-modal-item:last-child {
            border-bottom: none;
        }

        .notification-modal-item.unread {
            background: linear-gradient(90deg, #eff6ff 0%, #fff 100%);
            border-left: 4px solid #3b82f6;  
        }

        .notification-modal-item.unread:hover {
            background: linear-gradient(90deg, #dbeafe 0%, #f9fafb 100%);  /* ✅ FIXED */
        }

        .notification-modal-item-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 8px;
        }

        .notification-modal-item-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .notification-modal-item-icon.success {
            background: linear-gradient(135deg, #10b981, #34d399);
            color: #fff;
        }

        .notification-modal-item-icon.warning {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            color: #fff;
        }

        .notification-modal-item-icon.info {
            background: linear-gradient(135deg, #3b82f6, #60a5fa);
            color: #fff;
        }

        .notification-modal-item-icon.danger {
            background: linear-gradient(135deg, #ef4444, #f87171);
            color: #fff;
        }

        .notification-modal-item-title {
            font-size: 1rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notification-modal-item-title .unread-dot {
            width: 8px;
            height: 8px;
            background: #3b82f6;
            border-radius: 50%;
        }

        .notification-modal-item-message {
            font-size: 0.9rem;
            color: #6b7280;
            margin-bottom: 8px;
            line-height: 1.5;
            padding-left: 52px;
        }

        .notification-modal-item-time {
            font-size: 0.8rem;
            color: #9ca3af;
            display: flex;
            align-items: center;
            gap: 6px;
            padding-left: 52px;
        }

        .notification-modal-item-time i {
            font-size: 0.75rem;
        }

        .notification-modal-empty {
            padding: 60px 30px;
            text-align: center;
            color: #9ca3af;
        }

        .notification-modal-empty i {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
            opacity: 0.3;
        }

        .notification-modal-empty p {
            font-size: 1.1rem;
            margin: 0;
        }

        .main-content {
            margin-left: 70px;
            padding: 40px 24px;
            width: 100%;
            transition: margin-left 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar.expanded ~ .main-content {
            margin-left: 280px;
        }

        @media (max-width: 768px) {
            .sidebar, .sidebar.expanded {
                width: 60px;
                padding: 15px 8px;
            }
            .sidebar ul li a, .sidebar.expanded ul li a {
                padding: 10px 8px;
                font-size: 0;
            }
            .sidebar ul li a .icon, .sidebar.expanded ul li a .icon {
                font-size: 18px;
                margin-right: 0;
            }
            .main-content, .sidebar.expanded ~ .main-content {
                margin-left: 60px;
                padding: 20px 12px;
            }
            .user-info {
                display: none !important;
            }
            .notification-modal-content {
                width: 95%;
                max-height: 90vh;
            }
            .notification-modal-header {
                padding: 20px;
            }
            .notification-modal-item {
                padding: 15px 20px;
            }
            .notification-modal-item-message,
            .notification-modal-item-time {
                padding-left: 42px;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar" id="sidebar">
        <!-- User Section at TOP -->
        <div class="user-section">
            <!-- Collapsed state - show small icon with notification count -->
            <div class="user-icon-collapsed">
                @if(auth()->user()->gambar_profil)
                    <div style="position: relative;">
                        <img src="{{ asset('storage/' . auth()->user()->gambar_profil) }}" 
                             alt="{{ auth()->user()->nama }}" 
                             class="user-icon-small"
                             title="{{ auth()->user()->nama }}"
                             onclick="openNotificationModal()">
                        <span class="notification-count-badge hidden" id="collapsedNotificationBadge">0</span>
                    </div>
                @else
                    <div style="position: relative;">
                        <div class="user-placeholder-small" title="{{ auth()->user()->nama }}" onclick="openNotificationModal()">
                            {{ strtoupper(substr(auth()->user()->nama ?? 'G', 0, 1)) }}
                        </div>
                        <span class="notification-count-badge hidden" id="collapsedNotificationBadge">0</span>
                    </div>
                @endif
            </div>
            
            <!-- Expanded state - show full user info -->
            <div class="user-info">
                <!-- Notification Bell Icon at top right when expanded -->
                <div class="notification-container">
                    <div class="notification-bell" id="notificationBell" title="Notifikasi" onclick="openNotificationModal()">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge hidden" id="notificationBadge">0</span>
                    </div>
                </div>

                <div class="user-photo-container">
                    <div class="user-photo-wrapper">
                        @if(auth()->user()->gambar_profil)
                            <img src="{{ asset('storage/' . auth()->user()->gambar_profil) }}" 
                                 alt="{{ auth()->user()->nama }}" 
                                 class="user-photo"
                                 title="{{ auth()->user()->nama }}">
                        @else
                            <div class="user-photo-placeholder" title="{{ auth()->user()->nama }}">
                                {{ strtoupper(substr(auth()->user()->nama ?? 'G', 0, 1)) }}
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="user-text-info">
                    <div class="username">{{ auth()->user()->nama ?? 'Guest User' }}</div>
                    <div class="role">{{ auth()->user()->peranan_formatted }}</div>
                </div>
            </div>
        </div>
        
        <!-- Main Navigation -->
        <nav class="main-nav">
            <ul>
                @if(Auth::user())
                    @php $user = Auth::user(); @endphp
                    
                    @if($user->peranan === 'admin')
                        <li>
                            <a href="{{ route('dashboard.admin') }}" class="{{ request()->routeIs('dashboard.admin') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-home"></i></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('permohonans.create') }}" class="{{ request()->routeIs('permohonans.create') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-upload"></i></span>
                                Muat Naik Permohonan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.senarai_permohonan') }}" class="{{ request()->routeIs('admin.senarai_permohonan') || request()->routeIs('permohonans.show') || request()->routeIs('permohonans.edit') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-list"></i></span>
                                Senarai Permohonan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.senarai_permohonan_lama') }}" class="{{ request()->routeIs('admin.senarai_permohonan_lama') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-archive"></i></span>
                                Senarai Permohonan Lama
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pengurusan-pengguna') }}" class="{{ Request::is('pengurusan-pengguna*') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-users"></i></span>
                                Pengurusan Pengguna
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.log-aktiviti') }}" class="{{ request()->routeIs('admin.log-aktiviti') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-history"></i></span>
                                Log Aktiviti
                            </a>
                        </li>
                    
                    @elseif($user->peranan === 'pegawai')
                        <li>
                            <a href="{{ route('dashboard.pegawai') }}" class="{{ request()->routeIs('dashboard.pegawai') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-home"></i></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai.senarai-permohonan') }}" class="{{ request()->routeIs('pegawai.senarai-permohonan') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-list"></i></span>
                                Senarai Permohonan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pegawai.permohonan.lama') }}" class="{{ request()->routeIs('pegawai.permohonan.lama') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-archive"></i></span>
                                Senarai Permohonan Lama
                            </a>
                        </li>
                    
                    @elseif($user->peranan === 'pengarah')
                        <li>
                            <a href="{{ route('dashboard.pengarah') }}" class="{{ request()->routeIs('dashboard.pengarah') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-home"></i></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengarah.senarai-permohonan') }}" class="{{ request()->routeIs('pengarah.senarai-permohonan') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-list"></i></span>
                                Senarai Permohonan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pengarah.permohonan.lama') }}" class="{{ request()->routeIs('pengarah.permohonan.lama') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-archive"></i></span>
                                Senarai Permohonan Lama
                            </a>
                        </li>
                    
                    @elseif($user->peranan === 'pentadbir_sistem')
                        <li>
                            <a href="{{ route('dashboard.pentadbir_sistem') }}" class="{{ request()->routeIs('dashboard.pentadbir_sistem') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-home"></i></span>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pentadbir_sistem.senarai-permohonan') }}" class="{{ request()->routeIs('pentadbir_sistem.senarai-permohonan') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-list"></i></span>
                                Senarai Permohonan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pentadbir_sistem.permohonan.lama') }}" class="{{ request()->routeIs('pentadbir_sistem.permohonan.lama') ? 'active' : '' }}">
                                <span class="icon"><i class="fas fa-archive"></i></span>
                                Senarai Permohonan Lama
                            </a>
                        </li>
                    @endif
                @endif
            </ul>
        </nav>
            
        <!-- Logout Section at BOTTOM -->
        <div class="logout-section">
            <ul>
                <li>
                    <a href="{{ route('profile.edit') }}" class="{{ Request::is('profile*') ? 'active' : '' }}">
                        <span class="icon"><i class="fas fa-user-edit"></i></span>
                        Edit Profil
                    </a>
                </li>
                <li>
                    <a href="#" class="logout-btn">
                        <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
                        Log Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Notification Modal -->
    <div class="notification-modal" id="notificationModal">
        <div class="notification-modal-content">
            <div class="notification-modal-header">
                <h2>
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                </h2>
                <div class="notification-modal-header-actions">
                    <button class="notification-mark-all-btn" id="markAllBtn" onclick="markAllAsRead()" title="Tandakan semua sebagai dibaca">
                        <i class="fas fa-check-double"></i>
                        <span>Tandakan Dibaca</span>
                    </button>
                    <button class="notification-modal-close" onclick="closeNotificationModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="notification-modal-body" id="notificationModalList">
                <div class="notification-modal-empty">
                    <i class="fas fa-bell-slash"></i>
                    <p>Tiada notifikasi</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        @yield('content')
    </div>
    
    <!-- Include Vite assets for Echo/Pusher -->
    @vite(['resources/js/app.js', 'resources/js/bootstrap.js'])
    
    <script>
        const sidebar = document.getElementById('sidebar');
        
        sidebar.addEventListener('mouseenter', () => {
            sidebar.classList.add('expanded');
        });
        
        sidebar.addEventListener('mouseleave', () => {
            sidebar.classList.remove('expanded');
        });
        
        document.querySelector('.logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Adakah anda pasti mahu log keluar?')) {
                document.getElementById('logout-form').submit();
            }
        });

        // Modal Functions
        function openNotificationModal() {
            const modal = document.getElementById('notificationModal');
            document.body.classList.add('modal-open');
            
            modal.classList.add('show');
            
            if (window.notificationSystem && window.notificationSystem.unreadCount > 0) {
                window.notificationSystem.markAsRead();
            }
        }

        function closeNotificationModal() {
            const modal = document.getElementById('notificationModal');
            modal.classList.remove('show');
            
            document.body.classList.remove('modal-open');
        }

        // Close modal when clicking outside
        document.getElementById('notificationModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeNotificationModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeNotificationModal();
            }
        });
    </script>

    <!-- Notification System JavaScript -->
    <script>
        // Notification System
        window.notificationSystem = (function() {
            const notificationBadge = document.getElementById('notificationBadge');
            const collapsedNotificationBadge = document.getElementById('collapsedNotificationBadge');
            const notificationModalList = document.getElementById('notificationModalList');
            
            let notifications = [];
            let unreadCount = 0;

            // Fetch notifications from server
            async function fetchNotifications() {
                try {
                    const response = await fetch('{{ route("notifications.index") }}', {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch notifications');
                    }

                    const data = await response.json();
                    notifications = data.notifications || [];
                    unreadCount = data.unread_count || 0;
                    
                    updateBadge();
                    renderNotifications();
                } catch (error) {
                    console.error('Error fetching notifications:', error);
                }
            }

            // Update badge count
            function updateBadge() {
                const markAllBtn = document.getElementById('markAllBtn');
                
                if (unreadCount > 0) {
                    const displayCount = unreadCount > 99 ? '99+' : unreadCount;
                    notificationBadge.textContent = displayCount;
                    notificationBadge.classList.remove('hidden');
                    collapsedNotificationBadge.textContent = displayCount;
                    collapsedNotificationBadge.classList.remove('hidden');
                    
                    // Enable "Mark All" button
                    if (markAllBtn) {
                        markAllBtn.disabled = false;
                    }
                } else {
                    notificationBadge.classList.add('hidden');
                    collapsedNotificationBadge.classList.add('hidden');
                    
                    // Disable "Mark All" button
                    if (markAllBtn) {
                        markAllBtn.disabled = true;
                    }
                }
            }

            // Get icon class based on notification type
            function getNotificationIcon(type) {
                const icons = {
                    'status_update': { class: 'info', icon: 'fa-info-circle' },
                    'permohonan_lulus': { class: 'success', icon: 'fa-check-circle' },
                    'permohonan_tolak': { class: 'danger', icon: 'fa-times-circle' },
                    'permohonan_dihantar': { class: 'info', icon: 'fa-paper-plane' },
                    'permohonan_dikemas_kini': { class: 'warning', icon: 'fa-edit' },
                    'default': { class: 'info', icon: 'fa-bell' }
                };
                
                return icons[type] || icons.default;
            }

            // Render notifications in modal
            function renderNotifications() {
                if (notifications.length === 0) {
                    notificationModalList.innerHTML = `
                        <div class="notification-modal-empty">
                            <i class="fas fa-bell-slash"></i>
                            <p>Tiada notifikasi</p>
                        </div>
                    `;
                    return;
                }

                notificationModalList.innerHTML = notifications.map(notif => {
                    const isRead = notif.is_read;
                    const permohonanUrl = getPermohonanUrl(notif.permohonan_id);
                    const iconData = getNotificationIcon(notif.type);
                    
                    return `
                        <a href="#" 
                           class="notification-modal-item ${!isRead ? 'unread' : ''}" 
                           data-id="${notif.id}"
                           data-permohonan-id="${notif.permohonan_id}"
                           data-url="${permohonanUrl}"
                           onclick="handleNotificationClick(event, '${notif.id}', '${permohonanUrl}')">
                            <div class="notification-modal-item-header">
                                <div class="notification-modal-item-icon ${iconData.class}">
                                    <i class="fas ${iconData.icon}"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div class="notification-modal-item-title">
                                        ${!isRead ? '<span class="unread-dot"></span>' : ''}
                                        ${escapeHtml(notif.title)}
                                    </div>
                                </div>
                            </div>
                            <div class="notification-modal-item-message">${escapeHtml(notif.message)}</div>
                            <div class="notification-modal-item-time">
                                <i class="fas fa-clock"></i>
                                ${notif.created_at}
                            </div>
                        </a>
                    `;
                }).join('');
            }

            // Get permohonan URL based on user role and status
            function getPermohonanUrl(permohonanId) {
                const userRole = '{{ auth()->user()->peranan }}';
                
                // Find the notification to get its status
                const notification = notifications.find(n => n.permohonan_id === permohonanId);
                const status = notification ? notification.status : null;
                
                // DEBUG: Log status untuk troubleshooting
                console.log('🔍 Notification Debug:', {
                    permohonanId: permohonanId,
                    userRole: userRole,
                    status: status,
                    notification: notification
                });
                
                // Normalize status for comparison (case-insensitive, trim whitespace)
                const normalizedStatus = status ? status.toLowerCase().trim() : '';
                
                // Determine if user should go to edit or show based on status
                let route;
                
                if (userRole === 'admin') {
                    // Admin always goes to show
                    route = '{{ route("permohonans.show", ":id") }}';
                    console.log('✅ Admin → show');
                } else if (userRole === 'pengarah') {
                    // Pengarah: check if status contains "lulus" + "pengarah"
                    const isApproved = normalizedStatus.includes('lulus') && normalizedStatus.includes('pengarah');
                    
                    if (isApproved) {
                        route = '{{ route("pengarah.permohonan.show", ":id") }}';
                        console.log('✅ Pengarah (Lulus) → show');
                    } else {
                        route = '{{ route("pengarah.permohonan.edit", ":id") }}';
                        console.log('⚠️ Pengarah (Not Lulus) → edit, Status:', status);
                    }
                } else if (userRole === 'pegawai') {
                    // Pegawai: check if status contains "lulus" + "pegawai"
                    const isApproved = normalizedStatus.includes('lulus') && normalizedStatus.includes('pegawai');
                    
                    if (isApproved) {
                        route = '{{ route("pegawai.permohonan.show", ":id") }}';
                        console.log('✅ Pegawai (Lulus) → show');
                    } else {
                        route = '{{ route("pegawai.permohonan.edit", ":id") }}';
                        console.log('⚠️ Pegawai (Not Lulus) → edit, Status:', status);
                    }
                } else if (userRole === 'pentadbir_sistem') {
                    // Pentadbir Sistem: check if status contains "lulus" + ("pentadbir" or "sistem")
                    const isApproved = normalizedStatus.includes('lulus') && 
                                      (normalizedStatus.includes('pentadbir') || normalizedStatus.includes('sistem'));
                    
                    if (isApproved) {
                        route = '{{ route("pentadbir_sistem.permohonan.show", ":id") }}';
                        console.log('✅ Pentadbir Sistem (Lulus) → show');
                    } else {
                        route = '{{ route("pentadbir_sistem.permohonan.edit", ":id") }}';
                        console.log('⚠️ Pentadbir Sistem (Not Lulus) → edit, Status:', status);
                    }
                } else {
                    // Default fallback
                    route = '{{ route("permohonans.show", ":id") }}';
                    console.log('⚠️ Unknown role → show');
                }
                
                console.log('🎯 Final Route:', route);
                return route.replace(':id', permohonanId);
            }

            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Mark all notifications as read
            async function markAsRead() {
                try {
                    const response = await fetch('{{ route("notifications.markAsRead") }}', {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error('Failed to mark notifications as read');
                    }

                    unreadCount = 0;
                    updateBadge();
                    
                    notifications.forEach(notif => {
                        notif.is_read = true;
                    });
                    renderNotifications();
                } catch (error) {
                    console.error('Error marking notifications as read:', error);
                }
            }

            // Mark single notification as read
            async function markSingleAsRead(notificationId) {
                try {
                    const response = await fetch(`/notifications/${notificationId}/mark-as-read`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    if (!response.ok) {
                        throw new Error('Failed to mark notification as read');
                    }

                    // Update the specific notification in local array
                    const notifIndex = notifications.findIndex(n => n.id === notificationId);
                    if (notifIndex !== -1 && !notifications[notifIndex].is_read) {
                        notifications[notifIndex].is_read = true;
                        unreadCount = Math.max(0, unreadCount - 1);
                        updateBadge();
                        renderNotifications();
                    }
                } catch (error) {
                    console.error('Error marking notification as read:', error);
                }
            }

            // Initialize: Fetch notifications on page load
            fetchNotifications();

            // Refresh notifications every 30 seconds
            setInterval(fetchNotifications, 30000);

            // Real-time updates via Laravel Echo
            if (window.Echo) {
                const userId = {{ auth()->user()->id_user }};
                
                window.Echo.private(`App.Models.User.${userId}`)
                    .notification((notification) => {
                        console.log('New notification received:', notification);
                        
                        notifications.unshift({
                            id: notification.id,
                            type: notification.data.type || 'unknown',
                            title: notification.data.title || 'Notifikasi',
                            message: notification.data.message || '',
                            permohonan_id: notification.data.permohonan_id || null,
                            status: notification.data.status || null,  // ADD status from notification
                            read_at: null,
                            created_at: 'Baru sahaja',
                            is_read: false
                        });
                        
                        unreadCount++;
                        updateBadge();
                        renderNotifications();
                    });
            }

            // Return public methods
            return {
                markAsRead,
                markSingleAsRead,
                fetchNotifications,
                unreadCount: () => unreadCount
            };
        })();

        // Handle notification click - mark as read and navigate
        async function handleNotificationClick(event, notificationId, url) {
            event.preventDefault();
            
            console.log('Notification clicked:', notificationId);
            
            // Mark this notification as read
            await window.notificationSystem.markSingleAsRead(notificationId);
            
            // Navigate to the URL
            window.location.href = url;
        }

        // Mark all notifications as read
        async function markAllAsRead() {
            // Check if there are unread notifications
            if (window.notificationSystem.unreadCount() === 0) {
                return;
            }

            // Confirm action
            if (!confirm('Tandakan semua notifikasi sebagai dibaca?')) {
                return;
            }

            // Show loading state
            const markAllBtn = document.getElementById('markAllBtn');
            const originalContent = markAllBtn.innerHTML;
            markAllBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Menandakan...</span>';
            markAllBtn.disabled = true;

            try {
                // Call the mark all as read function
                await window.notificationSystem.markAsRead();
                
                // Success feedback
                markAllBtn.innerHTML = '<i class="fas fa-check"></i> <span>Berjaya!</span>';
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    markAllBtn.innerHTML = originalContent;
                }, 2000);
            } catch (error) {
                console.error('Error marking all as read:', error);
                
                // Error feedback
                markAllBtn.innerHTML = '<i class="fas fa-times"></i> <span>Gagal</span>';
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    markAllBtn.innerHTML = originalContent;
                    markAllBtn.disabled = false;
                }, 2000);
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>