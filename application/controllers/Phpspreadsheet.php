<?php
defined('BASEPATH') or exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Phpspreadsheet extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }


    public function index()
    {
        $data = [
            'title'     => 'example',
            'page'      => 'user',
            'data'      => $this->data->get_all()
        ];

        $this->load->view('index', $data);
    }

    // IMPORT DATA XLSX
    public function import()
    {
        $upload_file = $_FILES['upload_file']['name'];
        $extension = pathinfo($upload_file, PATHINFO_EXTENSION);
        if ($extension == 'csv') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } else if ($extension == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }
        $spreadsheet = $reader = $reader->load($_FILES['upload_file']['tmp_name']);
        $sheetdata = $spreadsheet->getActiveSheet()->toArray();
        $sheetcount = count($sheetdata);
        if ($sheetcount > 1) {
            $data = array();
            for ($i = 1; $i < $sheetcount; $i++) {
                $name = $sheetdata[$i][0];
                $email = $sheetdata[$i][1];
                $address = $sheetdata[$i][2];
                $data[] = array(
                    'name'  => $name,
                    'email'      => $email,
                    'address'     => $address,
                );
            }
            $this->user->insert_batch($data);

            redirect('user', 'refresh');
        }
    }

    // EXPORT DATA DATABASE TO EXCEL
    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Address');
        $sheet->setCellValue('E1', 'Image');

        $user = $this->user->get_all();
        $no = 1;
        $x = 2;
        foreach ($user as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row->name);
            $sheet->setCellValue('C' . $x, $row->email);
            $sheet->setCellValue('D' . $x, $row->address);
            $sheet->setCellValue('E' . $x, $row->image);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'data';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
}

/* End of file Phpspreadsheet.php */
