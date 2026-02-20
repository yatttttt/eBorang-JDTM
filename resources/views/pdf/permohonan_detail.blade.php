<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Permohonan - {{ $permohonan->id_permohonan }}</title>

   <style>
    @page { margin: 20mm 15mm; }
    body {
        font-family: 'DejaVu Sans', Arial, sans-serif;
        font-size: 10pt;
        color: #000;
        position: relative;
    }

    /* HEADER */
    .header {
        text-align: center;
        margin-bottom: 10px;
    }

    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        margin-bottom: 10px;
    }

    .header img { 
        height: 90px;
        display: inline-block;
        vertical-align: middle;
    }
    .header h1 { font-size: 16pt; color: #003366; margin: 5px 0; }
    .header h2 { font-size: 11pt; color: #555; margin: 2px 0; }

    /* SECTION */
    .section {
        margin-top: 12px;
        border: 1px solid #000;
        padding: 0;
        page-break-inside: avoid;
    }

    /* SECTION WITH POTENTIAL PAGE BREAK */
    .section-with-break {
        margin-top: 12px;
        border: 1px solid #000;
        padding: 0;
        page-break-inside: auto;
    }

    .section-title {
        background: #fcd46d;
        font-weight: bold;
        text-align: center;
        padding: 6px;
        margin: 0;
        border: none;
        border-bottom: 1px solid #000; 
        letter-spacing: 0.5px;
        page-break-after: avoid;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    td {
        padding: 8px 10px;
        vertical-align: top;
        border: none;
    }

    td.label { 
        width: 30%; 
        font-weight: bold;
        padding-left: 10px;
    }
    td.value { 
        width: 70%;
        padding-right: 10px;
    }

    /* ULASAN SECTIONS */
    .review-table {
        margin: 0;
    }

    .review-table td {
        vertical-align: top;
        padding: 15px;
        border: none;
    }

    .signature-area {
        width: 60%;
        border-right: 1px solid #000;
        padding: 15px;
    }

    .comment-area {
        width: 40%;
        padding: 15px;
    }

    .signature-line {
        display: block;
        width: 40%;
        border-bottom: 1px solid #000;
        margin: 10px 0 5px 0;
    }
    .signature-label {
        font-size: 9pt;
        margin-top: 2px;
    }

    .comment-box {
        border: 1px solid #000;
        padding: 8px;
        border-radius: 2px;
    }

    .comment-box strong {
        display: inline-block;
        margin-bottom: 3px;
    }

    .status-options {
        margin-bottom: 6px;
        line-height: 1.6;
    }

    .ulasan-text {
        border: 1px solid #000;
        min-height: 60px;
        padding: 6px;
        margin-top: 3px;
    }

    /* TABLE BORDERS */
    .table-bordered {
        border-collapse: collapse;
        margin: 0;
        page-break-inside: auto;
    }
    
    .table-bordered thead {
        display: table-header-group;
        page-break-inside: avoid;
        page-break-after: avoid;
    }
    
    .table-bordered tbody {
        display: table-row-group;
    }
    
    .table-bordered tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    .table-bordered td, 
    .table-bordered th {
        border: 1px solid #000;
        padding: 8px;
        font-size: 9pt;
    }
    
    .table-header {
        background: #fcd46d;
        font-weight: bold;
        text-align: center;
        padding: 8px;
    }

    /* MAKLUMAT AKSES SECTION - ALLOW PAGE BREAKS */
    .maklumat-akses-section {
        margin-top: 12px;
        page-break-before: auto;
        page-break-inside: auto;
    }

    .force-new-page {
        page-break-before: always;
    }

    /* FOOTER */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 8pt;
        color: #666;
        padding: 8px 0;
        border-top: 1px solid #ccc;
        background: #fff;
    }
    
    /* SPACING */
    .section + .section,
    .section + .section-with-break,
    .section-with-break + .section {
        margin-top: 20px;
    }

    /* NO DATA STYLE */
    .no-data {
        font-style: italic;
        color: #666;
    }

    /* AKSES INFO TABLE */
    .akses-info-table {
        margin-top: 10px;
        border: none;
        page-break-inside: avoid;
    }

    .akses-info-table td {
        border: none;
        padding: 4px 10px;
    }

    /* Page number for multiple pages */
    .page-info {
        text-align: center;
        font-size: 8pt;
        color: #666;
        margin-top: 10px;
        page-break-inside: avoid;
    }

    /* Debug box */
    .debug-box {
        background: #ffe6e6;
        border: 2px solid #ff0000;
        padding: 10px;
        margin: 10px 0;
        font-size: 9pt;
    }
</style>
</head>
<body>

    @php
        // Convert logo MBSA to base64
        $logoMbsaPath = public_path('images/logo_mbsa.png');
        if(file_exists($logoMbsaPath)) {
            $type = pathinfo($logoMbsaPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoMbsaPath);
            $base64 = base64_encode($data);
            $logoMbsaSrc = 'data:image/' . $type . ';base64,' . $base64;
        } else {
            $logoMbsaSrc = null;
        }

        // Convert logo JDTM to base64
        $logoJdtmPath = public_path('images/logo_JDTM.png');
        if(file_exists($logoJdtmPath)) {
            $type = pathinfo($logoJdtmPath, PATHINFO_EXTENSION);
            $data = file_get_contents($logoJdtmPath);
            $base64 = base64_encode($data);
            $logoJdtmSrc = 'data:image/' . $type . ';base64,' . $base64;
        } else {
            $logoJdtmSrc = null;
        }

        // Better handling of maklumat_akses data with key normalization & multi-category support
        $aksesSections = [];
        $totalMaklumatAkses = 0;
        
        if (!empty($permohonan->maklumat_akses) && is_array($permohonan->maklumat_akses)) {
            $rawData = $permohonan->maklumat_akses;
            $currentKategori = is_array($permohonan->kategori) ? ($permohonan->kategori[0] ?? null) : $permohonan->kategori;
            
            $normalize = function($str) {
                return str_replace(['\\/', '/'], ['/', '/'], trim((string) $str));
            };
            
            $normalizedCurrentKategori = $normalize($currentKategori ?: 'Maklumat Akses');
            $isAssociative = array_values($rawData) !== $rawData;

            if ($isAssociative) {
                foreach ($rawData as $kategoriKey => $entries) {
                    $entriesList = [];
                    
                    if (is_array($entries)) {
                        foreach ($entries as $entry) {
                            if (is_array($entry)) {
                                $entriesList[] = $entry;
                            }
                        }
                    }

                    $aksesSections[] = [
                        'kategori' => $normalize($kategoriKey),
                        'entries' => $entriesList,
                    ];

                    $totalMaklumatAkses += count($entriesList);
                }
            } else {
                $entriesList = [];
                foreach ($rawData as $entry) {
                    if (is_array($entry)) {
                        $entriesList[] = $entry;
                    }
                }

                if (!empty($entriesList)) {
                    $aksesSections[] = [
                        'kategori' => $normalizedCurrentKategori,
                        'entries' => $entriesList,
                    ];

                    $totalMaklumatAkses += count($entriesList);
                }
            }
        }
        
        $hasMaklumatAkses = !empty($aksesSections) && $totalMaklumatAkses > 0;
        $forceNewPage = $totalMaklumatAkses > 2;
        $kategoriEmelConst = strtolower(\App\Models\Permohonan::KATEGORI_EMEL);
        $kategoriSistemConst = strtolower(\App\Models\Permohonan::KATEGORI_SISTEM_APLIKASI);
        $kategoriServerConst = strtolower(\App\Models\Permohonan::KATEGORI_SERVER);
    @endphp

    <!-- HEADER -->
    <div class="header">
        <div class="logo-container">
            @if($logoMbsaSrc)
                <img src="{{ $logoMbsaSrc }}" alt="Logo MBSA">
            @endif
            
            @if($logoJdtmSrc)
                <img src="{{ $logoJdtmSrc }}" alt="Logo JDTM">
            @endif
        </div>
        
        @if(!$logoMbsaSrc || !$logoJdtmSrc)
            <p style="color:red;">
                @if(!$logoMbsaSrc) Logo MBSA tidak dijumpai. @endif
                @if(!$logoJdtmSrc) Logo JDTM tidak dijumpai. @endif
            </p>
        @endif
        
        <h1>MAJLIS BANDARAYA SHAH ALAM</h1>
        <h2>JABATAN DIGITAL & TEKNOLOGI MAKLUMAT</h2>
        <h2>LAPORAN MAKLUMAT PERMOHONAN</h2>
    </div>

    <!-- MAKLUMAT PERMOHONAN -->
    <div class="section">
        <div class="section-title">MAKLUMAT PERMOHONAN</div>
        <table>
            <tr><td class="label">ID Permohonan:</td><td class="value">{{ $permohonan->id_permohonan }}</td></tr>
            <tr><td class="label">NO Kawalan:</td><td class="value">{{ $permohonan->no_kawalan }}</td></tr>
            <tr><td class="label">Jenis Permohonan:</td><td class="value">{{ is_array($permohonan->jenis_permohonan) ? implode(', ', $permohonan->jenis_permohonan) : $permohonan->jenis_permohonan }}</td></tr>
            <tr><td class="label">Nama Pemohon:</td><td class="value">{{ $permohonan->nama_pemohon }}</td></tr>
            <tr><td class="label">Jabatan:</td><td class="value">{{ $permohonan->jabatan }}</td></tr>
            <tr><td class="label">Kategori:</td><td class="value">{{ $permohonan->formatted_kategori }}</td></tr>
            <tr><td class="label">Subkategori:</td><td class="value">{{ isset($permohonan->subkategori) ? trim($permohonan->formatted_subkategori, '[]"') : '-' }}</td></tr>
            <tr><td class="label">Tarikh Hantar:</td><td class="value">{{ $permohonan->tarikh_hantar ? $permohonan->tarikh_hantar->format('d/m/Y') : '-' }}</td></tr>
        </table>
    </div>

    <!-- FUNGSI ULASAN (Diguna semula untuk Pengarah / Pegawai / Pentadbir Sistem) -->
    @php
        $ulasanList = [
            ['tajuk' => 'ULASAN & TINDAKAN PENGARAH', 'user' => $permohonan->userPengarah, 'jawatanDefault' => 'Pengarah', 'status' => $permohonan->status_pengarah, 'tarikh' => $permohonan->tarikh_ulasan_pengarah, 'ulasan' => $permohonan->ulasan_pengarah],
            ['tajuk' => 'ULASAN & TINDAKAN PEGAWAI', 'user' => $permohonan->userPegawai, 'jawatanDefault' => 'Pegawai', 'status' => $permohonan->status_pegawai, 'tarikh' => $permohonan->tarikh_ulasan_pegawai, 'ulasan' => $permohonan->ulasan_pegawai],
            ['tajuk' => 'ULASAN & TINDAKAN PENTADBIR SISTEM', 'user' => $permohonan->userPentadbirSistem, 'jawatanDefault' => 'Pentadbir Sistem', 'status' => $permohonan->status_pentadbir_sistem, 'tarikh' => $permohonan->tarikh_ulasan_pentadbir_sistem, 'ulasan' => $permohonan->ulasan_pentadbir_sistem],
        ];
    @endphp

    @foreach($ulasanList as $ulasan)
    @php
        $tandatanganSrc = null;

        if ($ulasan['user'] && !empty($ulasan['user']->tandatangan)) {
            // Laluan penuh dalam storage
            $path = storage_path('app/public/signatures/' . $ulasan['user']->tandatangan);
            if (file_exists($path)) {
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $tandatanganSrc = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }
    @endphp

    <div class="section">
        <div class="section-title">{{ $ulasan['tajuk'] }}</div>
        <table class="review-table">
            <tr>
                <td class="signature-area">
                    <strong>Tandatangan:</strong><br>
                    @if($tandatanganSrc)
                        <img src="{{ $tandatanganSrc }}" alt="Tandatangan" style="height:60px; margin:6px 0;">
                         <span class="signature-line"></span>
                    @else
                        <span class="signature-line"></span>
                    @endif

                    @if($ulasan['user'])
                        <div class="signature-label">{{ $ulasan['user']->name }}</div>
                        <div class="signature-label">{{ $ulasan['user']->jawatan ?? $ulasan['jawatanDefault'] }}</div>
                    @else
                        <div class="no-data">Tiada Maklumat</div>
                    @endif
                    <br><strong>Tarikh:</strong>
                    {{ $ulasan['tarikh'] ? $ulasan['tarikh']->format('d/m/Y') : '____________________' }}
                </td>

                <td class="comment-area">
                    <div class="comment-box">
                        <div class="status-options">
                            <strong>Status:</strong><br>
                            <input type="checkbox" {{ $ulasan['status'] == 'Lulus' ? 'checked' : '' }}> Diluluskan<br>
                            <input type="checkbox" {{ $ulasan['status'] == 'Tolak' ? 'checked' : '' }}> Ditolak<br>
                            <input type="checkbox" {{ $ulasan['status'] == 'KIV' ? 'checked' : '' }}> KIV
                        </div>
                        <strong>Ulasan:</strong>
                        <div class="ulasan-text">
                            {{ $ulasan['ulasan'] ?? 'Tiada ulasan' }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    @endforeach

    <!-- MAKLUMAT AKSES (MULTIPLE ACCOUNTS SUPPORT WITH PAGE BREAK) -->
    @if($hasMaklumatAkses)
        <div class="section-with-break maklumat-akses-section {{ $forceNewPage ? 'force-new-page' : '' }}">
            <div class="section-title">
                MAKLUMAT AKSES ({{ $totalMaklumatAkses }} AKAUN)
            </div>

            @foreach($aksesSections as $section)
                @php
                    $kategoriLabel = $section['kategori'] ?: 'Maklumat Akses';
                    $entries = $section['entries'];
                    $kategoriLower = strtolower($kategoriLabel);
                    $isEmel = $kategoriLower === $kategoriEmelConst;
                    $isSystem = in_array($kategoriLower, [$kategoriSistemConst, $kategoriServerConst], true);
                    $columnCount = $isEmel ? 3 : 4;
                @endphp

                <table class="table-bordered">
                    <thead>
                        <tr>
                            <td class="table-header" colspan="{{ $columnCount }}" style="text-align: left;">
                                {{ strtoupper($kategoriLabel) }} ({{ count($entries) }} AKAUN)
                            </td>
                        </tr>
                        <tr class="table-header">
                            <td style="width: 10%; text-align: center;">BIL</td>
                            @if($isEmel)
                                <td style="width: 45%;">ID EMEL</td>
                                <td style="width: 45%;">KATA LALUAN</td>
                            @elseif($isSystem)
                                <td style="width: 30%;">ID PENGGUNA</td>
                                <td style="width: 32%;">KATA LALUAN</td>
                                <td style="width: 30%;">KUMPULAN CAPAIAN</td>
                            @else
                                <td style="width: 35%;">ID AKSES</td>
                                <td style="width: 35%;">KATA LALUAN</td>
                                <td style="width: 30%;">MAKLUMAT TAMBAHAN</td>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $index => $akses)
                            <tr>
                                <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                                @if($isEmel)
                                    <td>{{ $akses['id_emel'] ?? '-' }}</td>
                                    <td>{{ $akses['kata_laluan'] ?? '-' }}</td>
                                @elseif($isSystem)
                                    <td>{{ $akses['id_pengguna'] ?? '-' }}</td>
                                    <td>{{ $akses['kata_laluan'] ?? '-' }}</td>
                                    <td>{{ $akses['kumpulan_capaian'] ?? '-' }}</td>
                                @else
                                    <td>{{ $akses['id_pengguna'] ?? $akses['id_emel'] ?? $akses['akaun'] ?? '-' }}</td>
                                    <td>{{ $akses['kata_laluan'] ?? '-' }}</td>
                                    <td>{{ $akses['kumpulan_capaian'] ?? $akses['catatan'] ?? $akses['nota'] ?? '-' }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $columnCount }}" style="text-align: center; font-style: italic; color: #666;">
                                    Tiada maklumat akses direkodkan untuk kategori ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endforeach

            <!-- Tarikh Maklumat Akses -->
            <table class="akses-info-table">
                <tr>
                    <td class="label" style="width: 30%;">Tarikh Dicipta:</td>
                    <td class="value">
                        {{ $permohonan->tarikh_maklumat_akses ? $permohonan->tarikh_maklumat_akses->format('d/m/Y') : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="label">Jumlah Akaun:</td>
                    <td class="value">{{ $totalMaklumatAkses }} akaun</td>
                </tr>
            </table>
        </div>
    @else
        <!-- SHOW MESSAGE WHEN NO DATA -->
        <div class="section">
            <div class="section-title">MAKLUMAT AKSES</div>
            <table>
                <tr>
                    <td style="text-align: center; padding: 30px; font-style: italic; color: #666;">
                        Tiada maklumat akses yang dimasukkan buat masa ini.
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <!-- FOOTER -->
    <div class="footer">
        <div>Dokumen ini dijana secara automatik oleh Sistem eBorang pada {{ now()->format('d/m/Y') }}</div>
        <div style="margin-top:4px; font-size:7pt;">
            Majlis Bandaraya Shah Alam | Jabatan Digital & Teknologi Maklumat<br>
            Pesiaran Perbandaran, Seksyen 14, 40000 Shah Alam, Selangor
        </div>
    </div>

</body>
</html>