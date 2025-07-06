<?php
use Dompdf\Dompdf;
use Dompdf\Options;

function generate_surat_perjanjian_pdf($data, $filename) {
    // Load autoloader Composer
    require_once FCPATH . 'vendor/autoload.php';
    
    // Setup Dompdf
    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'Arial');
    
    $dompdf = new Dompdf($options);
    
    // Buat konten HTML
    $html = surat_perjanjian_html($data);
    
    // Load HTML ke Dompdf
    $dompdf->loadHtml($html);
    
    // Setting ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'portrait');
    
    // Render PDF
    $dompdf->render();
    
    // Output PDF (download)
    $dompdf->stream($filename, array('Attachment' => 1));
}

function surat_perjanjian_html($data) {
    ob_start();
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Surat Perjanjian</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            .header { text-align: center; margin-bottom: 20px; }
            .header h1 { font-size: 16pt; margin: 0; }
            .header p { margin: 0; }
            .content { font-size: 11pt; line-height: 1.6; }
            table { width: 100%; border-collapse: collapse; }
            table td { padding: 5px; }
            .signature { margin-top: 50px; }
            .signature table td { text-align: center; width: 50%; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>SURAT PERJANJIAN KERJASAMA</h1>
            <p>Nomor: <?= $data['no_kontrak'] ?></p>
        </div>
        
        <div class="content">
            <p>Pada hari ini, tanggal <b><?= $data['tanggal_surat'] ?></b>, bertempat di AgriConnect, dibuat perjanjian kerjasama antara:</p>
            
            <table>
                <tr>
                    <td width="30%">Pihak Pertama</td>
                    <td width="70%">: <?= $data['nama_petani'] ?> (Petani)</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: <?= $data['alamat_petani'] ?></td>
                </tr>
                <tr>
                    <td>Pihak Kedua</td>
                    <td>: <?= $data['nama_distributor'] ?> (Distributor)</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>: <?= $data['alamat_distributor'] ?></td>
                </tr>
            </table>
            
            <p>Selanjutnya disebut sebagai <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b>.</p>
            <p>Kedua belah pihak sepakat untuk mengadakan perjanjian kerjasama dengan ketentuan sebagai berikut:</p>
            
            <p><b>Pasal 1: OBJEK PERJANJIAN</b></p>
            <p>PIHAK PERTAMA sepakat menjual dan PIHAK KEDUA sepakat membeli komoditas pertanian dengan ketentuan:</p>
            <table>
                <tr>
                    <td width="30%">Jenis Komoditas</td>
                    <td width="70%">: <?= $data['komoditas'] ?></td>
                </tr>
                <tr>
                    <td>Jumlah</td>
                    <td>: <?= number_format($data['jumlah'], 0) ?> kg</td>
                </tr>
                <tr>
                    <td>Harga per kg</td>
                    <td>: Rp <?= number_format($data['harga'], 0, ',', '.') ?></td>
                </tr>
                <tr>
                    <td>Total Nilai</td>
                    <td>: Rp <?= number_format($data['total'], 0, ',', '.') ?></td>
                </tr>
            </table>
            
            <p><b>Pasal 2: JANGKA WAKTU</b></p>
            <p>Perjanjian ini berlaku sejak tanggal <b><?= date('d F Y', strtotime($data['tanggal_mulai'])) ?></b> hingga <b><?= date('d F Y', strtotime($data['tanggal_berakhir'])) ?></b>.</p>
            
            <p><b>Pasal 3: PEMBAYARAN</b></p>
            <p>PIHAK KEDUA akan melakukan pembayaran sebesar <b>Rp <?= number_format($data['total'], 0, ',', '.') ?></b> kepada PIHAK PERTAMA melalui rekening yang disepakati dalam waktu 7 hari setelah penandatanganan perjanjian ini.</p>
            
            <p><b>Pasal 4: PENYERAHAN BARANG</b></p>
            <p>PIHAK PERTAMA akan menyerahkan komoditas sesuai kualitas dan kuantitas yang disepakati dalam waktu 14 hari setelah pembayaran diterima.</p>
            
            <p><b>Pasal 5: SANKSI</b></p>
            <p>Jika salah satu pihak tidak memenuhi kewajibannya, maka dikenakan sanksi berupa denda sebesar 0,5% dari nilai kontrak per hari keterlambatan.</p>
            
            <p><b>Pasal 6: PENUTUP</b></p>
            <p>Perjanjian ini dibuat dalam rangkap dua, masing-masing pihak memegang satu rangkap yang memiliki kekuatan hukum yang sama.</p>
            
            <div class="signature">
                <table>
                    <tr>
                        <td>
                            PIHAK PERTAMA,<br><br><br><br>
                            (<?= $data['nama_petani'] ?>)
                        </td>
                        <td>
                            PIHAK KEDUA,<br><br><br><br>
                            (<?= $data['nama_distributor'] ?>)
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
    </html>
    <?php
    return ob_get_clean();
}