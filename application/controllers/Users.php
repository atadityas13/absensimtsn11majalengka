<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('m_data');
        $this->load->library('bcrypt');  // Load the bcrypt library
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index() {
        $data['set'] = "list-users";
        $data['data'] = $this->m_data->get_users();
        $this->load->view('i_users', $data);
    }
    
    public function add_users() {
        $data['set'] = "add-users";
        $this->load->view('i_users', $data);
    }
    
    public function save_users() {
        if ($this->session->userdata('userlogin')) {
            $users = $this->input->post('users');
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $pass = $this->input->post('pass');
            $hash = $this->bcrypt->hash_password($pass);  // Use bcrypt to hash password

            if (!empty($_FILES["image"]["name"])) {
                $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $type = strtolower($type);
                $imgname = uniqid(rand()) . '.' . $type;
                $url = "assets/images/" . $imgname;

                if (in_array($type, array("jpg", "jpeg", "gif", "png"))) {
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $url)) {
                            $data = array(
                                'nama'     => $users,
                                'email'    => $email,
                                'username' => $username,
                                'password' => $hash,
                                'avatar'   => $imgname,
                            );
                            $this->m_data->insert_users($data);
                            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil disimpan</div>");
                        }
                    }
                } else {
                    $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal disimpan, ekstensi gambar salah</div>");
                }
            }
            
			redirect(base_url().'users');
        }
    }
    
    public function hapus_users($id = null) {
        if ($this->session->userdata('userlogin')) {
            $filename = $this->m_data->get_user_byid($id);
            $file = isset($filename->avatar) ? $filename->avatar : null;
            $path = "assets/images/" . $file;

            if ($file && file_exists($path)) {
                unlink($path);
            }

            if ($this->m_data->users_del($id)) {
                $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil dihapus</div>");
            } else {
                $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal dihapus</div>");
            }

            redirect(base_url().'users');
        }
    }
    
    public function edit_users($id = null) {
        if ($this->session->userdata('userlogin') && isset($id)) {
            $user = $this->m_data->get_user_byid($id);

            if ($user) {
                $data = array(
                    'id'       => $id,
                    'nama'     => $user->nama,
                    'email'    => $user->email,
                    'username' => $user->username,
                    'password' => $user->password,
                    'avatar'   => $user->avatar,
                    'set'      => "edit-users"
                );
                $this->load->view('i_users', $data);
            } else {
                redirect(base_url().'users');
            }
        }
    }
    
    public function save_edit_users() {
        if ($this->session->userdata('userlogin') && isset($_POST['id']) && isset($_POST['email'])) {
            $id = $this->input->post('id');
            $email = $this->input->post('email');
            $nama = $this->input->post('users');
            $username = $this->input->post('username');
            $pass = $this->input->post('pass');
            $hash = $this->bcrypt->hash_password($pass);  // Use bcrypt to hash password

            if (!empty($_FILES["image"]["name"])) {
                $type = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
                $type = strtolower($type);
                $imgname = uniqid(rand()) . '.' . $type;
                $url = "assets/images/" . $imgname;

                if (in_array($type, array("jpg", "jpeg", "gif", "png"))) {
                    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
                        if (move_uploaded_file($_FILES["image"]["tmp_name"], $url)) {
                            $file = $this->input->post('img');
                            $path = "assets/images/" . $file;

                            if (file_exists($path)) {
                                unlink($path);
                            }

                            $data = array(
                                'nama'     => $nama,
                                'email'    => $email,
                                'username' => $username,
                                'avatar'   => $imgname,
                            );

                            $this->m_data->updateUser($id, $data);
                            $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil disimpan</div>");
                        }
                    }
                } else {
                    $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal disimpan, ekstensi gambar salah</div>");
                }
            }

            if (isset($_POST['changepass'])) {
                $data = array(
                    'email'    => $email,
                    'nama'     => $nama,
                    'username' => $username,
                    'password' => $hash,
                );
            } else {
                $data = array(
                    'email'    => $email,
                    'nama'     => $nama,
                    'username' => $username,
                );
            }

            if ($this->m_data->updateUser($id, $data)) {
                $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data berhasil diupdate</div>");
            } else {
                $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\"><i class=\"glyphicon glyphicon-ok\"></i> Data gagal diupdate</div>");
            }

            redirect(base_url().'users');
        }
    }
}