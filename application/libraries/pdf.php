<?php
defined('BASEPATH') OR exit('No direct script access allowed');


use Dompdf\Dompdf;

class Pdf {
    public function __construct() {
        $this->dompdf = new Dompdf();
    }

    public function generate($html, $filename, $stream = true, $paper = 'A4', $orientation = 'portrait') {
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper($paper, $orientation);
        $this->dompdf->render();

        if ($stream) {
            $this->dompdf->stream($filename, ["Attachment" => 1]);
        } else {
            return $this->dompdf->output();
        }
    }

    
    public function generate_surat_perjanjian($data) {
        // Set document information
        $this->SetCreator(PDF_CREATOR);
        $this->SetAuthor('AgriConnect');
        $this->SetTitle('Surat Perjanjian');
        $this->SetSubject('Kontrak Penjualan Komoditas');
        
        // Set margins
        $this->SetMargins(15, 25, 15);
        $this->SetHeaderMargin(10);
        $this->SetFooterMargin(10);
        
        // Add a page
        $this->AddPage();
        
        // Header
        $this->SetFont('helvetica', 'B', 16);
        $this->Cell(0, 10, 'SURAT PERJANJIAN KERJASAMA', 0, 1, 'C');
        $this->SetFont('helvetica', '', 12);
        $this->Cell(0, 5, 'Nomor: '.$data['no_kontrak'], 0, 1, 'C');
        $this->Ln(10);
        
        // Content
        $this->SetFont('helvetica', '', 11);
        $html = '<p>Pada hari ini, tanggal <b>'.$data['tanggal_surat'].'</b>, bertempat di AgriConnect, dibuat perjanjian kerjasama antara:</p>';
        $html .= '<table cellpadding="5">';
        $html .= '<tr><td width="30%">Pihak Pertama</td><td width="70%">: '.$data['nama_petani'].' (Petani)</td></tr>';
        $html .= '<tr><td>Alamat</td><td>: '.$data['alamat_petani'].'</td></tr>';
        $html .= '<tr><td>Pihak Kedua</td><td>: '.$data['nama_distributor'].' (Distributor)</td></tr>';
        $html .= '<tr><td>Alamat</td><td>: '.$data['alamat_distributor'].'</td></tr>';
        $html .= '</table>';
        $html .= '<p>Selanjutnya disebut sebagai <b>PIHAK PERTAMA</b> dan <b>PIHAK KEDUA</b>.</p>';
        $html .= '<p>Kedua belah pihak sepakat untuk mengadakan perjanjian kerjasama dengan ketentuan sebagai berikut:</p>';
        
        // Pasal-pasal
        $html .= '<p><b>Pasal 1: OBJEK PERJANJIAN</b></p>';
        $html .= '<p>PIHAK PERTAMA sepakat menjual dan PIHAK KEDUA sepakat membeli komoditas pertanian dengan ketentuan:</p>';
        $html .= '<table cellpadding="5">';
        $html .= '<tr><td width="30%">Jenis Komoditas</td><td width="70%">: '.$data['komoditas'].'</td></tr>';
        $html .= '<tr><td>Jumlah</td><td>: '.number_format($data['jumlah']).' kg</td></tr>';
        $html .= '<tr><td>Harga per kg</td><td>: Rp '.number_format($data['harga'], 0, ',', '.').'</td></tr>';
        $html .= '<tr><td>Total Nilai</td><td>: Rp '.number_format($data['total'], 0, ',', '.').'</td></tr>';
        $html .= '</table>';
        
        $html .= '<p><b>Pasal 2: JANGKA WAKTU</b></p>';
        $html .= '<p>Perjanjian ini berlaku sejak tanggal <b>'.date('d F Y', strtotime($data['tanggal_mulai'])).'</b> hingga <b>'.date('d F Y', strtotime($data['tanggal_berakhir'])).'</b>.</p>';
        
        $html .= '<p><b>Pasal 3: PEMBAYARAN</b></p>';
        $html .= '<p>PIHAK KEDUA akan melakukan pembayaran sebesar <b>Rp '.number_format($data['total'], 0, ',', '.').'</b> kepada PIHAK PERTAMA melalui rekening yang disepakati dalam waktu 7 hari setelah penandatanganan perjanjian ini.</p>';
        
        $html .= '<p><b>Pasal 4: PENYERAHAN BARANG</b></p>';
        $html .= '<p>PIHAK PERTAMA akan menyerahkan komoditas sesuai kualitas dan kuantitas yang disepakati dalam waktu 14 hari setelah pembayaran diterima.</p>';
        
        $html .= '<p><b>Pasal 5: SANKSI</b></p>';
        $html .= '<p>Jika salah satu pihak tidak memenuhi kewajibannya, maka dikenakan sanksi berupa denda sebesar 0,5% dari nilai kontrak per hari keterlambatan.</p>';
        
        $html .= '<p><b>Pasal 6: PENUTUP</b></p>';
        $html .= '<p>Perjanjian ini dibuat dalam rangkap dua, masing-masing pihak memegang satu rangkap yang memiliki kekuatan hukum yang sama.</p>';
        
        $this->writeHTML($html, true, false, true, false, '');
        
        // Tanda tangan
        $this->Ln(15);
        $this->SetFont('helvetica', '', 11);
        $this->Cell(95, 5, 'PIHAK PERTAMA,', 0, 0, 'C');
        $this->Cell(95, 5, 'PIHAK KEDUA,', 0, 1, 'C');
        $this->Ln(20);
        $this->Cell(95, 5, '('.$data['nama_petani'].')', 0, 0, 'C');
        $this->Cell(95, 5, '('.$data['nama_distributor'].')', 0, 1, 'C');
        
        // Output PDF
        $this->Output('surat_perjanjian_'.$data['no_kontrak'].'.pdf', 'D');
    }
}
