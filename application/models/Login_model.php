<?php

class Login_model extends CI_Model {
	
	public function isAdmin() {
		if($this->session->userdata("role")=="admin") 
			return true;
		else
			return false;
	}

    public function goLogin($email, $password) {
        $passhash = $this->user_model->getMD5($password);
        $res = $this->user_model->getUserInfo(
                array(
                    "email" => $email,
                    "passhash" => $passhash
                )
        );
        if ($res->num_rows() > 0) {
            $result=$res->result();
            $this->session->unset_userdata("email");
            $this->session->unset_userdata("passhash");
            $this->session->unset_userdata("user_id");
            $this->session->unset_userdata("role");
            $user_data = array(
                    "email" => $email,
                    "passhash" => $passhash,
                    "user_id" => $result[0]->id,
                    "role" => $result[0]->role
                );
            $this->session->set_userdata($user_data);
            $this->addUserLog($result[0]->id);
            return true;
        }
        return false;
    }
	public function isLogin() {
		$email = $this->session->userdata("email");
        $passhash = $this->session->userdata("passhash");
		if ($passhash && $email) {
			$res = $this->user_model->getUserInfo(
					array(
						"email" => $email,
						"passhash" => $passhash
					)
			);
			if ($res->num_rows() > 0) {
				$result=$res->result();
				if ($passhash == $result[0]->passhash){
					return true;
				}
			}
		}
        return false;
    }

    public function go($email, $passhash) {
        $this->session->unset_userdata("email");
        $this->session->unset_userdata("passhash");
        $user_data = array(
                    "email" => $email,
                    "passhash" => $passhash
                );
        $this->session->set_userdata($user_data);
        $this->session->unset_userdata("user_id");
        return true;
    }
	
    public function logout() {
        $this->session->unset_userdata('passhash');
        return true;
    }

    function addUserLog($user_id) {
        $user_ip = $_SERVER["REMOTE_ADDR"];
        $user_ip = $user_ip == '::1'? "127.0.0.1": $user_ip;
        $info = array(
            'user_id' => $user_id,
            'date_time' => date('Y-m-d H:i:s'),
            'user_ip' => ip2long($user_ip)
        );
   
        $this->db->insert('users_log', $info);
    }
	
    public function returnAdmin() {
        $admin_id = $this->session->userdata("admin_id");
        checkInt($admin_id);
        $query = $this->db->get_where("users", array("id" => $admin_id));
        if($query->num_rows() == 0)
            show_404 ();
        else
        {
            $row = $query->row();
            $user_data = array(
                    "email" => $row->email,
                    "passhash" => $row->passhash,
                    "user_id" => $this->session->userdata("admin_id")
                );
            $this->session->set_userdata($user_data);
            $this->session->unset_userdata("admin_id");

            redirect(base_url());
        }
    }

}
