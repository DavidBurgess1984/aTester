
        <div class="col-lg-10">
            <h1>Create New Project</h1>
 
            <p>To get started and create a new project, fill out the form below.</p>
            <div class='page-container'>
                <form method="POST" action='<?php  echo base_url('index.php/projects/validateCreateNewProject')?>' >
                <h4 class='sub-header'>New Project</h4>
                <span class="error-message"><?php echo $this->session->flashdata('error'); ?></span>
                <ul class='form-ul'>
                <li class='form-li'><label class='form-new-label'>Title: </label><input type='text' name='newProjectTitle' /></li>
                <li class='form-li'><label class='form-new-label'>Company: </label><input type='text' name='newProjectCompany' /><span> (optional)</span></li>
                <li class='form-li'><label class='form-new-label'>Project Description: </label><textarea class="form-control text-area" rows="5" name="newProjectDesc" id="newProjectDesc"></textarea></li>
                <li class='form-li'><label class='form-new-label'>Initial Deadline: </label><input type='text' class="datepicker" name='newProjectDeadline' /></li>
                <li class='form-li'><input type='submit' value='Create'/></li>
                </ul>
                </form> 
                </div>
        </div>
      <!--<div class="starter-template">
        <h1>User Login</h1>
        <p class="lead">Login using your email address or through a third party provider</p>
      </div>-->
        
        
    </div>
    </div><!-- /.container -->

