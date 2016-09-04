<!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo asset_url();?>js/jquery-1.12.1.min.js"><\/script>')</script>
    <script src="<?php echo asset_url();?>vendors/bootstrap-3.3.6-dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
   <!-- <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
    <script src="<?php echo asset_url();?>vendors/datetimepicker/jquery.js"></script>
    <script src="<?php echo asset_url();?>vendors/datetimepicker/jquery.datetimepicker.full.min.js"></script>
    <script>
      // $('.datepicker').datepicker();
       $('.datepicker').each(function(){
           $(this).datetimepicker({format:'Y-m-d H:i'});
       });
    </script>
