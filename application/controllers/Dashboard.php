<?php
defined('BASEPATH') or exit('No direct script access allowed');

final class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->db->cache_on();
        $this->page = "dashboard";
        $this->load->model('Dashboard_model', 'dashboard');
    }

   /**
    * Loads the dashboard page
    * @param  int         $character_id 
    * @param  int|integer $interval     
    * @return void                    
    */
    public function index(int $character_id, int $interval = 3) : void
    {
        if ($interval > 7) {
            $interval = 7;
        }

        if ($this->enforce($character_id, $this->user_id)) {
            $aggregate = $this->aggregate;
            $data      = $this->loadViewDependencies($character_id, $this->user_id, $aggregate);
            $chars     = $data['chars'];

            $data['selected'] = "dashboard";
            $data['interval'] = $interval;

            $profits = $this->dashboard->getProfits($interval, $chars, $this->user_id);

            $count = $profits['count'];
            if ($count > 200) {
                $img = false;
            } else {
                $img = true;
            }

            $data['week_profits']   = $this->dashboard->getWeekProfits($chars);
            $data['new_info']       = $this->dashboard->getNewInfo($chars);

            $data['img']            = $img;
            $data['profits']        = $this->injectIcons($profits['result']);
            $data['profits_trends'] = $this->dashboard->getTotalProfitsTrends($chars);

            $data['layout']['page_title']     = "Dashboard";
            $data['layout']['icon']           = "pe-7s-link";
            $data['layout']['page_aggregate'] = true;

            $data['view'] = 'main/dashboard_v';
            $this->twig->display('main/_template_v', $data);
        }
    }


    public function getPieChart(int $character_id)
    {
        $msg = Msg::INVALID_REQUEST;
        $notice = "error";
        if ($this->enforce($character_id, $this->user_id, true)) {
            // get active session characters
            $chars = $this->loadViewDependencies($character_id, $this->user_id, $this->aggregate)['chars'];
            if ($chars) {
                echo $this->dashboard->getPieData($chars);
                return;
            }
        }
        echo json_encode(array("notice" => $notice, "message" => $msg));
    }
}