<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('auth/login');
    }

    public function login()
    {
        // $this->cekLogin();

        $returnString = $this->input->get('return') ? '?return=' . urlencode($this->input->get('return', true)) : '';

        if ($this->uauth->isLogin()) {
            $this->UserRedirecting($returnString);
        } else {
            $valid = $this->form_validation;
            $valid->set_rules('username', 'Username', 'trim|required|strip_tags', array('required' => '{field} harus diisi.'));
            $valid->set_rules('password', 'Password', 'trim|required|strip_tags', array('required' => '{field} harus diisi.'));

            if (!$valid->run()) {
                $data = array(
                    'title' => 'Login ke Sistem',
                    'isi' => 'auth/login',
                    'returnString' => $returnString
                );

                $this->load->view('auth/_layout/wrapper', $data);
            } else {

                $username = $this->input->post('username');
                $password = $this->input->post('password');
                $remember = $this->input->post('remember_me');

                //Lakukan Login
                if (!$this->uauth->login($username, $password, $remember)) {
                    $this->session->set_flashdata("failed", "Username atau Password Salah");
                    redirect(login_url() . $returnString);
                } else {
                    //Callback Function
                    $this->login();
                }
            }
        }
    }

    public function UserRedirecting($returnString = '')
    {
        $returnString = $this->input->get('return') ? urldecode($this->input->get('return', true)) : '';

        $this->session->set_flashdata("success", "Selamat datang di sistem!");
        $roles = $this->uauth->getRoles();
        if ($returnString == '') {
            foreach ($roles as $role) {
                switch ($role) {
                    case 'admin':
                        redirect(admin_url());
                        break;
                    default:
                        $this->logout();
                        break;
                }
            }
        } else {
            redirect(site_url($returnString));
        }
    }
    public function logout()
    {
        $this->uauth->logout();
        $returnString = $this->input->get('return') ? '?return=' . urlencode($this->input->get('return', true)) : '';

        redirect(login_url() . $returnString);
    }

    public function forgot()
    {
        $valid = $this->form_validation;
        $valid->set_rules(
            'email',
            'Email',
            'required|valid_email',
            array(
                'required' => '{field} harus diisi.',
                'valid_email' => '{field} format email harus benar.'
            )
        );

        if (!$valid->run()) {
            $data = array(
                'title' => 'Lupa Password',
                'isi' => 'auth/forgot'
            );
            $this->load->view('auth/_layout/wrapper', $data);
        } else {
            $email = $this->input->post('email');
            // Do Whateever u want
            // Sent Via Email or anything
        }
    }
}
