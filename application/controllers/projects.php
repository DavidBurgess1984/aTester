<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projects extends MY_Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	
	public function __construct(){
		parent::__construct();
		//$this->load->model('device_model');
                $this->load->model('project_model');
                $this->load->model('testsheet_model');
                $this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
	}
	
        public function index(){
            $data['page'] = 'projects';
            $data['sideNav'] = 'project-dash';
            $data['projects'] = $this->getProjects();
            $this->load->view('user/header');
            $this->load->view('user/main-nav',$data);
            $this->load->view('user/project-side-nav',$data);
            $this->load->view('user/project/dash',$data);
            $this->load->view('user/jsfiles');
            $this->load->view('user/footer');
        }
        
	public function createProject(){
                
                $data['page'] = 'projects';
                
                $data['sideNav'] = 'project-create';
                $data['projects'] = $this->getProjects();
                $this->load->view('user/header');
                $this->load->view('user/main-nav',$data);
                $this->load->view('user/project-side-nav',$data);
		$this->load->view('user/project/createProject',$data);
                $this->load->view('user/jsfiles');
		$this->load->view('user/footer');
	}
        
        public function validateCreateNewProject(){
            $this->form_validation->set_rules('newProjectTitle', 'Title', 'required');
            $this->form_validation->set_rules('newProjectDesc', 'Description', 'required');
            $this->form_validation->set_rules('newProjectDeadline', 'Deadline Date', 'required');
            
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
			$this->index();
		}
		else
		{
                    $this->doCreateProject();
		}
        }
	
	/*public function listDevices(){
		$this->load->view('user/header');
                $data['devices'] = $this->device_model->loadDevices();
                
                $this->load->view('user/device/table/devices.php',$data);
                $this->load->view('user/device/form/newDeviceForm.php');
		$this->load->view('user/footer');
	}*/
	
	public function doCreateProject(){
            
                $userID = $this->getLoginUserID();
		$insertRec = $this->project_model->insertNewProject(
                                                            $this->input->post('newProjectTitle'),
                                                            $userID,
                                                            $this->input->post('newProjectCompany'),
                                                            $this->input->post('newProjectDesc'),
                                                            $this->input->post('newProjectDeadline')
                                );
		if(!$insertRec){
			//throw error message
		} else {
                        $projectID = $this->db->insert_id();
			redirect(base_url('index.php/projects/ProjectManager/'.$projectID));
		}
	}
        
        public function projectManager($projectID){
             $data['userID'] = $this->getLoginUserID();
             $data['userEmail'] = $this->getLoginUserEmail();
             //$data['isCustom'] = $this->testsheet_model->isCustomTestsheet($testsheetID);
            $data['page'] = 'projects';
            $data['side-nav'] = $projectID;
            $data['projectID'] =  $projectID;
            $data['projectManager'] = $this->project_model->getProjectManager($projectID);
            $data['projects'] = $this->getProjects();
            $data['testsheets'] = $this->testsheet_model->loadTestsheetsByProject($projectID);
            $data['projectInfo'] = $this->project_model->getProject($projectID);
            $data['collaborationID'] = $this->project_model->getCollaborationID($projectID);
            $data['collaborators'] = $this->project_model->getCollaborators($this->getLoginUserID(), $projectID);
            $this->load->view('user/header');
            $this->load->view('user/main-nav',$data);
            $this->load->view('user/project-side-nav',$data);
            $this->load->view('user/project/main',$data);
            $this->load->view('user/jsfiles');
            $this->load->view('user/sockets/testsheetSocket');
            $this->load->view('user/footer', $data);
        }
        
        public function getProjects(){
            return $this->project_model->getProjectsForUser($this->getLoginUserID());
        }
        
        public function validateNewTestsheet(){
            $this->form_validation->set_rules('testsheetTitle', 'Testsheet Title', 'required');
            
            
            $projectID = $this->input->post('projectID');
            $testsheetType = $this->input->post('testsheetType');
            $testsheetTitle = $this->input->post('testsheetTitle');
            $isCustom = false;
            switch($testsheetType){
                case 'smartphone':
                    $isCustom = false;
                    break;
                case 'custom':
                    //do something else;
                    $isCustom = true;
                    break;
            }
            
            if ($this->form_validation->run() == FALSE)
		{
                    $this->session->set_flashdata('error', validation_errors());
			$this->projectManager($projectID);
		}
		else
		{
                    $this->testsheet_model->createTestsheet($projectID,$isCustom,$testsheetTitle);
                    redirect(base_url('index.php/projects/ProjectManager/'.$projectID));
		}
                /*else
                {
                    $this->testsheet_model->createTestsheet($projectID,$isCustom,$testsheetTitle);
                    redirect(base_url('index.php/projects/ProjectManager/'.$projectID));
                
                }*/
        }
}
