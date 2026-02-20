@if($logs->count() > 0)
    <table class="modern-table">
        <thead>
            <tr>
                <th style="width: 10%;">No. Log</th>
                <th style="width: 15%;">Nama Pengguna</th>
                <th style="width: 35%;">Tindakan</th>
                <th style="width: 25%;">Tarikh & Masa</th>
                <th style="width: 15%;">Peranan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>
                        <span class="id-badge">{{ $log->id_log }}</span>
                    </td>
                    <td>
                        <i class="fas fa-user" style="margin-right: 0.5rem; color: #60a5fa;"></i>
                        {{ $log->user->nama ?? 'N/A' }}
                    </td>
                    <td>
                        <i class="fas fa-arrow-right" style="margin-right: 0.5rem; color: #34d399;"></i>
                        {{ Str::limit($log->tindakan, 60) }}
                    </td>
                    <td>
                        <i class="fas fa-clock" style="margin-right: 0.5rem; color: #fbbf24;"></i>
                        @if($log->tarikh_aktiviti)
                            {{ $log->tarikh_aktiviti->format('d/m/Y H:i:s') }}
                        @else
                            {{ $log->created_at->format('d/m/Y H:i:s') }}
                        @endif
                    </td>
                    <td>
                        @if($log->user)
                            <span class="status-badge 
                                @if($log->user->peranan == 'admin') status-admin
                                @elseif($log->user->peranan == 'pengarah') status-pengarah
                                @elseif($log->user->peranan == 'pegawai') status-pegawai
                                @elseif($log->user->peranan == 'pentadbir_sistem') status-pentadbir
                                @else status-pegawai
                                @endif">
                                {{ $log->user->peranan == 'pentadbir_sistem' ? 'Pentadbir Sistem' : ucfirst($log->user->peranan) }}
                            </span>
                        @else
                            <span style="color: rgba(255, 255, 255, 0.5);">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">
                        <i class="fas fa-inbox"></i>
                        <p>Tiada log aktiviti ditemui</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@else
    <div class="no-data">
        <i class="fas fa-inbox"></i>
        <p>Tiada log aktiviti yang tersedia</p>
    </div>
@endif
