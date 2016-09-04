<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          
          <a class="navbar-brand" href="#">SmartTest</a>
        </div>
        
      </div>
    </nav>

    
        
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign in to continue to SmartTest</h1>
            <div class="account-wall">
                <?php if( isset($error) && count($error) > 0) : ?>
                    <?php AppTesterError::displayHTML($error['title'], $error['message'])?>
                <?php endif; ?>
                <img class="profile-img" src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120"
                    alt="">
                <form method='POST' class="form-signin"  action="<?php echo base_url('index.php/user/validateLogin');?>">
                <input type="text" name='email' class="form-control" placeholder="Email" required autofocus>
                <input type="password" name='password' class="form-control" placeholder="Password" required>
                <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in</button>
                <label class="checkbox pull-left">
                    <input type="checkbox" value="remember-me">
                    Remember me
                </label>
                
                <a href="#" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="<?php echo base_url('index.php/user/create');?>" class="text-center new-account">Create an account </a>
        </div>
    </div>
    </div><!-- /.container -->