@extends('layout.app')
@section('title', 'Log Aktiviti')

@push('styles')
<style>
    .filter-btn {
        padding: 0.6rem 1.2rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        color: #ffffff;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        font-size: 0.95rem;
    }

    .filter-btn:hover {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .filter-btn.active {
        background: rgba(96, 165, 250, 0.5);
        border-color: rgba(96, 165, 250, 0.6);
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
    }

    .search-input {
        flex: 1;
        width: 100%;
        padding: 0.8rem 1.2rem;
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

    #resetBtn:hover {
        background: rgba(239, 68, 68, 0.5) !important;
        border-color: rgba(239, 68, 68, 0.6) !important;
        box-shadow: 0 4px 15px rgba(239, 68, 68, 0.4) !important;
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
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        animation: shine 3s infinite;
    }

    @keyframes shine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .no-data {
        text-align: center;
        padding: 3rem 1rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
    }

    .no-data i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
        display: block;
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

    /* Status Badge Styles */
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

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-header h1 {
            font-size: 1.8rem;
        }

        .search-container {
            width: 100%;
            max-width: 100%;
        }

        .modern-table {
            font-size: 0.85rem;
        }

        .modern-table th,
        .modern-table td {
            padding: 1rem 0.5rem;
        }
    }
</style>
@endpush

@section('content')

<div class="modern-container">
    <!-- Header -->
    <div class="page-header">
        <h1>
            <i class="fas fa-history"></i>
            Log Aktiviti
        </h1>
        <div class="search-container">
            <form id="searchForm" style="display: flex; gap: 0.5rem; width: 100%;">
                <div class="search-input-wrapper">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Nama pengguna atau tindakan..." 
                        value="{{ request('search') }}"
                        id="searchInput"
                    />
                </div>
                <button type="button" class="search-btn" id="searchBtn">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
                <button type="button" class="search-btn" id="resetBtn" style="background: rgba(239, 68, 68, 0.3); border-color: rgba(239, 68, 68, 0.4); color: #f87171;">
                    <i class="fas fa-redo"></i>
                    Reset
                </button>
            </form>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    <!-- Activity Type Filter -->
    <div style="display: flex; gap: 0.8rem; margin-bottom: 2rem; flex-wrap: wrap;" id="filterContainer">
        <button type="button" class="filter-btn active" data-type="" onclick="filterByType(event, '')">
            <i class="fas fa-list"></i>
            Semua
        </button>
        <button type="button" class="filter-btn" data-type="login" onclick="filterByType(event, 'login')">
            <i class="fas fa-sign-in-alt"></i>
            Log Masuk
        </button>
        <button type="button" class="filter-btn" data-type="logout" onclick="filterByType(event, 'logout')">
            <i class="fas fa-sign-out-alt"></i>
            Log Keluar
        </button>
        <button type="button" class="filter-btn" data-type="status" onclick="filterByType(event, 'status')">
            <i class="fas fa-tasks"></i>
            Kemaskini Status
        </button>
        <button type="button" class="filter-btn" data-type="upload" onclick="filterByType(event, 'upload')">
            <i class="fas fa-cloud-upload-alt"></i>
            Upload
        </button>
    </div>

    <!-- Table -->
    <div class="table-container" id="tableContainer">
        <!-- Table Content -->
        <div id="tableContent">
            @include('admin.partials.log_aktiviti_table', compact('logs'))
        </div>
    </div>

    <!-- Pagination -->
    <div id="paginationContainer" class="pagination-container">
        <div class="pagination-info">
            Memaparkan {{ $logs->firstItem() ?? 0 }} hingga {{ $logs->lastItem() ?? 0 }} daripada {{ $logs->total() }} log aktiviti
        </div>
        
        <div class="pagination-wrapper">
            <nav class="pagination-nav">
                {{-- Previous Button --}}
                @if ($logs->onFirstPage())
                    <span class="pagination-btn pagination-btn-disabled">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Sebelum</span>
                    </span>
                @else
                    <a href="{{ $logs->previousPageUrl() }}" class="pagination-btn pagination-btn-prev" onclick="handlePaginationClick(event, '{{ $logs->previousPageUrl() }}')">
                        <i class="fas fa-chevron-left"></i>
                        <span class="btn-text">Sebelum</span>
                    </a>
                @endif

                {{-- Page Numbers --}}
                <div class="pagination-numbers">
                    @php
                        $start = max($logs->currentPage() - 2, 1);
                        $end = min($start + 4, $logs->lastPage());
                        $start = max($end - 4, 1);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $logs->url(1) }}" class="pagination-number" onclick="handlePaginationClick(event, '{{ $logs->url(1) }}')">1</a>
                        @if($start > 2)
                            <span class="pagination-dots">...</span>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        @if ($i == $logs->currentPage())
                            <span class="pagination-number active">{{ $i }}</span>
                        @else
                            <a href="{{ $logs->url($i) }}" class="pagination-number" onclick="handlePaginationClick(event, '{{ $logs->url($i) }}')">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($end < $logs->lastPage())
                        @if($end < $logs->lastPage() - 1)
                            <span class="pagination-dots">...</span>
                        @endif
                        <a href="{{ $logs->url($logs->lastPage()) }}" class="pagination-number" onclick="handlePaginationClick(event, '{{ $logs->url($logs->lastPage()) }}')">{{ $logs->lastPage() }}</a>
                    @endif
                </div>

                {{-- Next Button --}}
                @if ($logs->hasMorePages())
                    <a href="{{ $logs->nextPageUrl() }}" class="pagination-btn pagination-btn-next" onclick="handlePaginationClick(event, '{{ $logs->nextPageUrl() }}')">
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
</div>

<script>
    // Handle pagination link clicks
    function handlePaginationClick(event, url) {
        event.preventDefault();
        const page = new URL(url).searchParams.get('page');
        fetchLogs(page);
    }

    // Search button click
    document.getElementById('searchBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        fetchLogs();
    });

    // Reset button click
    document.getElementById('resetBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.getElementById('searchInput').value = '';
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        document.querySelector('[data-type=""]').classList.add('active');
        currentFilter = '';
        fetchLogs();
    });

    // Allow Enter key in search input
    searchInput?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            fetchLogs();
        }
    });

    // AJAX Filter Function
    let currentFilter = '';

    function filterByType(event, type) {
        event.preventDefault();
        event.stopPropagation();
        
        currentFilter = type;
        
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Highlight active button
        event.target.closest('.filter-btn').classList.add('active');

        fetchLogs();
    }

    function fetchLogs(page = 1) {
        const search = document.getElementById('searchInput').value;
        const tableContent = document.getElementById('tableContent');

        // Show loading effect
        tableContent.style.opacity = '0.5';

        const params = new URLSearchParams({
            search: search,
            type: currentFilter,
            page: page
        });

        fetch('{{ route("admin.api.log-aktiviti") }}?' + params, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                tableContent.innerHTML = data.html;
                document.getElementById('paginationContainer').innerHTML = data.pagination;
            } else {
                tableContent.innerHTML = '<div class="no-data"><i class="fas fa-exclamation-circle"></i><p>' + data.message + '</p></div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            tableContent.innerHTML = '<div class="no-data"><i class="fas fa-exclamation-circle"></i><p>Terjadi kesalahan saat memuat data</p></div>';
        })
        .finally(() => {
            tableContent.style.opacity = '1';
        });
    }
</script>

@endsection
