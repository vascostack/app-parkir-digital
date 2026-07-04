<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Parkir</title>
    <!-- Bisa panggil Bootstrap agar tabelnya tetap rapi saat dicetak -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; }
        .print-header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        @media print {
            @page { margin: 1cm; }
            body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()"> <!-- Otomatis memicu dialog print -->

    <div class="container mt-4">
        <div class="print-header">
            <h2 class="fw-bold mb-1">PRIME PARKING</h2>
            <h5 class="mb-2">Laporan Pendapatan Transaksi Selesai</h5>
            <p class="mb-0 text-muted">
                Periode: <?= date('d/m/Y', strtotime($start_date)) ?> s/d <?= date('d/m/Y', strtotime($end_date)) ?>
            </p>
        </div>

        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th class="text-center">No</th>
                    <th>ID Transaksi</th>
                    <th>Waktu Keluar</th>
                    <th>Plat Nomor</th>
                    <th>Tipe Kendaraan</th>
                    <th>Petugas (Kasir)</th>
                    <th class="text-end">Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; if(!empty($data_laporan)): ?>
                    <?php foreach($data_laporan as $row): ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>#<?= $row['id_transaksi'] ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['waktu_keluar'])) ?></td>
                        <td><?= strtoupper($row['no_polisi']) ?></td>
                        <td><?= ucfirst($row['jenis']) ?></td>
                        <td><?= $row['nama_petugas'] ?></td>
                        <td class="text-end">Rp <?= number_format($row['biaya'], 0, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4">Tidak ada transaksi lunas pada rentang tanggal ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-end fs-5">Total Pendapatan :</th>
                    <th class="text-end fs-5">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
        
        <div class="mt-5 text-end">
            <p class="mb-5">Dicetak pada: <?= date('d/m/Y H:i') ?></p>
            <p class="fw-bold">( ......................................... )</p>
            <p>Admin / Supervisor</p>
        </div>
    </div>

</body>
</html>