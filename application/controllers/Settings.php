<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends MY_Controller
{
    private $email;
    private $password;
    private $reports;
    private $password_old;
    private $password_new1;
    private $password_new2;

    public function __construct()
    {
        parent::__construct();
        $this->db->cache_off();
        $this->page = "Settings";
        $this->load->model('Settings_model');
        $this->load->model('common/ValidateRequest');

        if (!empty($_REQUEST['password']) && !empty($_REQUEST['email'])) {
            $this->email    = $_REQUEST['email'];
            $this->password = $_REQUEST['password'];
        }

        if(!empty($_REQUEST['reports'])) {
            $this->reports = $_REQUEST['reports'];
        }

        if(!empty($_REQUEST['password-old']) && !empty($_REQUEST['password-new1']) && !empty($_REQUEST['password-new2'])) {
            $this->password_old  = $_REQUEST['password-old'];
            $this->password_new1 = $_REQUEST['password-new1'];
            $this->password_new2 = $_REQUEST['password-new2'];
        }
    }

    public function index($character_id)
    {

        if ($this->enforce($character_id, $user_id = $this->session->iduser)) {

            $aggregate = $this->aggregate;
            $data      = $this->loadViewDependencies($character_id, $user_id, $aggregate);
            $chars     = $data['chars'];

            $data['selected'] = "settings";

            $data['view'] = 'main/settings_v';
            $this->load->view('main/_template_v', $data);
        }
    }

    public function email()
    {
        $data = $this->Settings_model->getEmail($this->session->iduser);

        echo json_encode(array("email" => $data));
    }

    public function reports()
    {
        $result = $this->Settings_model->getReportSelection($this->session->iduser);
        $data = array("data" => $result);

        echo json_encode($data);
    }

    public function changeEmail()
    {
        //check pw
        $this->load->model('Login_model');
        if ($this->Login_model->validate($this->session->username, $this->password, true)) {
            if($this->Settings_model->changeEmail($this->session->iduser, $this->email)) {
                $notice = "success";
                $message = Msg::EMAIL_CHANGE_SUCCESS;
            } else {
                $notice = "error";
                $message = Msg::DB_ERROR;
            }
        } else {
            $notice = "error";
            $message = Msg::INVALID_LOGIN;
        }

        echo json_encode(array("notice" => $notice, "message" => $message));

    }

    public function changeReports()
    {
        if($this->reports == 'none' || $this->reports == 'daily' || $this->reports == 'weekly' || $this->reports == 'monthly') {
            if($this->Settings_model->changeReports($this->session->iduser, $this->reports)) {
                $notice = "success";
                $message = Msg::REPORT_CHANGE_SUCCESS;
            } else {
                $notice = "error";
                $message = Msg::REPORT_CHANGE_ERROR;
            }
        } else {
            $notice = "error";
            $message = Msg::REPORT_CHANGE_ERROR;
        }

        $data = ["notice" => $notice, "message" => $message];
        echo json_encode($data);
        
    }

    public function changePassword()
    {
        $this->load->model('common/Auth');
        if($this->ValidateRequest->validateIdenticalPasswords($this->password_new1, $this->password_new2)) {
            if($this->ValidateRequest->validatePasswordLength($this->password_new1) {
                if($this->Auth->validateLogin($this->session->username, $password_old, true)) {
                    $this->Settings_model->changePassword($this->session->iduser, $this->password_new1);
                } else {
                    $notice = "error";
                    $msg    = Msg::INVALID_LOGIN;
                }
            } else {
                $notice = "error";
                $msg    = Msg::PASSWORD_TOO_SHORT;
            }
        } else {
            $notice = "error";
            $msg    = Msg::PASSWORDS_MISMATCH;
        }
    }
}
