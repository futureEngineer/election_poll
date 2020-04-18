<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: AccessToken");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
date_default_timezone_set("Asia/Calcutta");

require APPPATH . '/libraries/REST_Controller.php';


class User extends REST_Controller
{
    protected $jsonarr = array();
    protected $headers;
    protected $urlAuth;
    protected $controller;

    function __construct()
    {
        parent::__construct();

        $this->load->model("common_model");
        $this->load->model("user_model");

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
            'admin/user/login',
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
            'admin/user/login',
        );
        foreach ($this->excludeRoutes as $routeString) {
            if ($this->controller == $routeString) {
                return true;
            }
        }
    }

    public function login_post(){

        $params = json_decode(file_get_contents("php://input"),true);

        if ($params['platform'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Platform should not be empty";
        } elseif ($params['mobile'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Mobile should not be empty";
        } elseif ($params['password'] == "") {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "Password should not be empty";
        } else {

            $checkUser= $this->user_model->login($params);

            if(count($checkUser) > 0){
                $this->jsonarr['IsSuccess'] = true;
                $this->jsonarr["ResponseObject"]['message'] = "logged in successfully";
                $this->jsonarr['ResponseObject']['name'] = $checkUser[0]["name"];
                $this->jsonarr["ResponseObject"]["mobile"] = $checkUser[0]["mobile"];
                $this->jsonarr["ResponseObject"]['roleid'] = $checkUser[0]["role_id"];
                $this->jsonarr["ResponseObject"]['userid'] = $checkUser[0]["userid"];
                $this->jsonarr["ResponseObject"]['is_voted'] = $checkUser[0]["is_voted"];
                $this->jsonarr['ResponseObject']['Accesstoken'] = AUTHORIZATION::generateToken($checkUser[0]["userid"]);
            } else {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Invalid credentials";
            }
        }
        return $this->printjson($this->jsonarr);
    }

    private function printjson($jsonarr)
    {
        echo json_encode($jsonarr);
    }

}