

<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">SmartTest</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="<?php echo base_url('index.php/dash'); ?>">Home</a></li>
            <li <?php echo ($page === 'project')? 'class="active"': '';?>><a href="<?php echo base_url('index.php/projects'); ?>">Projects</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 col-lg-2">
          <nav class="navbar navbar-default navbar-fixed-side">
            <div class="container">
              <div class="navbar-header">
                <button class="navbar-toggle" data-target=".navbar-collapse" data-toggle="collapse">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <!--<a class="navbar-brand" href="./">BS3 Side Navbar</a>-->
              </div>
              <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                  <li class="active">
                    <a href="./">Create New Project</a>
                  </li>
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Existing Projects <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                          <li><a href="#">Android Car Hire</a></li>
                            <li><a href="#">Test App</a></li>

                  </ul></li>
                </ul>
                <!--<form class="navbar-form navbar-left">
                  <div class="form-group">
                    <input class="form-control" placeholder="Search">
                  </div>
                  <button class="btn btn-default">Search</button>
                </form>
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">Page 4</a></li>
                </ul>
                <button class="btn btn-default navbar-btn">Button</button>
                <p class="navbar-text">
                  Made by
                  <a href="http://www.samrayner.com">Sam Rayner</a>
                </p>-->
              </div>
            </div>
          </nav>
        </div>
        <div class="col-lg-10">
            <h1>Android Car Hire</h1>
            
            <ul class='form-ul'>
                <li class='form-li'>
                    <span><a>Android Testsheet Smartphone</a></span><span>Status: Open</span></li>
                </ul>
            <p>Create New Testsheet</p>
            <button>Smartphone</button>
            <button>Custom</button>
            
            <form method="POST" action='<?php  echo base_url('index.php/projects/validateCreateNewProject')?>' >
                <h4 class='sub-header'>Collaborators</h4>
                <ul class='form-ul'>
                    <li class='form-li'>Mister Dave's</li>
                    <li class='form-li'>Da Wan Ming</li>
                </ul>
                <ul class='form-ul'>
                    <h4 class='sub-header'>Add Collaborators</h4>
                <li class='form-li'><label class='form-new-label'>Email address: </label><input type='text' name='newCollaborator' /></li>
                <li class='form-li'>
                    <input type="submit" value="Send"/>
                </li>
                </ul>
            </form>
            <!--<p>To get started and create a new project, fill out the form below.</p>
            <div class='page-container'>
                <form method="POST" action='<?php  echo base_url('index.php/projects/validateCreateNewProject')?>' >
                <h4 class='sub-header'>New Project</h4>
                <span class="error-message"><?php echo $this->session->flashdata('error'); ?></span>
                <ul class='form-ul'>
                <li class='form-li'><label class='form-new-label'>Title: </label><input type='text' name='newProjectTitle' /></li>
                <li class='form-li'><label class='form-new-label'>Company: </label><input type='text' name='newProjectCompany' /><span> (optional)</span></li>
                <!--<li class='form-li'><label class='form-new-label'>Manager: </label><input type='text' name='newProjectManager' /></li>
                <li class='form-li'><label class='form-new-label'>Project Description: </label><textarea class="form-control text-area" rows="5" name="newProjectDesc" id="newProjectDesc"></textarea><!--<input type='text' name='newDeviceDesc' /></li>
                <li class='form-li'><label class='form-new-label'>Initial Deadline: </label><input type='text' class="datepicker" name='newProjectDeadline' /></li>
                <li class='form-li'><input type='submit' value='Create'/></li>
                </ul>
                </form> 
                </div>-->
        </div>
      <!--<div class="starter-template">
        <h1>User Login</h1>
        <p class="lead">Login using your email address or through a third party provider</p>
      </div>-->
        
        
    </div>
    </div><!-- /.container -->

