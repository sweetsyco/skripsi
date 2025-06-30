<!DOCTYPE html>
<html>
<head>
    <title>Laporan PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; text-align: left; }
        .header { text-align: center; }
        .periode { text-align: center; margin-bottom: 20px; font-style: italic; }
        .footer { margin-top: 30px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Permintaan Distributor</h2>
        <div class="periode"><?= $periode ?></div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Komoditas</th>
                <th>Jumlah (Kg)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($laporan_permintaan)): ?>
                <?php $no = 1; foreach ($laporan_permintaan as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($item->dibuat_pada)) ?></td>
                    <td><?= $item->nama_komoditas ?></td>
                    <td><?= number_format($item->jumlah, 0, ',', '.') ?></td>
                    <td><?= $item->status ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">Tidak ada data</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: <?= date('d-m-Y H:i:s') ?></p>
    </div>
</body>
</html>