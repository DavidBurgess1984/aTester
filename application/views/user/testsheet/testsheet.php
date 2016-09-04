
        <div class="col-lg-6">
            <h1><?php echo $categoryName; ?></h1>
            <ul class="form-ul">
                <?php if (isset($questions) && $questions && count($questions) >0 ):?>
                <?php foreach($questions as $question): ?>
                <li class="form-li"><h4><?php echo $question->title; ?></h4>
                    <input type='hidden' class='testsheetQuestionID' value='<?php echo $question->idTestSheetQuestion; ?>' disabled='disabled' />
                        <div class="response" style="/*width:100%*/">
                            <div class="pull-right">
                                
                                     <input type='checkbox' class='isQuestionComplete' 
                                      <?php  if($question->status === 1): ?>
                                            checked='checked'
                                      <?php endif;?>
                                            /> <span class="italic" >Complete</span>
                            </div>
                            
                            <h5 style='color:#3CBAE2'><span style='cursor:pointer' class='toggleResponses glyphicon glyphicon-menu-down'></span></h5>
                            <ul class="form-ul response-container" style='border-bottom:1px double #C5C5C5'>
                            <?php if($question->responses):?>
                             
                                 
                                 
                                 
                                <?php foreach($question->responses as $response): ?>
                           
                                 <li class='form-li' style='margin-bottom:0;'>
                                     <input class='responseID' value='<?php echo $response->id; ?>' type='hidden' />
                                     <div style='padding:5px;border:1px solid #C5C5C5;background-color:#f8f8f8;border-bottom:0;text-align:right'>
                                        <span style='color:#3CBAE2;font-size:12px;'><?php echo $response->email; ?></span>
                                        <?php if($userID === $response->userID): ?>
                                            <button type='button' class='btn btn-default btn-xs edit-response-btn'><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
                                            <button type='button' class='btn btn-default btn-xs delete-response-btn'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                                        <?php endif; ?>
                                     
                                     </div>
                                     <div class='response-box' style='padding:5px;height:50px;border:1px solid #C5C5C5;border-bottom:0;margin-bottom:0'>
                                        <span class='response-content'><?php echo $response->content; ?></span>
                                     </div> 
                                     
                                     <div style='display:none;overflow:auto' class='update-response-div'>
                                         <textarea style='width:100%;resize:none' class='edit-response-textarea'><?php echo $response->content; ?></textarea>
                                         <button style='margin-bottom:12px;float:right;' class="btn btn-primary response-write float-right">Save</button>
                                     </div>
                                 </li>
                            
                                
                                <?php endforeach; ?>
                             
                            <?php endif; ?>
                            </ul>
                            <textarea rows="3" class="response-input" style="width:100%;resize:none;" placeholder="Enter new comment"></textarea>
                            <button style='margin-top:2px' class="btn btn-primary comment-write float-right">Write</button>
                            
                        </div>
                    </li>
                    <?php endforeach; ?>
                <?php else :?>
                    <li class="form-li">No Questions set for this Category</li>
                <?php endif; ?>
                
            </ul>
        </div>