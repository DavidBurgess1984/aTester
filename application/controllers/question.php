<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question extends MY_Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	
	public function __construct(){
		parent::__construct();
		$this->load->model('question_model');
                //$this->load->model('device_model');
                $this->load->model('category_model');
                
                $this->load->library('form_validation');
	}
	
	public function index()
	{
            $this->showQuestionsByCategory();
            //$this->load->view('welcome_message');
	}
	
	public function listQuestions(){
            
            $param = $this->uri->uri_to_assoc(3);
            if(is_array($param)  && empty($param)){
                redirect(base_url('index.php/devices'));
            }
            
            $data['questionsInCategories'] = $this->question_model->getQuestionsGroupedIntoCategories($param['id']);
            $data['device'] = $this->device_model->getDevice($param['id']);
            $data['categories'] = $this->category_model->loadAllCategories($param['id']);
            $this->load->view('template/header');

            $this->load->view('questions/table/questions.php',$data);
            $this->load->view('questions/form/newQuestionForm.php',$data);
            $this->load->view('template/footer');
	}
	
	public function doCreateQuestion(){
		$insertRec = $this->question_model->insertNewQuestion($this->input->post('newQuestionDesc'),$this->input->post('deviceId'),$this->input->post('categoryId'));
		if(!$insertRec){
			//throw error message
		} else {
			redirect('question/listQuestions/id/'.$this->input->post('deviceId'));
		}
	}
        
        public function overview($categoryID =1, $deviceID =1){
            $data['categories'] = $this->category_model->loadAllCategories($categoryID);
            $data['questions'] = $this->question_model->getAllQuestions($deviceID,$categoryID);
            $data['page'] = 'project';
            $this->load->view('user/header', $data);
            $this->load->view('user/projectDevice/projectDevice',$data);
            $this->load->view('user/jsfiles');
            $this->load->view('user/footer');
        }
        
        public function showQuestionsByCategory(){
            
            $param = $this->uri->uri_to_assoc(3);
            $testsheetID = $param['testsheetID'];
            $categoryID = $param['categoryID'];
            
            $data['userID'] = $this->getLoginUserID();
            $data['userEmail'] = $this->getLoginUserEmail();
            $data['page'] = 'Categories';
            $data['testsheetID'] = $testsheetID;
            $data['categoryID'] = $categoryID;
            $data['categories'] = $this->category_model->loadAllCustomCategories($testsheetID);
            
            $data['questions'] = $this->category_model->loadQuestionsByCategory($categoryID);
            $this->load->view('user/header', $data);
            $this->load->view('user/main-nav',$data);
            $this->load->view('user/category-side-nav',$data);
            $this->load->view('user/custom/questions',$data);
            //$this->load->view('user/custom/newCategory',$data);
            
            $this->load->view('user/jsfiles');
            $this->load->view('user/sockets/responseSocket');
            $this->load->view('user/footer');
        }
        
    public function validateNewQuestion(){
            
            $questionTitle = $this->input->post('newQuestionTitle');
            $categoryID = $this->input->post('categoryID');
            $testsheetID = $this->input->post('testsheetID');
            $this->form_validation->set_rules('newQuestionTitle', 'Question Name', 'required');
                       
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
                    redirect(base_url('/index.php/question/showQuestionsByCategory/categoryID/'.$categoryID.'/testsheetID/'.$testsheetID));
		}
                else {
                    $this->category_model->insertNewQuestion($categoryID, $questionTitle, $testsheetID);
                    redirect(base_url('index.php/question/showQuestionsByCategory/categoryID/'.$categoryID.'/testsheetID/'.$testsheetID));
                }
        }
        
    public function validateUpdateQuestion(){
            
            $questionTitle = $this->input->post('new-question-title');
            $questionID = $this->input->post('questionID');
            $categoryID = $this->input->post('categoryID');
            $testsheetID = $this->input->post('testsheetID');
            $this->form_validation->set_rules('new-question-title', 'Question Name', 'required');
                       
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
                    redirect(base_url('index.php/question/showQuestionsByCategory/categoryID/'.$categoryID.'/testsheetID/'.$testsheetID));
		}
                else {
                    $this->category_model->updateQuestion($questionID, $questionTitle);
                    redirect(base_url('index.php/question/showQuestionsByCategory/categoryID/'.$categoryID.'/testsheetID/'.$testsheetID));
                }
        }
        
       public function deleteQuestion(){
           $questionID = $this->input->post('questionID');
           $testsheetID = $this->input->post('testsheetID');
           $categoryID = $this->input->post('categoryID');
           $this->question_model->deleteCustomQuestion($questionID);
           redirect(base_url('/index.php/question/showQuestionsByCategory/categoryID/'.$categoryID.'/testsheetID/'.$testsheetID));
       }
}
