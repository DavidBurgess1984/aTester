<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="#">SmartTest</a>
        </div>
        
      </div>
    </nav>

    
        
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Create New User Account</h1>
            <div class="account-wall">
                <?php if( isset($error) && count($error) > 0) : ?>
                    <?php AppTesterError::displayHTML('', $error)?>
                <?php endif; ?>
                
                <form method='POST' class="form-create-user form-inline"  action="<?php echo base_url('index.php/createUser/validateUserCreation');?>">
                    
                    <ul >
                        <li class="form-li">
                            <label class='form-new-label'>Email: </label>
                            <input type="text" value="<?php echo ( $email ) ? $email : '' ?>" name='email' class="form-control" placeholder="Email" autofocus>
                        </li>
                        <li class="form-li">
                            <label class='form-new-label'>Password: </label>
                            <input type="password" name='password' class="form-control" placeholder="Enter Password" >
                
                        </li>
                        <li class="form-li">
                            <label class='form-new-label'>Confirm Password: </label>
                            <input type="password" name='password1' class="form-control" placeholder="Enter Password Again" >
                
                        </li>
                        
                        <li class="form-li">
                             <button class="btn btn-md btn-primary " type="submit">Create</button>
                        </li>
                    </ul>
                   
               
                </form>
            </div>

        </div>
    </div>
    </div><!-- /.container -->