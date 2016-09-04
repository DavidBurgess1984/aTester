<div class="col-lg-6">

            <span class="error-message"><?php echo $this->session->flashdata('error'); ?></span>
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

                <!--</form>-->