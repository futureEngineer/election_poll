<?php

class Participant_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('common_model');
    }

    public function add($data){

        $this->db->insert('participants',$data);
        return $this->db->insert_id();
    }

    public function getParticipant(){

        $getCompany = $this->db->query("SELECT p.id as participant_id,p.name as participant_name,p.party_id,
                                        pp.name,pp.short_name,pp.logo,p.age,p.gender,p.mobile
                                        FROM participants p
                                        LEFT JOIN political_parties pp ON pp.id = p.party_id")->result_array();

        return $getCompany;
    }

    public function update($data,$id){

        $this->db->where('id',$id);
        $check = $this->db->update('participants',$data);
        return $check;
    }


    public function delete($id){

        $check = $this->db->query("DELETE FROM participants WHERE id = $id");
        return $check;

    }

}