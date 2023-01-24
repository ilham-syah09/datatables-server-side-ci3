<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }


    public function index()
    {
        $this->load->view('user');
    }

    function get_ajax()
    {
        $list = $this->User_model->get_datatables();
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->name;
            $row[] = $item->email;
            $row[] = $item->address;
            $row[] = $item->image != null ? '<img src="' . base_url('uploads/image/' . $item->image) . '" class="img-fluid" style="width:100px">' : null;
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->User_model->count_all(),
            "recordsFiltered" => $this->User_model->count_filtered(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    // insert data dummy
    public function insert_dummy()
    {
        //3ribu mahasiswa
        $jumlah_data = 3000;
        for ($i = 1; $i <= $jumlah_data; $i++) {
            $data   =   array(
                "name"      =>  "Name" . $i,
                "email"   =>  "mahasiswa$i@gmil.com",
                "address"     =>  "Address name" . $i,
            );
            //insert ke tabel mahasiswa
            $this->db->insert('user', $data);
        }
        //flashdata untuk pesan success
        redirect("user");
    }
}

/* End of file User.php */
