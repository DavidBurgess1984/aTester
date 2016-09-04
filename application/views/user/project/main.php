
        <div class="col-lg-10">
            <h1><?php echo $projectInfo->title; ?>
            <span class='project-data'>
                <span id='projectStatus'>
                    <?php if(intval($projectInfo->statusID) === 0) :?>
                    <span class='glyphicon glyphicon-list-alt' title='Open'></span>
                    <?php else: ?>
                    <span class='glyphicon glyphicon-ok' title='Closed'></span>
                    <?php endif;?>
                    
                Due: <span id='projectDeadline'><?php echo $projectInfo->deadline; ?></span>
            </span>
                            <?php if($projectManager->id === $userID):?>
                    <button id='edit-project-btn' class='btn btn-xs btn-primary'>Edit</button>
                <?php endif; ?>
            </h1>

                
                
        
            <div id='edit-project-div' style='display:none'>
                <h4>Edit Project</h4>
                <ul class='form-ul'>
                    <li class='form-li'>
                        <label class="form-new-label">Change Status</label>
                        <select id='toggle-project-status'>
                            <option value="0" <?php echo ($projectInfo->status === 'Open') ? 'selected="selected"': ''; ?>>Open</option>
                            <option value="1" <?php echo ($projectInfo->status === 'Closed') ? 'selected="selected"': ''; ?> >Closed</option>
                        </select>
                    </li>
                    <li class='form-li'>
                        <label class="form-new-label">Alter Deadline</label>
                        <input type='text' id='newProjectDeadline' value="<?php echo $projectInfo->deadline; ?>" class="datepicker" name='newProjectDeadline' />
                    </li>
                    <button id='save-project-btn' class='btn btn-primary'>Save Changes</button>
                </ul>
                
            </div>
            <div class="col-lg-5">
            <h4>Testsheets</h4>
            <ul id='testsheetlist' class='form-ul'>
                <?php if($testsheets):?>
                    <?php if (count($testsheets) >0 ): ?>
                    <?php foreach($testsheets as $testsheet): ?>
                <li class='form-li'><a style='width:200px;display:inline-block;' href="<?php echo base_url()?>index.php/testsheet/overview/testsheetID/<?php echo $testsheet->id?>"><?php echo $testsheet->title; ?></a>
                    <?php if($projectManager->id === $userID):?>
                    <button type='button' class='btn btn-default btn-sm edit-testsheet-btn'><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                    <button type='button' class='btn btn-default btn-sm delete-testsheet-btn'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                    <?php endif; ?>
                </li>
                <li style='display:none'class='form-li edit-testsheet-name'>
                    <div>
                        <label class="form-new-label">Change Title:</label>
                        <input type='hidden' disabled='disabled' class='testsheetID' value='<?php echo $testsheet->id; ?>' />
                        <input class='new-testsheet-title' type='text' value='<?php echo $testsheet->title; ?>' />
                        <button class='btn btn-primary btn-xs save-titlesheet-btn'>Save</button>
                    </div>
                    <?php if(intval($testsheet->custom_type) === 255): ?>
                        <a style='font-style:italic' href="<?php echo base_url().'index.php/testsheet/category/'.$testsheet->id;?>" >Edit Categories</a>
                    <?php endif; ?>
                </li>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php endif; ?>
                </ul>
            <?php if($projectManager->id === $userID):?>
            <h4>Create New Testsheet</h4>
            <span class="error-message"><?php echo $this->session->flashdata('error'); ?></span>
             <!--<button>Create</button>
           <button>Custom</button>-->
            <div>
                <!--<form action="<?php echo base_url('index.php/projects/validateNewTestsheet'); ?>" method="POST" >-->
                <ul class='form-ul'>
                    <li class='form-li'>
                        <label class="form-new-label">Type:</label>
                        <input type='radio'  name='testsheetType' checked='checked' value='smartphone'/>Smartphone
                        <input type='radio' name='testsheetType' value='custom'/>Custom
                    </li>
                    <li class='form-li'>
                        <label  class="form-new-label">Title:</label>
                        <input id='new-testsheet-title' name="testsheetTitle" type="text" />
                    </li>
                    <li class='form-li'>
                        <input type='hidden' name='projectID' value='<?php echo $projectID; ?>' />
                        <input id='createTestSheetBtn' type='submit' value="Create"/>
                    </li>
                </ul>
                <!--</form>-->
            </div>
             <?php endif; ?>
            </div>
            <div class='lg-col-5'>
            <form method="POST" action='<?php  echo base_url('index.php/projects/validateCreateNewProject')?>' >
                <h4 class='sub-header'>Collaborators</h4>
                <ul class='form-ul'>
                    <?php if($collaborators && count($collaborators) > 0 ): ?>
                    <?php foreach($collaborators as $collaborator): ?>
                        <li class='form-li'><?php echo $collaborator->email; ?></li>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
                <?php if($projectManager->id === $userID):?>
                <ul class='form-ul'>
                    <p class='italic sub-header'>Add New Collaborators</p>
                <li class='form-li'><label class='form-new-label'>Email address: </label><input type='text' name='newCollaborator' />
                    <input type="submit" value="Send"/>
                </li>
                </ul>
                <?php endif; ?>
            </form>
            </div>
        </div>
      <!--<div class="starter-template">
        <h1>User Login</h1>
        <p class="lead">Login using your email address or through a third party provider</p>
      </div>-->
        
        
    </div>
    </div><!-- /.container -->

