<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Bandara</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Tambahkan CSS DataTables -->
    <link href="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <style>
       /* CSS tambahan untuk penataan */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298); /* Gradient background yang lebih modern */
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* Animasi untuk judul */
        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling untuk judul halaman */
        h1 {
            font-size: 2.5rem;
            color: rgb(14, 13, 13);
            margin-bottom: 30px;
            text-align: center;
            font-weight: 600;
            animation: fadeInUp 1.5s ease-out;
        }

        /* Styling untuk kontainer */
        .container {
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        /* Menyusun filter dan search sejajar */
        .form-group {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group select,
        .form-group input {
            width: 48%; /* Setengah lebar agar sejajar */
        }

        .form-group .btn {
            width: 48%; /* Tombol juga ikut setengah lebar */
        }

        /* Styling tabel */
        .table {
            width: 100%;
            margin-top: 20px;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Animasi untuk header tabel */
        @keyframes slideInLeft {
            0% {
                opacity: 0;
                transform: translateX(-30px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Styling header tabel */
        .table th {
            background-color: #234972;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
            animation: slideInLeft 1s ease-out;
        }

        /* Styling tabel */
        .table th, .table td {
            text-align: center;
            padding: 15px;
            vertical-align: middle;
            font-size: 14px;
        }

        /* Hover efek pada tabel */
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .table-dark {
            background-color: #343a40;
            color: #fff;
        }

        .table tbody tr:hover {
            background-color: #e2e2e2;
        }

        /* Tombol */
        .btn {
            transition: background-color 0.3s ease, transform 0.3s ease;
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #2a5298;
            border-color: #2a5298;
        }

        .btn-primary:hover {
            background-color: #1e3c72;
            transform: scale(1.05);
        }

        /* Responsif untuk tabel */
        .table-responsive {
            margin-top: 20px;
            animation: fadeInUp 1.5s ease-out;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            h1 {
                font-size: 1.8rem;
            }

            .form-group select,
            .form-group input,
            .form-group .btn {
                width: 100%; /* Full width di perangkat kecil */
            }

            .table th, .table td {
                padding: 10px;
                font-size: 12px;
            }
        }


    </style>
</head>
<body>
<div class="container">
    <h1>

        <i class="bi bi-airplane-engines-fill " alt="Airport Icon" style="width: 40px; vertical-align: middle; margin-right: 10px;"></i> Daftar Bandara Internasional
    </h1>
    
    <!-- Filter dan Pencarian -->
    <div class="row mb-3 mt-3">
        <div class="col-md-6">
            <form action="{{ route('airports.index') }}" method="GET">
                <!-- Dropdown Filter Negara -->
                <select class="form-select" name="country" onchange="this.form.submit()">
                    <option value="">Pilih Negara</option>
                    <option value="Argentina">Argentina</option>
                    <option value="Australia">Australia</option>
                    <option value="Brazil">Brasil</option>
                    <option value="Canada">Kanada</option>
                    <option value="China">Tiongkok</option>
                    <option value="France">Prancis</option>
                    <option value="Germany">Jerman</option>
                    <option value="India">India</option>
                    <option value="Indonesia">Indonesia</option>
                    <option value="Italy">Italia</option>
                    <option value="Japan">Jepang</option>
                    <option value="Mexico">Meksiko</option>
                    <option value="Russia">Rusia</option>
                    <option value="Singapore">Singapura</option>
                    <option value="South Africa">Afrika Selatan</option>
                    <option value="Spain">Spanyol</option>
                    <option value="Thailand">Thailand</option>
                    <option value="United Kingdom">Inggris</option>
                    <option value="United States">Amerika Serikat</option>
                </select>
            </form>
        </div>

        <div class="col-md-6">
            <form action="{{ route('airports.index') }}" method="GET">
                <!-- Pencarian Bandara -->
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Cari bandara..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    @if (!empty($airports['rows']) && count($airports['rows']) > 0)
        <div class="table-responsive">
            <table id="airportsTable" class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Bandara</th>
                        <th>Kode IATA</th>
                        <th>Kode ICAO</th>
                        <th>Kota</th>
                        <th>Negara</th>
                        <th>Garis Lintang (Latitude)</th>
                        <th>Garis Bujur (Longitude)</th>
                        <th>Ketinggian (m)</th>
                        <th>Zona Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($airports['rows'] as $airport)
                        <tr>
                            <td>{{ $airport['id'] }}</td>
                            <td>{{ $airport['name'] }}</td>
                            <td>{{ $airport['iata'] }}</td>
                            <td>{{ $airport['icao'] }}</td>
                            <td>{{ $airport['city'] }}</td>
                            <td>{{ $airport['country'] }}</td>
                            <td>{{ $airport['lat'] }}</td>
                            <td>{{ $airport['lon'] }}</td>
                            <td>{{ $airport['alt'] }}</td>
                            <td>{{ $airport['timezone']['abbrName'] }} ({{ $airport['timezone']['offsetHours'] }})</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning">Tidak ada data bandara yang tersedia.</div>
    @endif
</div>

<!-- Tambahkan JS DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-bs5@1.12.1/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#airportsTable').DataTable({
            "pageLength": 10,  // Menampilkan 15 data per halaman
            "lengthChange": false,  // Menonaktifkan pilihan jumlah baris
            "searching": false,  // Aktifkan pencarian di tabel
            "ordering": true,  // Aktifkan pengurutan kolom
            "info": true,  // Menampilkan informasi jumlah data
            "language": {
                "lengthMenu": "Menampilkan _MENU_ baris per halaman",
                "zeroRecords": "Tidak ada data yang cocok",
                "info": "Menampilkan _PAGE_ dari _PAGES_",
                "infoEmpty": "Tidak ada data tersedia",
                "infoFiltered": "(disaring dari _MAX_ total entri)"
            }
        });
    });
</script>

</body>
</html>
