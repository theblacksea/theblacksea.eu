<?php
     $add_jsIncPaths[] = "assets/jquery/jquery-1.8.3.min.js";
     $add_jsIncPaths[] = "assets/onVisible/onvisible.js";
     $add_jsIncPaths[] = "assets/jquery-cookie-master/jquery.cookie.js";

     $add_jsIncName =array();
     $add_jsIncName[] = "jquery-1.8.3.min.js";
     $add_jsIncName[] = "onvisible.js";
     $add_jsIncName[] = "jquery.cookie.js";
     if(isset($core->admin) && $core->admin) {

         $add_jsIncPaths[] =  "assets/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js" ;
         /*$add_jsIncPaths[] =  "assets/nestedSortable/jquery.ui.nestedSortable.js";*/
         $add_jsIncPaths[] =  "assets/ckeditor-4.2/ckeditor.js";

         $add_jsIncName[] = "jquery-ui-1.10.3.custom.min.js";
       /*  $add_jsIncName[] = "jquery.ui.nestedSortable.js";*/
         $add_jsIncName[] = "ckeditor.js";

     }
    //var_dump($core->jsIncPaths);
    // deoarecele add.jsIncPaths trebuie sa fie la inceput
    //$core->jsIncPaths = array_merge($add_jsIncPaths, $core->jsIncPaths);



?>
<script type="text/javascript">

    head.load(
       "<?php echo implode('", "', $add_jsIncPaths);  ?>"
    );
    head.ready(
        [ "<?php echo implode('", "', $add_jsIncName);  ?>"],
        function(){
            //alert("loaded");
            head.load(
            "<?php
                 echo implode('", "', $core->jsIncPaths);
                 ?> "
            , function(){
                <?php echo $core->jsTalk; ?>
            });

    });

   head.ready( "GEN.js",
   function(){
       ivyMods = {    set_iEdit:{ /*modName : function(){}*/       } };
       <?php echo  (!$core->admin ? ''
             : "fmw.admin  = 1;").
               "fmw.idC    = ".($core->idNode ?: '""' ).";
                fmw.idT    = ".($core->idTree ?: '""').";
                fmw.pubPath = '".FW_PUB_PATH."';
                fmw.urlGet = ".json_encode($_GET).";
               ";
       ?>
   });

</script>
<!-- ======================================================================= -->

<?php
  //echo $core->jsInc;
  $footer_TMPL = TMPL_INC.'footer.php';
  if (is_file($footer_TMPL)) {
      include_once $footer_TMPL;
  }
?>

</body>
</html>
