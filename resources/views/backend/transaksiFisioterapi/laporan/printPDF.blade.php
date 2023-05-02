<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Fisioterapi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 5px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            text-align: left;
        }

        h2 {
            font-size: 18px;
            margin-top: 0;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .mb-10 {
            margin-bottom: 10px;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Transaksi Fisioterapi</h2>
    <h4>Tanggal: {{ $start_date }} - {{ $end_date }}</h4>       
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pasien</th>
                <th>Perawat</th>
                <th>Dokter</th>
                <th>Layanan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totals = []; // array untuk menyimpan total setiap layanan
            ?>
            @forelse($transaksiFisioterapi as $row)
                <?php
                // tambahkan jumlah transaksi pada layanan yang bersangkutan
                if (!isset($totals[$row->fisioterapi->name])) {
                    $totals[$row->fisioterapi->name] = 1;
                } else {
                    $totals[$row->fisioterapi->name] += 1;
                }
                ?>
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $row->pasien->name }}</td>
                    <td>{{ $row->perawat->name }}</td>
                    <td>{{ $row->dokter->name }}</td>
                    <td>{{ $row->fisioterapi->name }}</td>
                    @if ($row->status == 0)
                        <td>Aktif</td>
                    @elseif($row->status == 1)
                        <td>Pending</td>
                    @else
                        <td>Tidak Aktif</td>
                    @endif
                </tr>
            @empty
                <td colspan="6" style="text-align:center;">Data tidak tersedia</td>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total:</th>
                <td>
                    <table>
                        @foreach ($totals as $layanan => $jumlah)
                            <tr>
                                <td>{{ $layanan }}</td>
                                <td>{{ $jumlah }}</td>
                            </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
