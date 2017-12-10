<?php

class Calculate_model extends CI_Model {
	
	public function calculate($data){
        $step = $data['step'];
        $array_fiber = $data['array_fiber'];
        $array_a = $data['array_a'];
        $array_lyambda = $data['array_lyambda'];
        $array_time= $data['array_time'];
        $d0 = $data['d0'];
        $eta1 = $data['eta1'];
        $eta2 = $data['eta2'];
        $omega = $data['omega'];


        $avg_d_fiber = $this->array_avg($array_fiber);
        $ln_d = log($avg_d_fiber - $d0)/$d0;
        $avg_a = $this->array_avg($array_a);
        $avg_lyambda = array_sum($array_lyambda)/count($array_fiber);
        $avg_delta_t = $this->avg_delta_t($array_time);

        $q = log(2*$avg_a)/($d0 * $avg_delta_t);

        if($step == "step_1")
            return $q;

        $xi = pi()*$d0/$avg_lyambda;
        $eta = $eta1/$eta2;

        if($step == "step_2"){
            return array('xi' => $xi,
                        'eta' => $eta
                );
        }

        $sigma = ($q * $eta2 * $d0)/$omega;
        if($step == "step_3"){
            return $sigma;
        }
    }

    public function array_avg($array){
        return array_sum($array)/count($array);
    }

    public function avg_delta_t($array){
        $array_time = array();
        foreach ($array as $time) {
            preg_match('/^(\d{1,2}):(\d{1,2})/', $time, $mathes);
            $array_time[] = $mathes[1]*60+$mathes[2];
        }

        $sum_delta = 0;

        for($i = 1; $i < count($array_time); $i++){
            $sum_delta = $array_time[$i] - $array_time[$i-1];
        }

        return $sum_delta/(count($array_time)-1);
    }
}
