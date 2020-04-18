<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: AccessToken");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
date_default_timezone_set("Asia/Calcutta");

require APPPATH . '/libraries/REST_Controller.php';


class Common extends REST_Controller
{
    protected $jsonarr = array();
    protected $headers;
    protected $urlAuth;
    protected $controller;

    function __construct()
    {
        parent::__construct();

        $this->load->model("common_model");

        header("Access-Control-Allow-Origin: *");
        $this->controller = uri_string();
        $urlAuth = $this->verifyAuthUrl();
        $headers = $this->input->request_headers();
        if ($urlAuth) {
            $excludeurl = $this->excludefunction();
            if ($excludeurl != 'true') {
                if (isset($headers['Accesstoken'])) {
                    $this->output->set_status_header(200);
                    $headers['Accesstoken'];
                } else {
                    $this->jsonarr['ErrorObject'] = "Unauthorized User";
                    $this->jsonarr['IsSuccess'] = false;
                    $this->printjson($this->jsonarr);
                    $this->output->set_status_header(401);
                    exit();
                }

            } else {
                $this->output->set_status_header(200);
                return true;
            }
        } else {
            $this->output->set_status_header(200);
            $this->jsonarr['ErrorObject'] = "The requested url is not found.";
            $this->jsonarr['IsSuccess'] = false;
            $this->printjson($this->jsonarr);
            exit();
        }
    }

    public function verifyAuthUrl()
    {
        $this->allowedRoutes = array(
            'admin/common/partyLists',
            'admin/common/getVotes',
            'admin/common/vote',
        );
        foreach ($this->allowedRoutes as $routeString) {
            if ($this->controller == $routeString){
                return true;
            }
        }
        return false;
    }

    public function excludefunction()
    {
        $this->excludeRoutes = array(
        );
        foreach ($this->excludeRoutes as $routeString) {
            if ($this->controller == $routeString) {
                return true;
            }
        }
    }

    public function partyLists_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['userid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Userid should not be empty";
        } elseif ($params['roleid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Roleid should not be empty";
        } else {
            $check = $this->common_model->checkToken($params);
            if($check){
                $getParty = $this->common_model->partyList();
                $this->jsonarr["IsSuccess"] = true;
                $this->jsonarr["ResponseObject"] = $getParty;
            } else{
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Unauthorised user";
            }
        }
        return $this->printjson($this->jsonarr);
    }

    public function getVotes_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['userid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Userid should not be empty";
        } elseif ($params['roleid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Roleid should not be empty";
        } else {
            $check = $this->common_model->checkToken($params);
            if($check){
                $vote = $this->common_model->getVotes();
                $this->jsonarr["IsSuccess"] = true;
                $this->jsonarr["ResponseObject"]['records']= $vote;
                $this->jsonarr["ResponseObject"]['party']= array_column($vote, 'short_name');
                $this->jsonarr["ResponseObject"]['vote']= array_column($vote, 'vote_count');
            } else{
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Unauthorised user";
            }
        }
        return $this->printjson($this->jsonarr);
    }

    public function vote_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['userid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Userid should not be empty";
        } elseif ($params['roleid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Roleid should not be empty";
        } elseif ($params['participant_id'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Participant_id should not be empty";
        } else {
            $check = $this->common_model->checkToken($params);

            if($check > 0){

                $add = array(
                    "user_id" => $params['userid'],
                    "participant_id" => $params['participant_id'],
                    "created_date" => date("Y-m-d H:i:s")
                );

                $add_vote = $this->common_model->addVote($add);

                if($add_vote > 0){
                    $this->jsonarr["IsSuccess"] = true;
                    $this->jsonarr["ResponseObject"] = "Vote added successfully";
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Failed to add a vote";
                }

            } else{
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Unauthorised user";
            }
        }
        return $this->printjson($this->jsonarr);
    }

    private function printjson($jsonarr)
    {
        echo json_encode($jsonarr);
    }

}