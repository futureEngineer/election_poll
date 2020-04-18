<?php

class Common_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function checkToken($params){

        $headers = $this->input->request_headers();

        if (array_key_exists('Accesstoken', $headers) && !empty($headers['Accesstoken'])) {
            $userId = AUTHORIZATION::validateToken($headers['Accesstoken']);
            if ($userId != false && $userId == $params['userid']) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public function partyList(){

        $result = $this->db->query("SELECT id,name,short_name,logo FROM political_parties 
                                    WHERE id NOT IN (SELECT party_id FROM participants)")->result_array();
        return $result;
    }

    public function getVotes(){

        $result = $this->db->query("SELECT p.id as participant_id,p.name as participant_name,p.party_id,
                                    pp.name,pp.short_name,COUNT(v.participant_id) as vote_count,pp.logo
                                    FROM participants p
                                    LEFT JOIN user_votes v ON v.participant_id = p.id
                                    LEFT JOIN political_parties pp ON pp.id = p.party_id
                                    GROUP BY p.id")->result_array();
        return $result;
    }


    public function addVote($data){

        $this->db->insert('user_votes',$data);
        return $this->db->insert_id();
    }

}

