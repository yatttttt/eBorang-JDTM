@extends('layout.app')
@section('title', 'Admin Dashboard')
@section('content')
<style>
    body {
        background: linear-gradient(135deg, #003366 0%, #000000ff 100%);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    .dashboard-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 2rem;
        padding: 0 1rem;
        position: relative;
        z-index: 1;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 3rem;
        margin-bottom: 2rem;
        width: 100%;
        max-width: 1200px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.18);
        position: relative;
        overflow: hidden;
    }

    .glass-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    }

    .dashboard-title {
        color: #ffffff;
        text-align: center;
        margin-bottom: 1rem;
        margin-top: 0;
        font-weight: 700;
        font-size: 2.5rem;
        letter-spacing: 2px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        background: linear-gradient(135deg, #ffffff, #e0e7ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        position: relative;
    }

    .dashboard-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        border-radius: 2px;
    }

    .dashboard-subtitle {
        text-align: center;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 3rem;
        font-size: 1.2rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        line-height: 1.6;
    }

    .status-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .status-card {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 
            0 8px 25px rgba(0, 0, 0, 0.1),
            inset 0 1px 0 rgba(255, 255, 255, 0.2);
    }

    .status-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.6s ease;
    }

    .status-card:hover::before {
        left: 100%;
    }

    .status-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 
            0 15px 40px rgba(0, 0, 0, 0.2),
            inset 0 1px 0 rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .status-label {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.9);
        margin-bottom: 1rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .status-value {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    .status-card.total .status-value { 
        color: #60a5fa;
        text-shadow: 0 0 20px rgba(96, 165, 250, 0.5);
    }
    .status-card.lulus .status-value { 
        color: #34d399;
        text-shadow: 0 0 20px rgba(52, 211, 153, 0.5);
    }
    .status-card.ditolak .status-value { 
        color: #f87171;
        text-shadow: 0 0 20px rgba(248, 113, 113, 0.5);
    }
    .status-card.kiv .status-value { 
        color: #fbbf24;
        text-shadow: 0 0 20px rgba(251, 191, 36, 0.5);
    }

    .status-card.total {
        background: rgba(96, 165, 250, 0.2);
        border-color: rgba(96, 165, 250, 0.3);
    }
    .status-card.lulus {
        background: rgba(52, 211, 153, 0.2);
        border-color: rgba(52, 211, 153, 0.3);
    }
    .status-card.ditolak {
        background: rgba(248, 113, 113, 0.2);
        border-color: rgba(248, 113, 113, 0.3);
    }
    .status-card.kiv {
        background: rgba(251, 191, 36, 0.2);
        border-color: rgba(251, 191, 36, 0.3);
    }

    .chart-container {
        position: relative;
        height: 420px;
        margin-top: 2rem;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        padding: 1.75rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.18);
    }

    .divider {
        border: none;
        height: 3px;
        background: linear-gradient(90deg, transparent, #0099FF, transparent);
        margin: 3rem 0;
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
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
    }

    .chart-title {
        text-align: center;
        color: #ffffff;
        margin-bottom: 2rem;
        font-size: 1.8rem;
        font-weight: 600;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        letter-spacing: 1px;
    }

    .error-message {
        background: rgba(248, 113, 113, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(248, 113, 113, 0.4);
        color: #fca5a5;
        padding: 1.5rem;
        border-radius: 15px;
        text-align: center;
        margin-bottom: 2rem;
        font-weight: 500;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        box-shadow: 0 4px 15px rgba(248, 113, 113, 0.2);
    }

    /* Chart Canvas Styling */
    #permohonanChart {
        filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
    }

    /* No Data Message Styling */
    .no-data-message {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 200px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .no-data-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-container {
            margin-top: 1rem;
            padding: 0 0.5rem;
        }

        .glass-card {
            padding: 2rem;
            border-radius: 20px;
        }

        .status-cards {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .status-card {
            padding: 1.5rem;
        }

        .status-value {
            font-size: 2.2rem;
        }

        .dashboard-title {
            font-size: 2.2rem;
            letter-spacing: 1px;
        }

        .dashboard-subtitle {
            font-size: 1.1rem;
            margin-bottom: 2rem;
        }

        .chart-container {
            height: 350px;
            padding: 1.5rem;
        }

        .chart-title {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .glass-card {
            padding: 1.5rem;
            margin: 1rem 0.25rem;
        }

        .status-cards {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .status-card {
            padding: 1.25rem;
        }

        .status-value {
            font-size: 2rem;
        }

        .dashboard-title {
            font-size: 2rem;
        }

        .chart-container {
            height: 300px;
            padding: 1rem;
        }
    }
</style>

<div class="dashboard-container">
    <div class="glass-card">
        <h1 class="dashboard-title"><i class="fas fa-home"></i> Admin Dashboard</h1>
        <p class="dashboard-subtitle">Urus pengguna, lihat laporan, dan status permohonan di sini.</p>
        
        @if(isset($error))
            <div class="error-message">
                <strong> Error:</strong> {{ $error }}
            </div>
        @endif
        
        <div class="status-cards">
            <div class="status-card total">
                <div class="status-label">Jumlah Permohonan</div>
                <div class="status-value">{{ $total ?? 0 }}</div>
            </div>
            <div class="status-card lulus">
                <div class="status-label">Permohonan Lulus</div>
                <div class="status-value">{{ $lulus ?? 0 }}</div>
            </div>
            <div class="status-card kiv">
                <div class="status-label">Permohonan KIV</div>
                <div class="status-value">{{ $kiv ?? 0 }}</div>
            </div>
            <div class="status-card ditolak">
                <div class="status-label">Permohonan Ditolak</div>
                <div class="status-value">{{ $ditolak ?? 0 }}</div>
            </div>
        </div>
        
        <hr class="divider">
        
        <h3 class="chart-title">Carta Status Permohonan</h3>
        <div class="chart-container">
            <canvas id="permohonanChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const permohonanData = @json($permohonanData);

    // Only create chart if there's data
    if (permohonanData && permohonanData.total > 0) {
        const ctx = document.getElementById('permohonanChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [' Permohonan Lulus', ' Permohonan KIV', 'Permohonan Ditolak'],
                datasets: [{
                    data: [permohonanData.lulus, permohonanData.kiv, permohonanData.ditolak],
                    backgroundColor: [
                        'rgba(52, 211, 153, 0.8)',
                        'rgba(251, 191, 36, 0.8)',
                        'rgba(248, 113, 113, 0.8)'
                    ],
                    borderColor: [
                        'rgba(52, 211, 153, 1)',
                        'rgba(251, 191, 36, 1)',
                        'rgba(248, 113, 113, 1)'
                    ],
                    borderWidth: 3,
                    hoverOffset: 15,
                    cutout: '60%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            color: '#ffffff',
                            font: {
                                size: 14,
                                weight: '600'
                            },
                            padding: 25,
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
                        cornerRadius: 10,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const total = permohonanData.lulus + permohonanData.ditolak + permohonanData.kiv;
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return context.label + ': ' + context.raw + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 900,
                    easing: 'easeOutCubic'
                },
                elements: {
                    arc: {
                        borderWidth: 3,
                        hoverBorderWidth: 4
                    }
                }
            }
        });
    } else {
        // Show styled no data message  
        const chartContainer = document.querySelector('.chart-container');
        chartContainer.innerHTML = `
            <div class="no-data-message">
                <div class="no-data-icon">📊</div>
                <div>Tiada Data Tersedia</div>
            </div>
        `;
    }

    // Counter animation 
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('.status-value');

        counters.forEach((counter, index) => {
            const target = parseInt(counter.textContent);
            if (isNaN(target)) return;

            const duration = 1000; // 1s per counter
            const startTimeDelay = performance.now() + index * 120;
            const startValue = 0;

            function animate(now) {
                // Tunggu sehingga delay untuk counter ini
                if (now < startTimeDelay) {
                    requestAnimationFrame(animate);
                    return;
                }

                const elapsed = now - startTimeDelay;
                const progress = Math.min(elapsed / duration, 1);

                const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
                const current = Math.floor(startValue + (target - startValue) * eased);
                counter.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(animate);
                }
            }

            // Mula animasi
            requestAnimationFrame(animate);
        });
    });
</script>
@endsection