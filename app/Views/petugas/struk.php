<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        /* Modern Receipt Styling */
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;700&display=swap');

        body { 
            background-color: #f4f4f4; 
            font-family: 'Fira Code', monospace; 
            display: flex; 
            justify-content: center; 
            padding: 40px;
        }

        .receipt-card {
            width: 320px;
            background: white;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 4px;
            position: relative;
        }

        .header { text-align: center; margin-bottom: 20px; }
        .header h3 { margin: 0; font-size: 1.2rem; letter-spacing: 1px; }
        .header p { margin: 5px 0; font-size: 0.8rem; color: #666; }

        .divider { border-top: 2px dashed #000; margin: 15px 0; }

        .item-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.9rem; }
        
        .total-section { 
            border-top: 2px dashed #000; 
            padding-top: 10px; 
            margin-top: 10px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .footer { text-align: center; margin-top: 30px; font-size: 0.75rem; color: #888; }

        /* Button Styling */
        .no-print { text-align: center; margin-top: 20px; }
        button, .btn-back {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
        }
        button { background: #0f172a; color: white; width: 100%; margin-bottom: 10px; }
        .btn-back { background: #e2e8f0; color: #475569; width: 100%; }

        /* PRINT OPTIMIZATION */
        @media print {
            body { background: white; padding: 0; }
            .receipt-card { box-shadow: none; width: 100%; border: none; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="receipt-card">
        <div class="header">
            <h3>PARKIR PREMIUM</h3>
            <p><?= date('d/m/Y H:i:s') ?></p>
        </div>
        
        <div class="divider"></div>

        <div class="content">
            <div class="item-row">
                <span>Plat</span>
                <span><?= strtoupper($no_polisi) ?></span>
            </div>
            <div class="item-row">
                <span>Durasi</span>
                <span><?= $transaksi['durasi'] ?> Jam</span>
            </div>
            <div class="item-row">
                <span>Jenis</span>
                <span><?= ucfirst($jenis) ?></span>
            </div>
        </div>

        <div class="total-section">
            <div class="item-row">
                <span>TOTAL</span>
                <span>Rp <?= number_format($transaksi['total_biaya'], 0, ',', '.') ?></span>
            </div>
        </div>

        <div class="footer">
            <p>TERIMA KASIH ATAS KUNJUNGAN ANDA</p>
            <p>Struk ini adalah bukti pembayaran sah</p>
        </div>

        <div class="no-print">
            <button onclick="window.print()">CETAK STRUK</button>
            <a href="<?= base_url('petugas/keluar') ?>" class="btn-back">KEMBALI</a>
        </div>
    </div>

</body>
</html>