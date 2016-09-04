

    
        <div class="col-lg-6">
            <h4>Create New Questions</h4>

            <span class="error-message"><?php echo $this->session->flashdata('error'); ?></span>
            <?php if($questions !== false && count($questions) > 0) :?>

            <ul class='form-ul'>

            <?php foreach($questions as $question):?>


                                <li class='form-li'>
                                    <span style="display:inline-block;width:300px;"><?php echo $question->title;?></span>
                                    
                                    <form style="display:inline-block"action="<?php echo base_url('index.php/question/deleteQuestion'); ?>" method="POST">
                                        <input type='hidden'  class='questionID' name='questionID' value='<?php echo $question->id; ?>' />    
                                        <input type='hidden'  class='testsheetID' name='testsheetID' value='<?php echo $testsheetID; ?>' />
                                        <input type='hidden'  class='categoryID' name='categoryID' value='<?php echo $categoryID; ?>' />
                                        <button type='button' class='btn btn-default btn-xs edit-question-btn'><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                        <button type='button' class='btn btn-default btn-xs delete-question-btn'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </form>        
                                            
                                </li>
                                <li style='display:none'class='form-li edit-question-name'>
                                    <div>
                                        <form action="<?php echo base_url('index.php/question/validateUpdateQuestion'); ?>" method="POST">
                                        <label class="form-new-label">Change Category:</label>
                                        <input type='hidden' disabled='disabled' class='questionID' name='questionID' value='<?php echo $question->id; ?>' />
                                        <input type='hidden' disabled='disabled' class='categoryID' name='categoryID' value='<?php echo $categoryID; ?>' />
                                        <input type='hidden' disabled='disabled' class='testsheetID' name='testsheetID' value='<?php echo $testsheetID; ?>' />
                                        <textarea style='resize:none;width:300px;height:50px'  name='new-question-title' class='new-question-title' ><?php echo $question->title; ?></textarea> 
                                        
                                        <button type='submit' class='btn btn-primary btn-xs save-category-btn' >Save</button>
                                        </form>
                                    </div>
                                </li>
            <?php endforeach; ?>

            

            <?php else :?>
                                <li class='form-li'>No Questions Created</li>
            <?php endif; ?>

             </ul> 
                
        
             
             <!--<button>Create</button>
           <button>Custom</button>-->
            <div>
                <form action="<?php echo base_url('index.php/question/validateNewQuestion'); ?>" method="POST" >
                    
                <ul class='form-ul'>
                    <li class='form-li'>
                        <label  class="form-new-label">New Question:</label>
                        <textarea style='resize:none;width:300px;height:50px' id='newQuestionTitle' name="newQuestionTitle" ></textarea>
                    </li>
                    <li class='form-li'>
                        <input type='hidden' name='categoryID' value='<?php echo $categoryID; ?>' />
                        <input type='hidden' name='testsheetID' value='<?php echo $testsheetID; ?>' />
                        <input id='createQuestionBtn' type='submit' value="Create"/>
                    </li>
                </ul>
                </form>
            </div>
        </div>
           
   