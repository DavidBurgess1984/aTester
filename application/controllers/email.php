<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Email extends MY_Admin_Controller {

	/**
	 * Index Page for this controller.
	 *
	 */
	
	public function __construct(){
		parent::__construct();
                require_once APPPATH.'../assets/vendors/PHPMailer/PHPMailerAutoload.php';
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
        
	public function sendInviteTest(){
                $mail = new PHPMailer();
                
                $mail->isSMTP();                                      // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                               // Enable SMTP authentication
                $mail->Username = 'davidburgess1984@gmail.com';                 // SMTP username
                $mail->Password = '1.21Gigawatts';                           // SMTP password
                $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 587;                                    // TCP port to connect to

                $mail->setFrom('from@example.com', 'Mailer');
                $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
                $mail->addAddress('davidburgess1984@gmail.com');               // Name is optional
                /*$mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('cc@example.com');
                $mail->addBCC('bcc@example.com');*/

                /*$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name*/
                $mail->isHTML(true);                                  // Set email format to HTML

                $mail->Subject = 'Here is the subject';
                //$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                
                $mail->msgHTML(file_get_contents(asset_url()."email/invite.html"), dirname(__FILE__));
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                if(!$mail->send()) {
                    echo 'Message could not be sent.';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                } else {
                    echo 'Message has been sent';
                }
                
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
        }
}
