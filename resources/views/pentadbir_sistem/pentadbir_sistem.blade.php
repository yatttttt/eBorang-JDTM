@extends('layout.app')
@section('title', 'Dashboard Pentadbir Sistem')
@section('content')
<style>
    body {
        background: linear-gradient(135deg, #003366 0%, #000000ff 100%) !important;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
        z-index: 1;
    }

    .welcome-header {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: fadeInScale 0.8s ease forwards;
    }

    .welcome-header h1 {
        color: #ffffff;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #ffffff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
        display: flex;              
        align-items: center;
        gap: 1rem;      
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: fadeInScale 0.8s ease forwards;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.6s ease;
    }

    .stat-card:hover::before {
        left: 100%;
    }

    .stat-card:nth-child(1) { animation-delay: 0.1s; }
    .stat-card:nth-child(2) { animation-delay: 0.2s; }
    .stat-card:nth-child(3) { animation-delay: 0.3s; }
    .stat-card:nth-child(4) { animation-delay: 0.4s; }

    .stat-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-icon.total {
        background: rgba(96, 165, 250, 0.3);
        color: #60a5fa;
    }

    .stat-icon.approved {
        background: rgba(52, 211, 153, 0.3);
        color: #34d399;
    }

    .stat-icon.kiv {
        background: rgba(251, 191, 36, 0.3);
        color: #fbbf24;
    }

    .stat-icon.rejected {
        background: rgba(248, 113, 113, 0.3);
        color: #f87171;
    }

    .stat-info h3 {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .stat-number {
        color: #ffffff;
        font-size: 3rem;
        font-weight: 800;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        opacity: 0;
        animation: countUp 1s ease-out forwards;
        animation-delay: 0.5s;
    }

    .stat-card.total {
        background: rgba(96, 165, 250, 0.2);
        border-color: rgba(96, 165, 250, 0.3);
    }

    .stat-card.total .stat-number {
        color: #60a5fa;
        text-shadow: 0 0 20px rgba(96, 165, 250, 0.5);
    }

    .stat-card.approved {
        background: rgba(52, 211, 153, 0.2);
        border-color: rgba(52, 211, 153, 0.3);
    }

    .stat-card.approved .stat-number {
        color: #34d399;
        text-shadow: 0 0 20px rgba(52, 211, 153, 0.5);
    }

    .stat-card.kiv {
        background: rgba(251, 191, 36, 0.2);
        border-color: rgba(251, 191, 36, 0.3);
    }

    .stat-card.kiv .stat-number {
        color: #fbbf24;
        text-shadow: 0 0 20px rgba(251, 191, 36, 0.5);
    }

    .stat-card.rejected {
        background: rgba(248, 113, 113, 0.2);
        border-color: rgba(248, 113, 113, 0.3);
    }

    .stat-card.rejected .stat-number {
        color: #f87171;
        text-shadow: 0 0 20px rgba(248, 113, 113, 0.5);
    }

    .divider {
        border: none;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        margin: 3rem auto;
        border-radius: 2px;
        position: relative;
    }

    .divider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #0099FF;
        box-shadow: 0 0 10px rgba(0, 153, 255, 0.5);
    }

    .chart-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.18);
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 
            0 8px 32px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
        opacity: 0;
        animation: fadeInScale 0.8s ease forwards 0.6s;
    }

    .chart-header {
        margin-bottom: 1.5rem;
    }

    .chart-header h2 {
        color: #ffffff;
        font-size: 1.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: 1px;
    }

    .chart-header h2 i {
        color: #60a5fa;
    }

    canvas {
        max-height: 400px;
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.8) translateY(30px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes countUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .welcome-header {
            padding: 2rem;
            border-radius: 20px;
        }

        .welcome-header h1 {
            font-size: 2rem;
        }

        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2.2rem;
        }

        .chart-container {
            padding: 1.5rem;
        }

        .chart-header h2 {
            font-size: 1.5rem;
        }

        canvas {
            max-height: 300px;
        }
    }

    @media (max-width: 480px) {
        .welcome-header {
            padding: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1.25rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .chart-container {
            padding: 1rem;
        }

        canvas {
            max-height: 250px;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Welcome Header -->
    <div class="welcome-header">
        <h1><i class="fas fa-home"></i> Dashboard Pentadbir Sistem</h1>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-header">
                <div class="stat-icon total">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="stat-info">
                    <h3>Jumlah Permohonan</h3>
                </div>
            </div>
            <div class="stat-number" data-target="{{ $total }}">0</div>
        </div>

        <div class="stat-card approved">
            <div class="stat-header">
                <div class="stat-icon approved">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Permohonan Lulus</h3>
                </div>
            </div>
            <div class="stat-number" data-target="{{ $lulus }}">0</div>
        </div>

        <div class="stat-card kiv">
            <div class="stat-header">
                <div class="stat-icon kiv">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Permohonan KIV</h3>
                </div>
            </div>
            <div class="stat-number" data-target="{{ $kiv }}">0</div>
        </div>

        <div class="stat-card rejected">
            <div class="stat-header">
                <div class="stat-icon rejected">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Permohonan Ditolak</h3>
                </div>
            </div>
            <div class="stat-number" data-target="{{ $tolak }}">0</div>
        </div>
    </div>

    <hr class="divider">

    <!-- Chart Section -->
    <div class="chart-container">
        <div class="chart-header">
            <h2><i class="fas fa-chart-bar"></i> Statistik Status Permohonan Diluluskan</h2>
        </div>
        <canvas id="statusChart"></canvas>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Animated Counter
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.stat-number');
        
        counters.forEach((counter, index) => {
            const target = parseInt(counter.getAttribute('data-target'));
            const duration = 1500;
            const step = target / (duration / 16);
            let current = 0;
            
            setTimeout(() => {
                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        counter.textContent = target;
                        clearInterval(timer);
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 16);
            }, index * 200 + 800);
        });
    });

    // Chart Configuration
    const ctx = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jumlah Permohonan', 'Lulus', 'KIV', 'Ditolak'],
            datasets: [{
                label: ' Bilangan Permohonan',
                data: [
                    {{ $total }}, 
                    {{ $lulus }}, 
                    {{ $kiv }}, 
                    {{ $tolak }}
                ],
                backgroundColor: [
                    'rgba(96, 165, 250, 0.8)',
                    'rgba(52, 211, 153, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(248, 113, 113, 0.8)'
                ],
                borderColor: [
                    'rgba(96, 165, 250, 1)',
                    'rgba(52, 211, 153, 1)',
                    'rgba(251, 191, 36, 1)',
                    'rgba(248, 113, 113, 1)'
                ],
                borderWidth: 3,
                borderRadius: 10,
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#ffffff',
                        font: {
                            size: 14,
                            weight: '600'
                        },
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: 'rgba(255, 255, 255, 0.2)',
                    borderWidth: 1,
                    padding: 12,
                    cornerRadius: 10,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' permohonan';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: '#ffffff',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        stepSize: 1
                    },
                    grid: {
                        color: 'rgba(255, 255, 255, 0.1)',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#ffffff',
                        font: {
                            size: 12,
                            weight: 'bold'
                        }
                    },
                    grid: {
                        display: false
                    }
                }
            },
            animation: {
                duration: 2000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>
@endsection