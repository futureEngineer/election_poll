<?php

class User_Model extends CI_Model
{
    private $jsonarr = array();

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('common_model');
    }

    public function login($params){

        $result = $this->db->query("SELECT u.id as userid,u.role_id,u.name,u.mobile,
                                    CASE WHEN (SELECT count(*) FROM user_votes WHERE user_id = u.id) > 0
                                         THEN 1 ELSE 0 END as is_voted
                                    FROM users u
                                    WHERE u.mobile = {$params['mobile']} 
                                    AND u.password = md5({$params['password']})")->result_array();

        return $result;
    }


}