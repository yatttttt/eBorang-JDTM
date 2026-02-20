@extends('layout.app')
@section('title', 'Pengurusan Pengguna')
@section('content')

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
        position: relative;
        overflow-x: hidden;
        margin: 0 !important;
        padding: 0 !important;
    }

    .modern-container {
        padding: 2rem;
        position: relative;
        z-index: 1;
    }

    .page-header {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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

    .search-container {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        flex: 1;
        max-width: 500px;
        min-width: 250px;
        position: relative;
    }

    .search-input-wrapper {
        position: relative;
        flex: 1;
        display: flex;
        align-items: center;
    }

    .search-input {
        flex: 1;
        width: 100%;
        padding: 0.8rem 2.8rem 0.8rem 1.2rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        color: #ffffff;
        font-size: 0.95rem;
        outline: none;
        transition: all 0.3s ease;
    }

    .search-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .search-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(96, 165, 250, 0.5);
        box-shadow: 0 0 20px rgba(96, 165, 250, 0.3);
    }

    .clear-input-btn {
        position: absolute;
        right: 0.8rem;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(239, 68, 68, 0.3);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(239, 68, 68, 0.4);
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #f87171;
        font-size: 0.9rem;
        padding: 0;
        opacity: 0;
        pointer-events: none;
    }

    .clear-input-btn.show {
        display: flex;
        opacity: 1;
        pointer-events: auto;
    }

    .clear-input-btn:hover {
        background: rgba(239, 68, 68, 0.5);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.4);
    }

    .search-btn {
        padding: 0.8rem 1.5rem;
        background: rgba(96, 165, 250, 0.3);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(96, 165, 250, 0.4);
        border-radius: 12px;
        color: #60a5fa;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .search-btn:hover {
        background: rgba(96, 165, 250, 0.4);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(96, 165, 250, 0.3);
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        background: rgba(0, 98, 255, 0.3);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(59, 130, 246, 0.4);
        border-radius: 15px;
        color: #60a5fa;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .action-btn::before {
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
        background: rgba(59, 130, 246, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        text-decoration: none;
        color: #93c5fd;
        border-color: rgba(59, 130, 246, 0.6);
    }

    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .stat-card h3 {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        margin: 0 0 0.5rem 0;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        z-index: 1;
    }

    .stat-card .stat-value {
        color: #60a5fa;
        font-size: 2.5rem;
        font-weight: 700;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 1;
    }

    .table-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        position: relative;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    .modern-table thead {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    }

    .modern-table th {
        padding: 1.5rem 1rem;
        text-align: left;
        font-weight: 600;
        color: #ffffff;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .sortable {
        cursor: pointer;
        user-select: none;
        transition: all 0.3s ease;
        position: relative;
        padding-right: 2rem !important;
    }

    .sortable:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #60a5fa;
    }

    .sortable::after {
        content: '\f0dc';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        position: absolute;
        right: 1rem;
        opacity: 0.5;
        transition: all 0.3s ease;
    }

    .sortable.asc::after {
        content: '\f0de';
        opacity: 1;
        color: #60a5fa;
    }

    .sortable.desc::after {
        content: '\f0dd';
        opacity: 1;
        color: #60a5fa;
    }

    .sortable:hover::after {
        opacity: 1;
    }

    .modern-table tbody tr {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .modern-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .modern-table td {
        padding: 1.5rem 1rem;
        color: #ffffff;
        font-size: 0.95rem;
        vertical-align: middle;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .id-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 0.5rem 1rem;
        font-weight: 700;
        color: #ffffff;
        display: inline-block;
        font-family: 'Courier New', monospace;
        font-size: 0.85rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .id-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        50% { left: 100%; }
        100% { left: 100%; }
    }

    .user-profile-cell {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.1);
    }

    .user-avatar:hover {
        transform: scale(1.15);
        border-color: rgba(96, 165, 250, 0.6);
        box-shadow: 0 6px 20px rgba(96, 165, 250, 0.4);
    }

    .user-avatar-placeholder {
        width: 50px;
        height: 50px;
        min-width: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, rgba(96, 165, 250, 0.3), rgba(168, 85, 247, 0.3));
        border: 3px solid rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .user-avatar-placeholder:hover {
        transform: scale(1.15);
        border-color: rgba(96, 165, 250, 0.6);
        box-shadow: 0 6px 20px rgba(96, 165, 250, 0.4);
    }

   .name-cell {
        font-weight: 600;
        color: #ffffff;
        font-size: 1rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }


    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.2rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: capitalize;
        border: 1px solid transparent;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

   .status-admin {
        background: rgba(34, 211, 238, 0.15);   
        border-color: rgba(34, 211, 238, 0.4);     
        color: #44dbefff;                          
        box-shadow: 0 4px 15px rgba(34, 211, 238, 0.25); 
    }

    .status-pengarah {
        background: rgba(20, 184, 166, 0.25); 
        color: #14b8a6;
        border-color: rgba(15, 118, 110, 0.5); 
        box-shadow: 0 4px 15px rgba(15, 118, 110, 0.25);
    }

    .status-pegawai {
        background: rgba(34, 197, 94, 0.3);
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.4);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
    }

   .status-pentadbir {
        background: rgba(255, 127, 80, 0.28);
        color: #ff7f50;
        border-color: rgba(255, 99, 71, 0.5);
        box-shadow: 0 4px 15px rgba(255, 99, 71, 0.25);
    }

    .date-cell {
        color: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .status-pending {
        background: rgba(251, 191, 36, 0.3);
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.4);
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.2);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-action {
        padding: 0.6rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid transparent;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.3);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.4);
    }

    .btn-delete::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .btn-delete:hover::before {
        left: 100%;
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.5);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4);
        color: #f87171;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.6;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: #ffffff;
        margin-bottom: 1rem;
        font-weight: 600;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .empty-state p {
        color: rgba(255, 255, 255, 0.8);
        margin: 0;
        font-size: 1.1rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
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

    .modal-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(239, 68, 68, 0.3);
        border: 2px solid rgba(239, 68, 68, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: #ef4444;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #ffffff;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .modal-body {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .modal-user-info {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .modal-user-info p {
        margin: 0.5rem 0;
        color: #ffffff;
    }

    .modal-user-info strong {
        color: #60a5fa;
    }

    .modal-footer {
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

    .modal-btn-confirm {
        background: rgba(239, 68, 68, 0.3);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.4);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
    }

    .modal-btn-confirm:hover {
        background: rgba(239, 68, 68, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        text-decoration: none;
        color: #f87171;
        border-color: rgba(239, 68, 68, 0.6);
    }

     /* Pagination Styles */
    .pagination-container {
        margin-top: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }

    .pagination-info {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
        text-align: center;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .pagination-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
    }

    .pagination-nav {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 1.5rem;
        background: rgba(96, 165, 250, 0.3);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(96, 165, 250, 0.4);
        border-radius: 12px;
        color: #60a5fa;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(96, 165, 250, 0.2);
    }

    .pagination-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .pagination-btn:hover::before {
        left: 100%;
    }

    .pagination-btn:hover {
        background: rgba(96, 165, 250, 0.4);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(96, 165, 250, 0.3);
        text-decoration: none;
        color: #93c5fd;
        border-color: rgba(96, 165, 250, 0.6);
    }

    .pagination-btn-disabled {
        background: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.2);
        color: rgba(255, 255, 255, 0.4);
        cursor: not-allowed;
        pointer-events: none;
        box-shadow: none;
    }

    .pagination-btn-disabled::before {
        display: none;
    }

    .pagination-numbers {
        display: flex;
        align-items: center;
        gap: 0.3rem;
        flex-wrap: wrap;
        justify-content: center;
    }

    .pagination-number {
        min-width: 40px;
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 10px;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        position: relative;
        overflow: hidden;
    }

    .pagination-number::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .pagination-number:hover::before {
        left: 100%;
    }

    .pagination-number:hover {
        background: rgba(96, 165, 250, 0.3);
        border-color: rgba(96, 165, 250, 0.4);
        color: #60a5fa;
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 4px 15px rgba(96, 165, 250, 0.2);
        text-decoration: none;
    }

    .pagination-number.active {
        background: rgba(96, 165, 250, 0.5);
        border-color: rgba(96, 165, 250, 0.6);
        color: #ffffff;
        box-shadow: 0 4px 15px rgba(96, 165, 250, 0.3);
        cursor: default;
        pointer-events: none;
    }

    .pagination-number.active::before {
        display: none;
    }

    .pagination-dots {
        color: rgba(255, 255, 255, 0.5);
        padding: 0 0.5rem;
        font-weight: bold;
    }

    @media (max-width: 768px) {
        .modern-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .search-container {
            max-width: 100%;
            flex-wrap: wrap;
        }

        .search-input {
            padding: 0.8rem 2.5rem 0.8rem 1rem;
        }

        .clear-input-btn {
            width: 22px;
            height: 22px;
            font-size: 0.8rem;
        }

        .search-btn span {
            display: none;
        }

        .search-btn {
            padding: 0.8rem 1rem;
        }

        .table-container {
            overflow-x: auto;
        }

        .modern-table {
            min-width: 900px;
        }

        .sortable {
            padding-right: 1.5rem !important;
        }

        .user-avatar,
        .user-avatar-placeholder {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 1rem;
        }

        .user-name {
            font-size: 0.9rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.3rem;
        }

        .btn-action {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }

        .stats-container {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-card h3 {
            font-size: 0.8rem;
        }

        .stat-card .stat-value {
            font-size: 2rem;
        }

        .pagination-btn .btn-text {
            display: none;
        }

        .pagination-btn {
            padding: 0.8rem 1rem;
        }

        .pagination-number {
            min-width: 35px;
            height: 35px;
            font-size: 0.85rem;
        }

        .pagination-numbers {
            gap: 0.2rem;
        }

        .pagination-info {
            font-size: 0.85rem;
        }
    }
</style>

<div class="modern-container">
   <div class="page-header">
    <h1><i class="fas fa-users"></i>Pengurusan Pengguna</h1>

    <div class="search-container">
        <form method="GET" action="{{ route('pengurusan.pengguna') }}" style="display: flex; gap: 0.5rem; width: 100%;">
            <div class="search-input-wrapper">
                <input type="text" 
                       name="search"
                       id="searchInput" 
                       class="search-input" 
                       placeholder="Cari ID, Nama, Email, dan Peranan"
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('pengurusan.pengguna') }}" 
                       class="clear-input-btn show" 
                       title="Padam carian">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </div>
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i>
                <span>Cari</span>
            </button>
        </form>
    </div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    {{-- Statistics --}}
    <div class="stats-container">
        <div class="stat-card">
            <h3>Jumlah Pengguna</h3>
            <div class="stat-value">{{ $total ?? 0 }}</div>
        </div>
    </div>

    {{-- Add New User Button --}}
    <a href="{{ route('pengguna.tambah') }}" class="action-btn">
        <i class="fas fa-plus-circle"></i>
        Tambah Pengguna Baru
    </a>

    {{-- Users Table --}}
    <div class="table-container">
        <table class="modern-table">
            <thead>
                <tr>
                    <th class="sortable" onclick="sortTable(0, 'id')" data-sort="none" style="text-align: center;">No</th>
                    <th>Gambar</th>
                    <th class="sortable" onclick="sortTable(1, 'text')" data-sort="none">Nama</th>
                    <th class="sortable" onclick="sortTable(2, 'text')" data-sort="none">Email</th>
                    <th>Peranan</th>
                    <th>Email Disahkan</th>
                    <th style="text-align: center;">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td data-id="{{ $user->id_user }}" style="text-align: center;">
                      <span class="id-badge">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</span>
                    </td>
                    <td data-name="{{ $user->nama }}">
                        <div class="user-profile-cell">
                            @if($user->gambar_profil)
                                <img src="{{ asset('storage/' . $user->gambar_profil) }}" 
                                     alt="{{ $user->nama }}" 
                                     class="user-avatar"
                                     title="{{ $user->nama }}">
                            @else
                                <div class="user-avatar-placeholder" title="{{ $user->nama }}">
                                    {{ strtoupper(substr($user->nama, 0, 1)) }}
                                </div>
                            @endif 
                         </div> 
                    </td>      
                    <td data-name="{{ $user->nama }}" class="name-cell">{{ $user->nama }}</td>
                    <td data-email="{{ $user->email }}">{{ $user->email }}</td>
                    <td data-peranan="{{ $user->peranan }}">
                        <span class="status-badge 
                            @if($user->peranan == 'admin') status-admin
                            @elseif($user->peranan == 'pengarah') status-pengarah
                            @elseif($user->peranan == 'pegawai') status-pegawai
                            @elseif($user->peranan == 'pentadbir_sistem') status-pentadbir
                            @else status-pegawai
                            @endif">
                            {{ $user->peranan == 'pentadbir_sistem' ? 'Pentadbir Sistem' : ucfirst($user->peranan) }}
                        </span>
                    </td>
                    <td>
                        @if($user->email_verified_at)
                            <div class="date-cell">
                                {{ $user->email_verified_at->format('d/m/Y') }}
                            </div>
                        @else
                            <span class="status-badge status-pending">Belum Disahkan</span>
                        @endif
                    </td>
                    <td>
                        <div class="action-buttons" style="justify-content: center;">
                            @php
                                $displayPeranan = $user->peranan == 'pentadbir_sistem' ? 'Pentadbir Sistem' : ucfirst($user->peranan);
                            @endphp
                            <button onclick="confirmDelete('{{ $user->id_user }}', '{{ $user->nama }}', '{{ $user->email }}', '{{ $displayPeranan }}')"  
                                    class="btn-action btn-delete"
                                    title="Padam pengguna">
                                <i class="fas fa-trash-alt"></i>
                                Padam
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <div class="empty-icon">📭</div>
                            <h3>Tiada Data</h3>
                            <p>Tiada pengguna dijumpai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

   {{-- Pagination --}}
    @if($users->hasPages())
    <div class="pagination-container">
        <div class="pagination-info">
            Memaparkan {{ $users->firstItem() ?? 0 }} hingga {{ $users->lastItem() ?? 0 }} daripada {{ $users->total() }} pengguna
        </div>
        
        <div class="pagination-wrapper">
            <nav class="pagination-nav">
                {{-- Previous Button --}}
                @if ($users->onFirstPage())
                    <span class="pagination-btn pagination-btn-disabled">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Sebelum</span>
                    </span>
                @else
                    <a href="{{ $users->appends(request()->query())->previousPageUrl() }}" class="pagination-btn pagination-btn-prev">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Sebelum</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div class="pagination-numbers">
                    @php
                        $start = max($users->currentPage() - 2, 1);
                        $end = min($start + 4, $users->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $users->appends(request()->query())->url(1) }}" class="pagination-number">1</a>
                        @if($start > 2)
                            <span class="pagination-dots">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $users->currentPage())
                            <span class="pagination-number active">{{ $i }}</span>
                        @else
                            <a href="{{ $users->appends(request()->query())->url($i) }}" class="pagination-number">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $users->lastPage())
                        @if($end < $users->lastPage() - 1)
                            <span class="pagination-dots">...</span>
                        @endif
                        <a href="{{ $users->appends(request()->query())->url($users->lastPage()) }}" class="pagination-number">{{ $users->lastPage() }}</a>
                    @endif
                </div>

                {{-- Next Button --}}
                @if ($users->hasMorePages())
                    <a href="{{ $users->appends(request()->query())->nextPageUrl() }}" class="pagination-btn pagination-btn-next">
                        <span class="btn-text">Seterusnya</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <span class="pagination-btn pagination-btn-disabled">
                        <span class="btn-text">Seterusnya</span>
                        <i class="fas fa-chevron-right"></i>
                    </span>
                @endif
            </nav>
        </div>
    </div>
    @endif
</div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div>
                    <h2 class="modal-title">Sahkan Pemadaman</h2>
                </div>
            </div>
            <div class="modal-body">
                <p>Adakah anda pasti mahu memadam pengguna ini? Tindakan ini tidak boleh dibatalkan.</p>
                <div class="modal-user-info">
                    <p><strong>Nama:</strong> <span id="deleteUserName"></span></p>
                    <p><strong>Email:</strong> <span id="deleteUserEmail"></span></p>
                    <p><strong>Peranan:</strong> <span id="deleteUserPeranan"></span></p>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="closeDeleteModal()" class="modal-btn modal-btn-cancel">
                    <i class="fas fa-times"></i>
                    Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-btn modal-btn-confirm">
                        <i class="fas fa-trash-alt"></i>
                        Ya, Padam
                    </button>
                </form>
            </div>
        </div>
    </div>

<script>
    /**
     * Delete Modal Functions
     */
    function confirmDelete(userId, userName, userEmail, userPeranan) {
        const modal = document.getElementById('deleteModal');
        const form = document.getElementById('deleteForm');
        const nameSpan = document.getElementById('deleteUserName');
        const emailSpan = document.getElementById('deleteUserEmail');
        const perananSpan = document.getElementById('deleteUserPeranan');
        
        // Set user information in modal
        nameSpan.textContent = userName;
        emailSpan.textContent = userEmail;
        perananSpan.textContent = userPeranan;
        
        // Set form action URL for deletion
        form.action = `{{ route('pengguna.destroy', '') }}/${userId}`;
        
        // Show modal with animation
        modal.classList.add('show');
        
        // Prevent body scroll when modal is open
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        
        // Hide modal
        modal.classList.remove('show');
        
        // Re-enable body scroll
        document.body.style.overflow = '';
    }

    /**
     * Close modal when clicking outside the modal content
     */
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    /**
     * Close modal when pressing Escape key
     */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('deleteModal');
            if (modal.classList.contains('show')) {
                closeDeleteModal();
            }
        }
    });

    /**
     * Auto-hide success messages after 5 seconds
     */
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.querySelector('.alert-success');
        
        if (successAlert) {
            setTimeout(function() {
                // Fade out animation
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                
                // Remove from DOM after fade out
                setTimeout(function() {
                    successAlert.remove();
                }, 500);
            }, 5000); // Hide after 5 seconds
        }
    });

    /**
     * Optional: Add loading state to search button
     */
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.querySelector('.filter-form');
        
        if (searchForm) {
            searchForm.addEventListener('submit', function() {
                const searchBtn = searchForm.querySelector('button[type="submit"]');
                
                if (searchBtn) {
                    // Change button text to show loading
                    searchBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Mencari...</span>';
                    searchBtn.disabled = true;
                }
            });
        }
    });

    /**
     * Optional: Prevent double submission
     */
    document.addEventListener('DOMContentLoaded', function() {
        const deleteForm = document.getElementById('deleteForm');
        
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                const submitBtn = deleteForm.querySelector('button[type="submit"]');
                
                if (submitBtn.disabled) {
                    e.preventDefault();
                    return false;
                }
                
                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memadam...';
            });
        }
    });

    /**
     * Optional: Smooth scroll to top after pagination
     */
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const page = urlParams.get('page');
        
        if (page && page > 1) {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    });

    /**
     * Optional: Highlight current filter
     */
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const hasFilters = urlParams.has('search') || urlParams.has('peranan');
        
        if (hasFilters) {
            const filterForm = document.querySelector('.filter-form');
            if (filterForm) {
                // Add visual indicator that filters are active
                filterForm.style.borderColor = 'rgba(34, 197, 94, 0.5)';
                filterForm.style.boxShadow = '0 4px 20px rgba(34, 197, 94, 0.2)';
            }
        }
    });

    /**
     * Optional: Auto-submit form when selecting role filter
     * Remove this if you want manual submit only
     */
    document.addEventListener('DOMContentLoaded', function() {
        const perananSelect = document.querySelector('select[name="peranan"]');
        
        if (perananSelect) {
            perananSelect.addEventListener('change', function() {
                // Uncomment the line below to enable auto-submit
                // this.form.submit();
            });
        }
    });
</script>
@endsection