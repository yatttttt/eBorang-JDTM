@extends('layout.app')
@section('title', 'Senarai Permohonan')

@push('styles')
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

    .name-cell {
        font-weight: 600;
        color: #ffffff;
        font-size: 1rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .date-cell {
        color: rgba(255, 255, 255, 0.9);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
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

    .status-pending {
        background: rgba(251, 191, 36, 0.3);
        color: #fbbf24;
        border-color: rgba(251, 191, 36, 0.4);
        box-shadow: 0 4px 15px rgba(251, 191, 36, 0.2);
    }

    .status-approved {
        background: rgba(34, 197, 94, 0.3);
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.4);
        box-shadow: 0 4px 15px rgba(34, 197, 94, 0.2);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.3);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.4);
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.2);
    }

    .status-default {
        background: rgba(107, 114, 128, 0.25); 
        color: #ffffffff;
        border-color: rgba(107, 114, 128, 0.4);
        box-shadow: 0 4px 15px rgba(107, 114, 128, 0.2);
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

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.8;
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

        .table-container {
            overflow-x: auto;
        }

        .modern-table {
            min-width: 700px;
        }

        .sortable {
            padding-right: 1.5rem !important;
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
    }
</style>
@endpush

@section('content')
<div class="modern-container">
    <div class="page-header">
    <h1><i class="fas fa-list"></i>Senarai Permohonan</h1>

    <div class="search-container">
        <form method="GET" action="{{ route('admin.senarai_permohonan') }}" style="display: flex; gap: 0.5rem; width: 100%;">
            <div class="search-input-wrapper">
                <input type="text" 
                       name="search"
                       id="searchInput" 
                       class="search-input" 
                       placeholder="Nama, Kategori, No. Kawalan, No. Kad Pengenalan, atau Status..."
                       value="{{ request('search') }}">
                
                @if(request('search'))
                    <a href="{{ route('admin.senarai_permohonan') }}" 
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

    @if($permohonans->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📝</div>
            <h3>Tiada Permohonan Dijumpai</h3>
            <p>Belum ada permohonan yang dihantar pada masa ini.</p>
        </div>
    @else
    
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="sortable" onclick="sortTable(0, 'id')" data-sort="none" style="text-align: center;">No</th>
                        <th class="sortable" onclick="sortTable(1, 'text')" data-sort="none">Nama Pemohon</th>
                        <th class="sortable" onclick="sortTable(2, 'date')" data-sort="none">Tarikh Permohonan</th>
                        <th>Status</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($permohonans as $permohonan)
                        <tr>
                           <td data-id="{{ $permohonan->id_permohonan }}" style="text-align: center;">
                                <span class="id-badge">{{ ($permohonans->currentPage() - 1) * $permohonans->perPage() + $loop->iteration }}</span>
                            </td>
                            <td data-name="{{ $permohonan->nama_pemohon }}">
                                <div class="name-cell">{{ $permohonan->nama_pemohon }}</div>
                            </td>
                            <td data-date="{{ $permohonan->created_at->format('Y-m-d') }}">
                                <div class="date-cell">
                                    {{ $permohonan->created_at->format('d/m/Y') }}
                                </div>
                            </td>
                            <td data-status="{{ strtolower($permohonan->status_permohonan) }}">
                                <span class="status-badge status-{{ $permohonan->status_class }}">
                                    {{ $permohonan->status_permohonan }}
                                </span>
                            </td>
                            <td>
                               <a href="{{ route('permohonans.show', $permohonan->id_permohonan) }}" class="action-btn">
                                   Lebih Lanjut
                               </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($permohonans->hasPages())
        <div class="pagination-container">
            <div class="pagination-info">
                Memaparkan {{ $permohonans->firstItem() ?? 0 }} hingga {{ $permohonans->lastItem() ?? 0 }} daripada {{ $permohonans->total() }} permohonan
            </div>
            
            <div class="pagination-wrapper">
                <nav class="pagination-nav">
                    {{-- Previous Button --}}
                    @if ($permohonans->onFirstPage())
                        <span class="pagination-btn pagination-btn-disabled">
                            <i class="fas fa-chevron-left"></i>
                            <span class="btn-text">Sebelum</span>
                        </span>
                    @else
                        <a href="{{ $permohonans->previousPageUrl() }}" class="pagination-btn pagination-btn-prev">
                            <i class="fas fa-chevron-left"></i>
                            <span class="btn-text">Sebelum</span>
                        </a>
                    @endif

                    {{-- Page Numbers --}}
                    <div class="pagination-numbers">
                        @php
                            $start = max($permohonans->currentPage() - 2, 1);
                            $end = min($start + 4, $permohonans->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $permohonans->url(1) }}" class="pagination-number">1</a>
                            @if($start > 2)
                                <span class="pagination-dots">...</span>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            @if ($i == $permohonans->currentPage())
                                <span class="pagination-number active">{{ $i }}</span>
                            @else
                                <a href="{{ $permohonans->url($i) }}" class="pagination-number">{{ $i }}</a>
                            @endif
                        @endfor

                        @if($end < $permohonans->lastPage())
                            @if($end < $permohonans->lastPage() - 1)
                                <span class="pagination-dots">...</span>
                            @endif
                            <a href="{{ $permohonans->url($permohonans->lastPage()) }}" class="pagination-number">{{ $permohonans->lastPage() }}</a>
                        @endif
                    </div>

                    {{-- Next Button --}}
                    @if ($permohonans->hasMorePages())
                        <a href="{{ $permohonans->nextPageUrl() }}" class="pagination-btn pagination-btn-next">
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
    @endif
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

    // Track current sort state for each column
    let sortStates = {};

    // Sort table function
    function sortTable(columnIndex, type) {
        const table = document.querySelector('.modern-table');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));
        const header = table.querySelectorAll('th')[columnIndex];
        
        const currentSort = sortStates[columnIndex] || 'none';
        let newSort = (currentSort === 'none' || currentSort === 'desc') ? 'asc' : 'desc';
        
        sortStates[columnIndex] = newSort;
        
        table.querySelectorAll('th').forEach(th => {
            th.classList.remove('asc', 'desc');
            th.setAttribute('data-sort', 'none');
        });
        
        header.classList.add(newSort);
        header.setAttribute('data-sort', newSort);
        
        rows.sort((a, b) => {
            let aValue, bValue;
            
            if (type === 'id') {
                const aText = a.cells[columnIndex].textContent.trim();
                const bText = b.cells[columnIndex].textContent.trim();
                aValue = parseInt(aText) || 0;
                bValue = parseInt(bText) || 0;
            } else if (type === 'text') {
                aValue = (a.cells[columnIndex].getAttribute('data-name') || '').toLowerCase();
                bValue = (b.cells[columnIndex].getAttribute('data-name') || '').toLowerCase();
            } else if (type === 'date') {
                aValue = a.cells[columnIndex].getAttribute('data-date') || '0000-00-00';
                bValue = b.cells[columnIndex].getAttribute('data-date') || '0000-00-00';
            }
            
            if (newSort === 'asc') {
                return aValue < bValue ? -1 : aValue > bValue ? 1 : 0;
            } else {
                return aValue > bValue ? -1 : aValue < bValue ? 1 : 0;
            }
        });
        
        rows.forEach(row => tbody.appendChild(row));
    }
</script>
@endsection