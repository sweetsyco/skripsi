<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('d_report_model');
        $this->load->model('distributor_model');
        $this->load->helper('url');
        
        // Pastikan hanya distributor yang bisa akses
        if($this->session->userdata('peran') != 'distributor') {
            redirect('login');
        }
        
        // Ambil id_distributor dari session
        $this->id_distributor = $this->session->userdata('id_distributor');
    }

    public function index() {
        $data['komoditas_list'] = $this->d_report_model->get_komoditas();
        $data['filter'] = [
            'start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'status' => $this->input->get('status'),
            'id_komoditas' => $this->input->get('id_komoditas')
        ];

        // Statistik
        $data['total_permintaan'] = $this->d_report_model->get_total_permintaan($this->id_distributor, $data['filter']);
        $data['permintaan_selesai'] = $this->d_report_model->get_permintaan_selesai($this->id_distributor, $data['filter']);
        $data['total_penawaran'] = $this->d_report_model->get_total_penawaran($this->id_distributor, $data['filter']);
        $data['pengiriman_selesai'] = $this->d_report_model->get_pengiriman_selesai($this->id_distributor, $data['filter']);

        // Data grafik
        $data['grafik_permintaan'] = $this->d_report_model->get_grafik_permintaan($this->id_distributor, $data['filter']);
        $data['distribusi_komoditas'] = $this->d_report_model->get_distribusi_komoditas($this->id_distributor, $data['filter']);

        // Data tabel
        $data['laporan_permintaan'] = $this->d_report_model->get_laporan_permintaan($this->id_distributor, $data['filter']);
        $data['title'] = "Laporan Distributor";

        $this->load->view('distributor_index/index',$data);
        $this->load->view('distributor_index/header');
        $this->load->view('distributor/laporan/laporan', $data);
        $this->load->view('distributor_index/laporan_footer');
    }

    public function export_pdf() {
        // Logika ekspor PDF
        // Ambil parameter filter
        $filter = [
            'start_date' => $this->input->get('start_date'),
            'end_date' => $this->input->get('end_date'),
            'status' => $this->input->get('status'),
            'id_komoditas' => $this->input->get('id_komoditas')
        ];
        if (!empty($filter['start_date'])) {
        $filter['start_date'] = date('Y-m-d', strtotime($filter['start_date']));
        }
        if (!empty($filter['end_date'])) {
            $filter['end_date'] = date('Y-m-d', strtotime($filter['end_date']));
        }

        // Ambil data laporan
        $data['laporan_permintaan'] = $this->d_report_model->get_laporan_permintaan($this->id_distributor, $filter);
        $data['title'] = "Laporan Permintaan";

        $data['periode'] = "Semua Periode";
    if (!empty($filter['start_date']) && !empty($filter['end_date'])) {
        $start = date('d M Y', strtotime($filter['start_date']));
        $end = date('d M Y', strtotime($filter['end_date']));
        $data['periode'] = "Periode: $start s/d $end";
    } elseif (!empty($filter['start_date'])) {
        $start = date('d M Y', strtotime($filter['start_date']));
        $data['periode'] = "Periode: Dari $start";
    } elseif (!empty($filter['end_date'])) {
        $end = date('d M Y', strtotime($filter['end_date']));
        $data['periode'] = "Periode: Sampai $end";
    }

        // Konfigurasi PDF
        $dompdf = new \Dompdf\Dompdf();
        
        // Buat HTML untuk PDF
        $html = $this->load->view('distributor/laporan/export_pdf', $data, TRUE);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        
        // Output PDF (langsung download)
        $dompdf->stream("laporan_permintaan.pdf", array("Attachment" => 1));
    }

    public function export_excel() {
    // Load autoloader Composer
    // require_once FCPATH . 'vendor/autoload.php';

    // Pastikan tidak ada output sebelum ini
    ob_clean();
    ob_start();

    $get_params = [
        'start_date' => $this->input->get('start_date'),
        'end_date' => $this->input->get('end_date'),
        'status' => $this->input->get('status'),
        'id_komoditas' => $this->input->get('id_komoditas')
    ];

    // Siapkan filter untuk model
    $filter = [
        'start_date' => !empty($get_params['start_date']) ? date('Y-m-d', strtotime($get_params['start_date'])) : null,
        'end_date' => !empty($get_params['end_date']) ? date('Y-m-d', strtotime($get_params['end_date'])) : null,
        'status' => ($get_params['status'] == 'all') ? null : $get_params['status'], // Perbaikan di sini
        'id_komoditas' => ($get_params['id_komoditas'] != '') ? $get_params['id_komoditas'] : null
    ];

    // Ambil data laporan
    $laporan = $this->d_report_model->get_laporan_permintaan($this->id_distributor, $filter);
    // var_dump($laporan);
    // die();
    // Format periode untuk ditampilkan
    $periode = "Semua Periode";
    if (!empty($get_params['start_date']) && !empty($get_params['end_date'])) {
        $start = date('d M Y', strtotime($get_params['start_date']));
        $end = date('d M Y', strtotime($get_params['end_date']));
        $periode = "Periode: $start s/d $end";
    } elseif (!empty($get_params['start_date'])) {
        $start = date('d M Y', strtotime($get_params['start_date']));
        $periode = "Periode: Dari $start";
    } elseif (!empty($get_params['end_date'])) {
        $end = date('d M Y', strtotime($get_params['end_date']));
        $periode = "Periode: Sampai $end";
    }
    
    // Dapatkan nama komoditas
    $komoditas_name = 'Semua Komoditas';
    if (!empty($get_params['id_komoditas'])) {
        $komoditas_name = $this->d_report_model->get_komoditas_name($get_params['id_komoditas']);
    }

    // Status untuk ditampilkan
    $status_display = ($get_params['status'] == 'all') ? 'Semua Status' : $get_params['status'];

    // Informasi distributor
    $nama_distributor = $this->session->userdata('nama_distributor') ?? 'N/A';
    $id_distributor = $this->session->userdata('id_distributor');

    $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Set judul laporan
    $sheet->setCellValue('A1', 'LAPORAN PERMINTAAN DISTRIBUTOR');
    $sheet->mergeCells('A1:E1');
    $sheet->getStyle('A1')->getFont()->setBold(true);
    $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    
    // Informasi distributor
    $sheet->setCellValue('A2', 'Distributor: ' . $nama_distributor);
    $sheet->mergeCells('A2:E2');
    
    $sheet->setCellValue('A3', 'ID Distributor: ' . $id_distributor);
    $sheet->mergeCells('A3:E3');
    
    // Informasi periode
    $sheet->setCellValue('A4', $periode);
    $sheet->mergeCells('A4:E4');
    
    // Informasi filter
    $sheet->setCellValue('A5', 'Status: ' . $status_display);
    $sheet->setCellValue('C5', 'Komoditas: ' . $komoditas_name);
    $sheet->mergeCells('C5:E5');
    
    // Header tabel
    $sheet->setCellValue('A7', 'No');
    $sheet->setCellValue('B7', 'Tanggal');
    $sheet->setCellValue('C7', 'Komoditas');
    $sheet->setCellValue('D7', 'Jumlah (Kg)');
    $sheet->setCellValue('E7', 'Status');
    
    // Styling header tabel
    $headerStyle = [
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
    ];
    $sheet->getStyle('A7:E7')->applyFromArray($headerStyle);
    
    // Isi data
    $row = 8;
    $no = 1;
    if (!empty($laporan)) {
        foreach ($laporan as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, date('d-m-Y', strtotime($item->dibuat_pada)));
            $sheet->setCellValue('C' . $row, $item->nama_komoditas);
            $sheet->setCellValue('D' . $row, number_format($item->jumlah, 0, ',', '.'));
            $sheet->setCellValue('E' . $row, $item->status);
            
            // Set alignment untuk kolom angka
            $sheet->getStyle('D' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            
            $row++;
        }
        
        // Styling border untuk data
        $lastRow = $row - 1;
        $dataStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                ]
            ]
        ];
        $sheet->getStyle('A7:E' . $lastRow)->applyFromArray($dataStyle);
        
        // Auto size kolom
        foreach(range('A','E') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
    } else {
        $sheet->setCellValue('A8', 'Tidak ada data permintaan untuk filter yang dipilih');
        $sheet->mergeCells('A8:E8');
        $sheet->getStyle('A8')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }
    
    // Footer: Tanggal cetak
    $sheet->setCellValue('A' . ($row + 1), 'Dicetak pada: ' . date('d-m-Y H:i:s'));
    $sheet->mergeCells('A' . ($row + 1) . ':E' . ($row + 1));
    
    // Format output
    $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    
    // Header untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="laporan_permintaan.xlsx"');
    header('Cache-Control: max-age=0');
    header('Pragma: public');
    
    $writer->save('php://output');
    ob_end_flush();
    exit();
}
}
