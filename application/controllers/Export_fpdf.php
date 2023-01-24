<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Export_fpdf extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model('User_model', 'user');
    }

    function index()
    {
        $pdf = new FPDF('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 7, 'LIST NAME USER', 0, 1, 'C');
        $pdf->Cell(10, 7, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(90, 6, 'Name', 1, 0, 'C');
        $pdf->Cell(120, 6, 'Email', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Address', 1, 1, 'C');
        $pdf->SetFont('Arial', '', 10);
        $data = $this->user->get_all();
        $no = 0;
        foreach ($data as $d) {
            $no++;
            $pdf->Cell(10, 6, $no, 1, 0, 'C');
            $pdf->Cell(90, 6, $d->name, 1, 0);
            $pdf->Cell(120, 6, $d->email, 1, 0);
            $pdf->Cell(40, 6, $d->address, 1, 1);
        }
        $pdf->Output();
    }
}

/* End of file Fpdf.php */
