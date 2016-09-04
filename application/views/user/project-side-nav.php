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
                  
                  <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Existing Projects <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <?php if(isset($projects) && $projects && count($projects) >0): ?>
                            <?php foreach($projects as $project):?>
                          <li <?php echo(isset($projectID) && intval($project->id) === intval($projectID)) ? 'class="active"' : '';?> ><a href="<?php echo base_url('index.php/projects/projectManager/'.$project->id);?>"><?php echo $project->title; ?></a></li>
                            <?php endforeach; ?>
                          <?php endif; ?>
                  </ul></li>
                  <li <?php echo (isset($sideNav) && $sideNav && $sideNav === 'project-create') ? 'class="active"' :''; ?> >
                    <a href="<?php echo base_url('index.php/projects/createProject'); ?>">Create New Project</a>
                  </li>
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
        </div><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

