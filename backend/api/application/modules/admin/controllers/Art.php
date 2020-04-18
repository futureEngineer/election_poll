<?php
defined('BASEPATH') OR exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: AccessToken");
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
date_default_timezone_set("Asia/Calcutta");

require APPPATH . '/libraries/REST_Controller.php';

class Art extends REST_Controller
{
    protected $jsonarr = array();
    protected $headers;
    protected $urlAuth;
    protected $controller;

    function __construct()
    {
        parent::__construct();
        $this->load->model("art_model");
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
            'admin/art/addMedium',
            'admin/art/mediumList',
            'admin/art/editMedium',
            'admin/art/deleteMedium',
            'admin/art/addSurface',
            'admin/art/surfaceList',
            'admin/art/editSurface',
            'admin/art/deleteSurface',
            'admin/art/index',
        );
        foreach ($this->allowedRoutes as $routeString) {
            if ($this->controller == $routeString) {
                return true;
            }
        }
        return false;
    }

    public function excludefunction()
    {
        $this->excludeRoutes = array(
            'admin/art/index',
        );
        foreach ($this->excludeRoutes as $routeString) {
            if ($this->controller == $routeString) {
                return true;
            }
        }
    }

    public function index_get() {
        print_r(phpinfo());
    }

    public function addMedium_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } elseif ($params['name'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Name should not be empty";
            } elseif ($params['status'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Status should not be empty";
            } else {

                $check = $this->common_model->checkToken($params);

                if ($check) {
                    $id = 0;
                    $params['slug'] = str_replace(' ', '_', $params['name']);
                    $params['created_date'] = date('Y-m-d');
                    $params['created_by'] = $params['userid'];
                    unset($params['platform']);
                    unset($params['roleid']);
                    unset($params['userid']);
                    $nameIfExists = $this->art_model->checkIfAlreadyExists('art_medium', $params);
                    if (count($nameIfExists) == 0) {
                        $id = $this->art_model->insert('art_medium', $params);
                        if ($id > 0) {
                            $this->jsonarr["IsSuccess"] = true;
                            $this->jsonarr["ResponseObject"] = "Art medium added successfully";
                        } else {
                            $this->jsonarr["IsSuccess"] = false;
                            $this->jsonarr["ErrorObject"] = "Failed to add a art medium";
                        }
                    } else {
                        $this->jsonarr["IsSuccess"] = false;
                        $this->jsonarr["ErrorObject"] = "Art medium name already exists";
                    }

                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }
        return $this->printjson($this->jsonarr);
    }

    public function mediumList_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } else {
                $check = $this->common_model->checkToken($params);
                if ($check) {
                    $MediumList = array();
                    $MediumList = $this->art_model->getList('art_medium');
                    $this->jsonarr["IsSuccess"] = true;
                    $this->jsonarr["ResponseObject"] = $MediumList;
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        }else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }

        return $this->printjson($this->jsonarr);
    }

    public function editMedium_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } elseif ($params['mediumid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Medium Id should not be empty";
            } elseif ($params['name'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Name should not be empty";
            } elseif ($params['status'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Status should not be empty";
            } else {
                $check = $this->common_model->checkToken($params);
                if ($check) {
                    $mediumid = $params['mediumid'];
                    unset($params['platform']);
                    unset($params['roleid']);
                    unset($params['mediumid']);
                    unset($params['userid']);
                    $edit = $this->art_model->edit('art_medium', $mediumid, $params);
                    if ($edit) {
                        $this->jsonarr["IsSuccess"] = true;
                        $this->jsonarr["ResponseObject"] = "Art medium updated successfully";
                    } else {
                        $this->jsonarr["IsSuccess"] = false;
                        $this->jsonarr["ErrorObject"] = "Failed to update a art medium";
                    }
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }

        return $this->printjson($this->jsonarr);
    }

    public function deleteMedium_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } elseif ($params['mediumid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Series Id should not be empty";
            } else {
                $check = $this->common_model->checkToken($params);
                if ($check) {
                    $delete = $this->art_model->delete('art_medium', $params['mediumid']);
                    if ($delete) {
                        $this->jsonarr["IsSuccess"] = true;
                        $this->jsonarr["ResponseObject"] = "Art medium deleted successfully";
                    } else {
                        $this->jsonarr["IsSuccess"] = false;
                        $this->jsonarr["ErrorObject"] = "Failed to delete a art medium";
                    }
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }

        return $this->printjson($this->jsonarr);
    }

    public function addSurface_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } elseif ($params['name'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Name should not be empty";
            } elseif ($params['status'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Status should not be empty";
            } else {

                $check = $this->common_model->checkToken($params);

                if ($check) {
                    $id = 0;
                    $params['slug'] = str_replace(' ', '_', $params['name']);
                    $params['created_date'] = date('Y-m-d');
                    $params['created_by'] = $params['userid'];
                    unset($params['platform']);
                    unset($params['roleid']);
                    unset($params['userid']);
                    $nameIfExists = $this->art_model->checkIfAlreadyExists('art_surface', $params);
                    if (count($nameIfExists) == 0) {
                        $id = $this->art_model->insert('art_surface', $params);
                        if ($id > 0) {
                            $this->jsonarr["IsSuccess"] = true;
                            $this->jsonarr["ResponseObject"] = "Art surface added successfully";
                        } else {
                            $this->jsonarr["IsSuccess"] = false;
                            $this->jsonarr["ErrorObject"] = "Failed to add a art surface";
                        }
                    } else {
                        $this->jsonarr["IsSuccess"] = false;
                        $this->jsonarr["ErrorObject"] = "Art surface name already exists";
                    }

                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }
        return $this->printjson($this->jsonarr);
    }

    public function surfaceList_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } else {
                $check = $this->common_model->checkToken($params);
                if ($check) {
                    $surfaceList = array();
                    $surfaceList = $this->art_model->getList('art_surface');
                    $this->jsonarr["IsSuccess"] = true;
                    $this->jsonarr["ResponseObject"] = $surfaceList;
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }

        return $this->printjson($this->jsonarr);
    }

    public function editSurface_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } elseif ($params['surfaceid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Surface Id should not be empty";
            } elseif ($params['name'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Name should not be empty";
            } elseif ($params['status'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Status should not be empty";
            } else {
                $check = $this->common_model->checkToken($params);
                if ($check) {
                    $surfaceid = $params['surfaceid'];
                    unset($params['platform']);
                    unset($params['roleid']);
                    unset($params['surfaceid']);
                    unset($params['userid']);
                    $edit = $this->art_model->edit('art_surface', $surfaceid, $params);
                    if ($edit) {
                        $this->jsonarr["IsSuccess"] = true;
                        $this->jsonarr["ResponseObject"] = "Art surface updated successfully";
                    } else {
                        $this->jsonarr["IsSuccess"] = false;
                        $this->jsonarr["ErrorObject"] = "Failed to update a art surface";
                    }
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }

        return $this->printjson($this->jsonarr);
    }

    public function deleteSurface_post(){

        $params = json_decode(file_get_contents('php://input'), true);

        if ($this->common_model->checkPermissions($this->controller, $params['roleid'])) {

            if ($params['platform'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Platform should not be empty";
            } elseif ($params['roleid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Role Id should not be empty";
            } elseif ($params['userid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "User Id should not be empty";
            } elseif ($params['surfaceid'] == "") {
                $this->jsonarr["IsSuccess"] = false;
                $this->jsonarr["ErrorObject"] = "Series Id should not be empty";
            } else {
                $check = $this->common_model->checkToken($params);
                if ($check) {
                    $delete = $this->art_model->delete('art_surface', $params['surfaceid']);
                    if ($delete) {
                        $this->jsonarr["IsSuccess"] = true;
                        $this->jsonarr["ResponseObject"] = "Art surface deleted successfully";
                    } else {
                        $this->jsonarr["IsSuccess"] = false;
                        $this->jsonarr["ErrorObject"] = "Failed to delete a art surface";
                    }
                } else {
                    $this->jsonarr["IsSuccess"] = false;
                    $this->jsonarr["ErrorObject"] = "Unauthorised User";
                }
            }
        } else {
            $this->jsonarr["IsSuccess"] = false;
            $this->jsonarr["ErrorObject"] = "You don't have permission to access this page";
        }

        return $this->printjson($this->jsonarr);
    }

    private function printjson($jsonarr)
    {
        echo json_encode($jsonarr);
    }


}