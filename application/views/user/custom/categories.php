

    
        <div class="col-lg-6">
            <h4>Create New Category</h4>

            <span class="error-message"><?php echo $this->session->flashdata('error'); ?></span>
            <?php if(count($categories) > 0) :?>

            <ul class='form-ul'>

            <?php foreach($categories as $category):?>


                                <li class='form-li'>
                                    <span style="display:inline-block;width:300px;"><?php echo $category->description;?></span>
                                    <form style='display:inline-block' action="<?php echo base_url('index.php/testsheet/deleteCategory'); ?>" method="POST">
                                         <input type='hidden' class='categoryID' name='categoryID' value='<?php echo $category->id; ?>' />
                                        <input type='hidden'  class='testsheetID' name='testsheetID' value='<?php echo $testsheetID; ?>' />
                                    <button type='button' class='btn btn-default btn-xs edit-category-btn'><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                    <button type='button' class='btn btn-default btn-xs delete-category-btn'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                    </form>       
                                            
                                </li>
                                <li style='display:none'class='form-li edit-category-name'>
                                    <div>
                                        <form action="<?php echo base_url('index.php/testsheet/validateUpdateCategory'); ?>" method="POST">
                                        <label class="form-new-label">Change Category:</label>
                                        <input type='hidden' disabled='disabled' class='categoryID' name='categoryID' value='<?php echo $category->id; ?>' />
                                        <input type='hidden' disabled='disabled' class='testsheetID' name='testsheetID' value='<?php echo $testsheetID; ?>' />
                                        <input name='new-category-title' class='new-category-title' type='text' value='<?php echo $category->description; ?>' />
                                        <button type='submit' class='btn btn-primary btn-xs save-category-btn' >Save</button>
                                        </form>
                                    </div>
                                </li>
            <?php endforeach; ?>

            </ul>

            <?php endif; ?>

              
                
        
             
             <!--<button>Create</button>
           <button>Custom</button>-->
            <div>
                <form action="<?php echo base_url('index.php/testsheet/validateNewCategory'); ?>" method="POST" >
                    
                <ul class='form-ul'>
                    <li class='form-li'>
                        <label  class="form-new-label">New Category:</label>
                        <input id='newCategoryTitle' name="newCategoryTitle" type="text" />
                    </li>
                    <li class='form-li'>
                        <input type='hidden' name='testsheetID' value='<?php echo $testsheetID; ?>' />
                        <input id='createCategoryBtn' type='submit' value="Create"/>
                    </li>
                </ul>
                </form>
            </div>
        </div>
           
   