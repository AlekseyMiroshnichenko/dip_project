<?php

class Calculate_model extends CI_Model {
	
	public function calculate($data){
        $array_fiber = $data['array_fiber'];
        $array_a = $data['array_a'];
        $array_lyambda = $data['array_lyambda'];

        $avg_d_fiber = $this->array_avg($array_fiber);

        $ln_d = log($avg_d_fiber - $array_fiber[0])/$array_fiber[0];

        $avg_a = $this->array_avg($array_a);
        
        echo $avg_lyambda = array_sum($array_lyambda)/count($array_fiber);
        echo "<br>";

        

        echo $xi = pi()*$array_fiber[0]/$avg_lyambda;
    }

    public function array_avg($array){
        return array_sum($array)/count($array);
    }
}
