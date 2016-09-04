<?php

class AppTesterError{
    private static $instance;
    
    function __construct(){
        
    }
    
    public function showHTMLError($error, $errorMsg){
        ?>
    <div class='error-msg-box'>
        <p class='error-msg'><?php echo $errorMsg; ?></p>
    </div>
        
        <?php
    }
 
    static function getInstance(){
        if(!isset(self::$instance)){
            self::$instance = new self();

        } 
        
        return self::$instance;

    }
    
    static function displayHTML($error, $errorMsg){
        $instance = self::getInstance();
        
        $instance->showHTMLError($error, $errorMsg);
    }
}
