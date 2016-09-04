<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TestSheet extends MY_Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	
	public function __construct(){
		parent::__construct();
		//$this->load->model('device_model');
                $this->load->model('category_model');
                $this->load->model('question_model');
                $this->load->model('testsheet_model');
                
                $this->load->library('form_validation');
	}
	
	public function index()
	{
            $this->listDevices();
	}
        
        public function validateNewCategory(){
            
            $categoryTitle = $this->input->post('newCategoryTitle');
            $testsheetID = $this->input->post('testsheetID');
            $this->form_validation->set_rules('newCategoryTitle', 'Category Name', 'required');
                       
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
                    redirect(base_url('index.php/testsheet/category/'.$testsheetID));
		}
                else {
                    $this->category_model->insertNewCategory($testsheetID, $categoryTitle);
                    redirect(base_url('index.php/testsheet/category/'.$testsheetID));
                }
        }
        
        public function validateUpdateCategory(){
            
            $categoryTitle = $this->input->post('new-category-title');
            $testsheetID = $this->input->post('testsheetID');
            $categoryID = $this->input->post('categoryID');
            $this->form_validation->set_rules('new-category-title', 'Category Name', 'required');
                       
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
                    redirect(base_url('index.php/testsheet/category/'.$testsheetID));
		}
                else {
                    $this->category_model->updateNewCategory($categoryID, $categoryTitle);
                    redirect(base_url('index.php/testsheet/category/'.$testsheetID));
                }
        }
        
        public function category($testsheetID){
            
            $data['userID'] = $this->getLoginUserID();
            $data['userEmail'] = $this->getLoginUserEmail();
            $data['page'] = 'Categories';
            $data['testsheetID'] = $testsheetID;
            
            $data['categories'] = $this->category_model->loadAllCustomCategories($testsheetID);
            $this->load->view('user/header', $data);
            $this->load->view('user/main-nav',$data);
            $this->load->view('user/category-side-nav',$data);
            $this->load->view('user/custom/categories',$data);
            //$this->load->view('user/custom/newCategory',$data);
            
            $this->load->view('user/jsfiles');
            $this->load->view('user/sockets/responseSocket');
            $this->load->view('user/footer');
        }
        
        public function overview(){
            
            $param = $this->uri->uri_to_assoc(3);
            $testsheetID = $param['testsheetID'];
            $isCustom = $this->testsheet_model->isCustomTestsheet($testsheetID);
            
            if($isCustom){
                if($this->testsheet_model->hasNoCategories($testsheetID)){
                    redirect(base_url('index.php/testsheet/category/'.$testsheetID));
                }
            }
            //if not custom do default
            
            // else
            
            //check custom category count
            //if zero default to create category page
            
            //else// show first category
            
            $categoryID = isset($param['categoryID']) ? $param['categoryID'] : '1';
            
            $data['userID'] = $this->getLoginUserID();
            $data['userEmail'] = $this->getLoginUserEmail();
            $data['categoryName'] = $this->category_model->loadCategoryNameById($categoryID);
            
            //$data['isCustom'] = $isCustom;
            $data['projectID'] = $this->testsheet_model->getProjectIDByTestsheet($testsheetID);

            $data['categories'] = $this->category_model->loadAllCategories($testsheetID);
            $data['questions'] = $this->question_model->getAllQuestions($testsheetID,$categoryID);
            $data['page'] = 'projects';
            $data['testsheetID'] = $testsheetID;
            $data['categoryID'] = $categoryID;
        
            $this->load->view('user/header', $data);
            $this->load->view('user/main-nav',$data);
            $this->load->view('user/testsheet-side-nav',$data);
            $this->load->view('user/testsheet/testsheet',$data);
            $this->load->view('user/jsfiles');
            $this->load->view('user/sockets/responseSocket');
            $this->load->view('user/footer');
            
        }
        public function create(){
            $projectID = mysqli_real_escape_string($this->db->conn_id,$this->input->post('projectID'));
            $testSheetTitle = mysqli_real_escape_string($this->db->conn_id,$this->input->post('testSheetTitle'));
            $deviceType = mysqli_real_escape_string($this->db->conn_id,$this->input->post('deviceType'));
            $isCustom = false;
            
            switch($deviceType){
                case 'smartphone':
                    $isCustom = false;
                    break;
                case 'custom':
                    $isCustom = true;
                    break;
            }
            
            $this->testsheet_model->createTestSheet($projectID, $isCustom,$testSheetTitle);
        }
	
        public function deleteCategory(){
            
            $testsheetID = $this->input->post('testsheetID');
            $categoryID = $this->input->post('categoryID');
            
            $this->category_model->deleteCategory($testsheetID, $categoryID);
             redirect(base_url('index.php/testsheet/category/'.$testsheetID));
        }
        
        /*
	public function listDevices(){
		$this->load->view('template/header');
                $data['devices'] = $this->device_model->loadDevices();
                
                $this->load->view('device/table/devices.php',$data);
                $this->load->view('device/form/newDeviceForm.php');
		$this->load->view('template/footer');
	}*/
	/*
	public function doCreateDevice(){
		$insertRec = $this->device_model->insertNewDevice($this->input->post('newDeviceDesc'));
		if(!$insertRec){
			//throw error message
		} else {
			redirect('devices/listDevices');
		}
	}*/
        /*
        public function selectDevice(){
            $this->load->view('bootstrap/header');
		$this->load->view('bootstrap/device/main');
		$this->load->view('bootstrap/footer');
        }*/
        
        /*
        public function listQuestions(){
            $param = $this->uri->uri_to_assoc(3);
            if(is_array($param)  && empty($param)){
                redirect(base_url('index.php/devices'));
            }
            
            $data['questionsInCategories'] = $this->question_model->getQuestionsGroupedIntoCategories($param['id']);
            $data['device'] = $this->device_model->getDevice($param['id']);
            $data['categories'] = $this->category_model->loadAllCategories($param['id']);
        }*/
}
