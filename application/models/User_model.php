<?php

class User_model extends CI_Model {

    public $login = false;
    public $info = null;
    public $type = "";
    public $id;
    private $isAdmin = false;

    /*
     * Уровни доступа
     * тип пользователя => страница
     */
    private $config_arr = array(
    );
    /*
     * Список разрешенных страниц для гостей
     */
    private $config_pages = array(
        'account/login',
    );
    /*
     * Список разрешенных сегментов для всех
     */
    private $rsegments = array(
        'login', 
    );

    public function isAdmin() {
        return $this->isAdmin;
    }


    public function __construct() {
        parent::__construct();
            if ($this->isLogin() === FALSE && !in_array($this->uri->rsegment(1), $this->rsegments)) {
                if (!in_array($this->uri->uri_string(), $this->config_pages))
                    redirect(base_url() . "login");
            }

            if ($this->login) {
                if ($this->info->status == 0) {
                    die("К сожалению вы заблокированы на данном ресурсе");
                }
            }
    }

    public function isLogin() {
        if ($this->session->userdata("email") && $this->session->userdata("passhash")) {
            $res = $this->getUserInfo(
                    array(
                        "email" => $this->session->userdata("email"),
                        "passhash" => $this->session->userdata("passhash")
                    )
            );

            if ($res->num_rows() > 0) {
                $this->info = $res->row();

                if($this->info->role == 1){
                    $this->isAdmin = true;
                }

                if ($this->info->status == '1') {
                    $this->login = true;
                    return true;
                }
            }
        }
        return false;
    }

    public function getUserInfo($array = array()) {
        if (count($array) != 0)
            foreach ($array AS $key => $value)
                $this->db->where($key, $value);
        return $this->db->get("users");
    }

    public function getMD5($password) {
        return md5($password . "pass100lead" . $password . "okglass");
    }

}
