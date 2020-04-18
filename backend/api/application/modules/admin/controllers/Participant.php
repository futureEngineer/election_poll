<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: AccessToken");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
date_default_timezone_set("Asia/Calcutta");

require APPPATH . '/libraries/REST_Controller.php';


class Participant extends REST_Controller
{
    protected $jsonarr = array();
    protected $headers;
    protected $urlAuth;
    protected $controller;

    function __construct()
    {
        parent::__construct();

        $this->load->model("common_model");
        $this->load->model("participant_model");

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
            'admin/participant/add',
            'admin/participant/edit',
            'admin/participant/lists',
            'admin/participant/delete'
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

    public function add_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['userid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Userid should not be empty";
        } elseif ($params['party_id'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Party id should not be empty";
        } elseif ($params['name'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Name should not be empty";
        } elseif ($params['age'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Age should not be empty";
        } elseif ($params['gender'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Gender should not be empty";
        } elseif ($params['mobile'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Mobile number should not be empty";
        } else {

            $check = $this->common_model->checkToken($params);

            if($check){

                $participant = array(
                    "party_id" => $params['party_id'],
                    "name" => $params['name'],
                    "age" => $params['age'],
                    "gender" => strtolower($params['gender']),
                    "mobile" => $params['mobile'],
                    "qualification" => $params['qualification'],
                    "created_date" => date('Y-m-d'),
                    "status" => 1
                );

                $participant_id = $this->participant_model->add($participant);

                if($participant_id > 0){
                    $this->jsonarr["IsSuccess"] = true;
                    $this->jsonarr["ResponseObject"] = "Participant added successfully";
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Failed to add a participant";
                }

            } else {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Unauthorised user";
            }

        }
        return $this->printjson($this->jsonarr);
    }

    public function lists_post(){

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
                $getParticipant = $this->participant_model->getParticipant();
                $this->jsonarr["IsSuccess"] = true;
                $this->jsonarr["ResponseObject"] = $getParticipant;
            } else{
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Unauthorised user";
            }
        }
        return $this->printjson($this->jsonarr);
    }

    public function edit_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['userid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Userid should not be empty";
        } elseif ($params['participant_id'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Participant id should not be empty";
        } elseif ($params['party_id'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Party id should not be empty";
        } elseif ($params['name'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Name should not be empty";
        } elseif ($params['age'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Age should not be empty";
        } elseif ($params['gender'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Gender should not be empty";
        } elseif ($params['mobile'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Mobile number should not be empty";
        } else {

            $check = $this->common_model->checkToken($params);

            if($check){

                $participant_id = $params['participant_id'];

                $participant = array(
                    "party_id" => $params['party_id'],
                    "name" => $params['name'],
                    "age" => $params['age'],
                    "gender" => strtolower($params['gender']),
                    "mobile" => $params['mobile'],
                    "qualification" => $params['qualification'] != '' ? $params['qualification'] : ''
                );

                $update = $this->participant_model->update($participant,$participant_id);

                if($update){
                    $this->jsonarr["IsSuccess"] = true;
                    $this->jsonarr["ResponseObject"] = "Participant updated successfully";
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Failed to update a participant";
                }

            } else {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Unauthorised user";
            }

        }
        return $this->printjson($this->jsonarr);
    }

    public function delete_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['userid'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Userid should not be empty";
        } elseif ($params['participant_id'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Participant id should not be empty";
        } else {
            $check = $this->common_model->checkToken($params);
            if($check){
                $deleteParticipant = $this->participant_model->delete($params['participant_id']);
                if($deleteParticipant){
                    $this->jsonarr["IsSuccess"] = true;
                    $this->jsonarr["ResponseObject"] = "Participant deleted successfully";
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Failed to delete a participant";
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