<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maklumat Permohonan</title>
    
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
            max-width: 1200px;
            margin: 0 auto;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: 15px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            animation: slideInDown 0.5s ease;
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

        .alert i {
            font-size: 1.2rem;
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
            overflow: visible !important;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
            z-index: 100;
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

        /* Dropdown Styles */
        .admin-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-toggle {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            background: #0099FF;
            backdrop-filter: blur(10px);
            border: 1px solid #0099FF;
            border-radius: 15px;
            color: #e0e7ff;
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(139, 92, 246, 0.2);
        }

        .dropdown-toggle:hover {
            background: #0099FF;
            transform: translateY(-2px);
            color: #ffffff;
        }

        .dropdown-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(30, 30, 50, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 0.5rem 0;
            min-width: 200px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.25rem;
            color: #e2e8f0;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-size: 0.95rem;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .dropdown-item i {
            font-size: 1rem;
            width: 20px;
        }

        .dropdown-item.edit-item:hover {
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
        }

        .dropdown-item.delete-item:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
        }

        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }

        .detail-card {
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
            position: relative;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
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

         .info-value:hover {
            background: rgba(255, 255, 255, 0.08);
            transition: background 0.2s ease;
        }

         .info-value.info-value-status {
            color: #ffffff;
            font-size: 1.1rem;
            font-weight: 500;
            padding: 0.4rem 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .status-selesai, .status-lulus, .status-diluluskan {
            background: rgba(34, 197, 94, 0.3);
            color: #22c55e;
            border: 1px solid rgba(34, 197, 94, 0.4);
        }

        .status-ditolak, .status-tolak {
            background: rgba(239, 68, 68, 0.3);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.4);
        }

        .status-kiv {
            background: rgba(251, 191, 36, 0.3);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.4);
        }

        .status-pending {
            background: rgba(148, 163, 184, 0.3);
            color: #94a3b8;
            border: 1px solid rgba(148, 163, 184, 0.4);
        }

        .comment-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .comment-role {
            color: #60a5fa;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .comment-date {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        .comment-content {
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.6;
            font-size: 1rem;
        }

        .no-comment {
            color: rgba(255, 255, 255, 0.5);
            font-style: italic;
            text-align: center;
            padding: 2rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .action-btn {
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

        .action-btn:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            background: rgba(100, 116, 139, 0.4);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 
                0 8px 25px rgba(100, 116, 139, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            color: #e2e8f0;
            border-color: rgba(100, 116, 139, 0.6);
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

        .btn-primary {
            background: rgba(59, 130, 246, 0.3);
            border-color: rgba(59, 130, 246, 0.4);
            color: #60a5fa;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        }

        .btn-primary:hover {
            background: rgba(59, 130, 246, 0.4);
            color: #93c5fd;
        }

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Delete Confirmation Modal */
       .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.show {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 2rem;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }

        .modal-overlay.show .modal-content {
            transform: scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .modal-header i {
            font-size: 2rem;
            color: #ef4444;
        }

        .modal-header h3 {
            color: #ffffff;
            font-size: 1.5rem;
            margin: 0;
        }
 
        .modal-body {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .modal-actions {
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .modal-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.8rem 1.5rem;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid transparent;
            border-radius: 15px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .modal-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s ease;
        }

        .modal-btn:hover::before {
            left: 100%;
        }

        .modal-btn-cancel {
            background: rgba(100, 116, 139, 0.3);
            color: #cbd5e1;
            border-color: rgba(100, 116, 139, 0.4);
            box-shadow: 0 4px 15px rgba(100, 116, 139, 0.2);
        }

        .modal-btn-cancel:hover {
            background: rgba(100, 116, 139, 0.4);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(100, 116, 139, 0.3);
            text-decoration: none;
            color: #e2e8f0;
            border-color: rgba(100, 116, 139, 0.6);
        }

        .modal-btn-delete {
            background: rgba(239, 68, 68, 0.3);
            color: #ef4444;
            border-color: rgba(239, 68, 68, 0.4);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
        }

        .modal-btn-delete:hover {
            background: rgba(239, 68, 68, 0.4);
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
            text-decoration: none;
            color: #f87171;
            border-color: rgba(239, 68, 68, 0.6);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Pentadbir Sistem Ditugaskan */
        .pentadbir-assigned-full {
            grid-column: 1 / -1;
        }

        .pentadbir-assigned-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .pentadbir-list-item {
            display: flex;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .pentadbir-list-item i {
            margin-right: 0.5rem;
            color: #60a5fa;
        }

        .pentadbir-status-warning {
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.3);
            border-radius: 10px;
            font-size: 0.9rem;
            color: #fbbf24;
            line-height: 1.6;
        }

        .pentadbir-status-warning ul {
            color: #fbbf24;
            margin: 0.5rem 0 0 1.5rem;
            padding: 0;
        }

        .pentadbir-status-warning li {
            margin: 0.25rem 0;
        }



        .pentadbir-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .pentadbir-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.25rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .pentadbir-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #60a5fa, #3b82f6);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .pentadbir-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            border-color: rgba(96, 165, 250, 0.3);
        }

        .pentadbir-card:hover::before {
            opacity: 1;
        }

        .pentadbir-card-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .pentadbir-card-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(96, 165, 250, 0.2), rgba(59, 130, 246, 0.2));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #60a5fa;
            font-size: 1.2rem;
        }

        .pentadbir-card-name {
            color: #ffffff;
            font-weight: 600;
            font-size: 1rem;
        }

        .pentadbir-card-body {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .pentadbir-card-footer {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
        }

        .pentadbir-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .pentadbir-status-complete {
            background: rgba(34, 197, 94, 0.2);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .pentadbir-status-pending {
            background: rgba(251, 191, 36, 0.2);
            color: #fbbf24;
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .collapsible-warning {
            margin-top: 1rem;
            border-radius: 12px;
            overflow: hidden;
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .warning-header {
            padding: 1rem 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s ease;
            user-select: none;
        }

        .warning-header:hover {
            background: rgba(251, 191, 36, 0.15);
        }

        .warning-header-left {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #fbbf24;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .warning-toggle-icon {
            color: #fbbf24;
            font-size: 1rem;
            transition: transform 0.3s ease;
        }

        .warning-toggle-icon.expanded {
            transform: rotate(180deg);
        }

        .warning-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .warning-content.expanded {
            max-height: 500px;
        }

        .warning-content-inner {
            padding: 0 1.25rem 1.25rem 1.25rem;
            color: #fbbf24;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .icon-rotate {
            animation: rotate 2s linear infinite;
        }

        .icon-bounce {
            animation: bounce 1s ease infinite;
        }

        .icon-pulse {
            animation: iconPulse 2s ease-in-out infinite;
        }

        .pentadbir-info-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .pentadbir-info-row:last-child {
            margin-bottom: 0;
        }

        .pentadbir-info-icon {
            color: rgba(255, 255, 255, 0.6);
            width: 16px;
        }

        .pentadbir-info-text {
            font-size: 0.85rem;
        }

        .warning-list-header {
            margin-top: 1rem;
        }

        .warning-list {
            margin: 0.5rem 0 0 1.5rem;
            padding: 0;
        }

        .warning-list-item {
            margin: 0.25rem 0;
        }

        .text-danger-mt {
            color: #ef4444;
            margin-top: 1rem;
        }

        .inline-block {
            display: inline;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        @keyframes iconPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.7; transform: scale(1.1); }
        }


        @media (max-width: 768px) {
            .modern-container {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .comment-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .dropdown-menu {
                right: auto;
                left: 0;
            }

            /* Responsive styles for new components */
            .pentadbir-cards-grid {
                grid-template-columns: 1fr;
            }

            .timeline-steps {
                flex-direction: column;
                gap: 1.5rem;
            }

            .timeline-step {
                width: 100%;
            }

            .timeline-connector {
                display: none;
            }

            .category-badges-container {
                gap: 0.5rem;
            }

            .category-badge {
                font-size: 0.85rem;
                padding: 0.4rem 0.8rem;
            }

            .application-timeline {
                padding: 1.5rem 1rem;
            }

            .timeline-title {
                font-size: 1.1rem;
            }
            .timeline-title {
                font-size: 1.1rem;
            }
    </style>
</head>
<body>
    <div class="modern-container">
        <!-- Success Notification -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif
        <div class="page-header">
            <h1><i class="fas fa-file-alt"></i>Maklumat Permohonan</h1>
            
            <div class="admin-dropdown">
                <button class="dropdown-toggle" id="dropdownToggle">
                    <i class="fas fa-cog"></i>
                    Tindakan Admin
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a href="{{ route('permohonans.edit', $permohonan->id_permohonan) }}" class="dropdown-item edit-item">
                        <i class="fas fa-edit"></i>
                        Edit Permohonan
                    </a>
                    <div class="dropdown-divider"></div>
                    <button onclick="confirmDelete()" class="dropdown-item delete-item">
                        <i class="fas fa-trash-alt"></i>
                        Padam Permohonan
                    </button>
                </div>
            </div>
        
        </div>

        <!-- Applicant Information -->
        <div class="detail-card">
            <h2 class="section-title">
                <i class="fas fa-user-circle"></i>
                Maklumat Pemohon
                @if($permohonan->no_kawalan)
                    <span class="section-badge">
                        <i class="fas fa-barcode"></i> No. Kawalan: {{ $permohonan->no_kawalan }}
                    </span>
                @endif
            </h2>
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
        <div class="detail-card">
            <h2 class="section-title">
                <i class="fas fa-clipboard-list"></i>
                Maklumat Permohonan
                @if($permohonan->jenis_permohonan)
                    <span class="section-badge">
                        <i class="fas fa-file-alt"></i> {{ is_array($permohonan->jenis_permohonan) ? implode(', ', $permohonan->jenis_permohonan) : $permohonan->jenis_permohonan }}
                    </span>
                @endif
            </h2>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-list"></i> Kategori</span>
                    <span class="info-value">{{ $permohonan->formatted_kategori }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-tag"></i> Subkategori</span>
                    <span class="info-value">
                        @if(is_array($permohonan->formatted_subkategori ?? $permohonan->subkategori))
                            {{ implode(', ', $permohonan->formatted_subkategori ?? $permohonan->subkategori) }}
                        @else
                            {{ $permohonan->formatted_subkategori ?? $permohonan->subkategori ?? 'N/A' }}
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label"><i class="fas fa-list-check"></i> Status Permohonan</span>
                    <span class="info-value info-value-status">
                        <span class="status-badge status-{{ strtolower($permohonan->status_permohonan ?? 'pending') }}">
                            {{ $permohonan->status_permohonan ?? 'Dalam Proses' }}
                        </span>
                    </span>
                </div>

                @if($permohonan->fail_borang)
                    <div class="info-item">
                        <span class="info-label"><i class="fas fa-file-pdf"></i> Borang</span>
                        <span class="info-value">
                            <a href="{{ route('permohonans.download', $permohonan->id_permohonan) }}" class="download-btn">
                                <i class="fas fa-download"></i>
                                Muat Turun Borang
                            </a>
                        </span>
                    </div>
                @endif

                <!-- COMPONENT 3: Pentadbir Cards & COMPONENT 4: Collapsible Warning -->
                @if(isset($assignedPentadbir) && $assignedPentadbir->count() > 0)
                    @php
                        $semuaKategoriLengkap = method_exists($permohonan, 'hasMaklumatAksesForAllCategories')
                            ? $permohonan->hasMaklumatAksesForAllCategories()
                            : false;
                        $incompleteCategories = method_exists($permohonan, 'getIncompleteMaklumatAksesCategories')
                            ? $permohonan->getIncompleteMaklumatAksesCategories()
                            : [];
                    @endphp
                    <div class="info-item pentadbir-assigned-full">
                        <span class="info-label"><i class="fas fa-user-shield"></i> Pentadbir Sistem Ditugaskan</span>
                        
                        <div class="pentadbir-cards-grid">
                            @foreach($assignedPentadbir as $pentadbir)
                                <div class="pentadbir-card">
                                    <div class="pentadbir-card-header">
                                        <div class="pentadbir-card-icon">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div class="pentadbir-card-name">{{ $pentadbir->nama }}</div>
                                    </div>
                                    <div class="pentadbir-card-body">
                                        <div class="pentadbir-info-row">
                                            <i class="fas fa-envelope pentadbir-info-icon"></i>
                                            <span class="pentadbir-info-text">{{ $pentadbir->email ?? 'Tiada email' }}</span>
                                        </div>
                                        <div class="pentadbir-info-row">
                                            <i class="fas fa-briefcase pentadbir-info-icon"></i>
                                            <span class="pentadbir-info-text">{{ $pentadbir->jawatan ?? 'Pentadbir Sistem' }}</span>
                                        </div>
                                    </div>
                                    <div class="pentadbir-card-footer">
                                        @if($permohonan->hasPentadbirEnteredData($pentadbir->id_user))
                                            <span class="pentadbir-status-badge pentadbir-status-complete">
                                                <i class="fas fa-check-circle"></i>
                                                Lengkap
                                            </span>
                                        @else
                                            <span class="pentadbir-status-badge pentadbir-status-pending">
                                                <i class="fas fa-clock"></i>
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if(!$semuaKategoriLengkap && ($permohonan->status_permohonan ?? 'Dalam Proses') !== 'Selesai')
                            <div class="collapsible-warning">
                                <div class="warning-header" onclick="toggleWarning()">
                                    <div class="warning-header-left">
                                        <i class="fas fa-exclamation-triangle"></i>
                                        <span>Maklumat Belum Lengkap</span>
                                    </div>
                                    <i class="fas fa-chevron-down warning-toggle-icon" id="warningToggleIcon"></i>
                                </div>
                                <div class="warning-content" id="warningContent">
                                    <div class="warning-content-inner">
                                        <p><strong>Status:</strong> Maklumat akses belum lengkap untuk semua kategori.</p>
                                        @if(count($incompleteCategories) > 0)
                                            <p class="warning-list-header"><strong>Kategori yang belum lengkap:</strong></p>
                                            <ul class="warning-list">
                                                @foreach($incompleteCategories as $kategori)
                                                    <li class="warning-list-item">{{ $kategori }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Comments Section -->
        <div class="detail-card">
            <h2 class="section-title">
                <i class="fas fa-comments"></i>
                Ulasan & Status
            </h2>

            <!-- Pengarah Comment -->
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-role"><i class="fas fa-user-tie"></i> Pengarah</span>
                    @if($permohonan->tarikh_ulasan_pengarah)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pengarah->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pengarah)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pengarah) }}">
                                {{ $permohonan->status_pengarah }}
                            </span>
                        @else
                            <span class="status-badge status-pending">Belum Diulas</span>
                        @endif
                    </span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Ulasan</span>
                    <span class="info-value">
                    @if($permohonan->ulasan_pengarah)
                        <div class="comment-content">{{ $permohonan->ulasan_pengarah }}</div>
                    @else
                        <div class="no-comment">Tiada ulasan daripada Pengarah</div>
                    @endif
                </span>
                </div>
            </div>

            <!-- Pegawai Comment -->
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-role"><i class="fas fa-user"></i> Pegawai</span>
                    @if($permohonan->tarikh_ulasan_pegawai)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pegawai->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pegawai)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pegawai) }}">
                                {{ $permohonan->status_pegawai }}
                            </span>
                        @else
                            <span class="status-badge status-pending">Belum Diulas</span>
                        @endif
                    </span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Ulasan</span>
                    <span class="info-value">
                @if($permohonan->ulasan_pegawai)
                    <div class="comment-content">{{ $permohonan->ulasan_pegawai }}</div>
                @else
                    <div class="no-comment">Tiada ulasan daripada Pegawai</div>
                @endif
                <span>
                </div>
            </div>

             <!-- Pentadbir Sistem Comment -->
            <div class="comment-card">
                <div class="comment-header">
                    <span class="comment-role"><i class="fas fa-user"></i> Pentadbir Sistem</span>
                    @if($permohonan->tarikh_ulasan_pentadbir_sistem)
                        <span class="comment-date">{{ $permohonan->tarikh_ulasan_pentadbir_sistem->format('d/m/Y') }}</span>
                    @endif
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Status</span>
                    <span class="info-value">
                        @if($permohonan->status_pentadbir_sistem)
                            <span class="status-badge status-{{ strtolower($permohonan->status_pentadbir_sistem) }}">
                                {{ $permohonan->status_pentadbir_sistem }}
                            </span>
                        @else
                            <span class="status-badge status-pending">Belum Diulas</span>
                        @endif
                    </span>
                </div>
                <div class="info-item mb-3">
                    <span class="info-label">Ulasan</span>
                    <span class="info-value">
                @if($permohonan->ulasan_pentadbir_sistem)
                    <div class="comment-content">{{ $permohonan->ulasan_pentadbir_sistem }}</div>
                @else
                    <div class="no-comment">Tiada ulasan daripada Pentadbir Sistem</div>
                @endif
                    <span>
                </div>
            </div>

            <!-- Additional Comments from Ulasan table -->
            @if($permohonan->ulasans && $permohonan->ulasans->count() > 0)
                @foreach($permohonan->ulasans as $ulasan)
                    <div class="comment-card">
                        <div class="comment-header">
                            <span class="comment-role"><i class="fas fa-user-cog"></i> Ulasan Tambahan</span>
                            <span class="comment-date">{{ $ulasan->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="comment-content">{{ $ulasan->ulasan }}</div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="button-group">
            <a href="{{ route('admin.senarai_permohonan') }}" class="action-btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
            @if($permohonan->fail_borang)
                <a href="{{ route('permohonans.download', $permohonan->id_permohonan) }}" class="action-btn btn-primary">
                    <i class="fas fa-download"></i>
                    Muat Turun Borang
                </a>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <i class="fas fa-exclamation-triangle"></i>
                <h3>Sahkan Pemadaman</h3>
            </div>
            <div class="modal-body">
                <p>Adakah anda pasti ingin memadam permohonan ini?</p>
                <p><strong>ID Permohonan: {{ $permohonan->id_permohonan }}</strong></p>
                <p class="text-danger-mt">Tindakan ini tidak boleh dibatalkan!</p>
            </div>
            <div class="modal-actions">
                <button class="modal-btn modal-btn-cancel" onclick="closeDeleteModal()">Batal</button>
                <form action="{{ route('permohonans.destroy', $permohonan->id_permohonan) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn modal-btn-delete">
                        <i class="fas fa-trash-alt"></i> Padam
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Dropdown Toggle
        const dropdownToggle = document.getElementById('dropdownToggle');
        const dropdownMenu = document.getElementById('dropdownMenu');

        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdownMenu.contains(e.target) && !dropdownToggle.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        }

        // Delete Confirmation Modal
        function confirmDelete() {
            const modal = document.getElementById('deleteModal');
            modal.classList.add('show');
            // Close dropdown when opening modal
            if (dropdownMenu) {
                dropdownMenu.classList.remove('show');
            }
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            modal.classList.remove('show');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeDeleteModal();
            }
        });

        // Collapsible Warning Toggle
        function toggleWarning() {
            const content = document.getElementById('warningContent');
            const icon = document.getElementById('warningToggleIcon');
            
            if (content && icon) {
                content.classList.toggle('expanded');
                icon.classList.toggle('expanded');
            }
        }
    </script>
</body>
</html>