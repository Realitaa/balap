<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Member - {{ Auth::user()->name }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-family: Arial, sans-serif;
            }
            .card-container {
                width: 85mm; /* Lebar kartu standar (sekitar 8.5 cm) */
                height: 55mm; /* Tinggi kartu standar (sekitar 5.5 cm) */
                border: 1px solid #000;
                padding: 10mm;
                box-shadow: none;
                page-break-inside: avoid;
            }
            .print-button {
                display: none; /* Sembunyikan tombol saat mencetak */
            }
            @page {
                size: A4;
                margin: 0;
            }
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .card-container {
            width: 85mm;
            height: 55mm;
            background-color: #fff;
            border: 1px solid #000;
            padding: 10mm;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 12px;
        }
        .card-header {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5mm;
        }
        .card-body {
            display: flex;
            flex-direction: column;
            gap: 3mm;
        }
        .card-row {
            display: flex;
            justify-content: space-between;
        }
        .card-label {
            font-weight: bold;
        }
        .card-photo {
            width: 25mm;
            height: 30mm;
            object-fit: cover;
            position: absolute;
            right: 10mm;
            top: 10mm;
            border: 1px solid #ccc;
        }
        .print-button {
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="card-header">
            Kartu Member {{ config('app.name', 'Laravel') }}
        </div>
        <div class="card-body">
            <div class="card-row">
                <span class="card-label">Nama:</span>
                <span>{{ Auth::user()->name }}</span>
            </div>
            <div class="card-row">
                <span class="card-label">Email:</span>
                <span>{{ Auth::user()->email }}</span>
            </div>
            <div class="card-row">
                <span class="card-label">Tanggal Lahir:</span>
                <span>{{ Auth::user()->birthdate ? \Carbon\Carbon::parse(Auth::user()->birthdate)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
            </div>
            <div class="card-row">
                <span class="card-label">Alamat:</span>
                <span>{{ Auth::user()->address ?? '-' }}</span>
            </div>
            <div class="card-row">
                <span class="card-label">Kota:</span>
                <span>{{ Auth::user()->city ?? '-' }}</span>
            </div>
            <div class="card-row">
                <span class="card-label">Berlaku Hingga:</span>
                <span>{{ Auth::user()->expired_date ? \Carbon\Carbon::parse(Auth::user()->expired_date)->locale('id')->translatedFormat('d F Y') : '-' }}</span>
            </div>
        </div>
        @if (Auth::user()->photo)
            <img src="{{ Auth::user()->photo }}" alt="Foto {{ Auth::user()->name }}" class="card-photo">
        @endif
    </div>

    <div class="print-button">
        <button class="btn btn-primary" onclick="window.print()">Cetak Kartu</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>