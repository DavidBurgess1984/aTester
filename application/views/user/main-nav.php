<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?php echo base_url('index.php/dash'); ?>">SmartTest</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li <?php echo ($page === 'dash')? 'class="active"' : '';?> ><a href="<?php echo base_url('index.php/dash'); ?>">Home</a></li>
            <li <?php echo ($page === 'projects')? 'class="active"' : '';?>><a href="<?php echo base_url('index.php/projects'); ?>">Projects</a></li>
            <li <?php echo ($page === 'contact')? 'class="active"' : '';?>><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav><?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

