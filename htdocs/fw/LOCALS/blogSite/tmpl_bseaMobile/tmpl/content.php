<!-- begin mainContainer -->
<div class="mainContainer">
	<div class="fullwidth topbar black blkcat<?= $core->idTree ?> space" id='topbar-bsea'> <!-- begin topbar -->
	    <div class="block overflow">
		    <div class="logo">
                <span style="float: left;">
                    <a class="inherit" href="/">The Black Sea </a>
                    <br>
                    <span class="blue"> Diving Deep into Stories</span>
                </span>
                <span class="menuIcon blue"></span>
            </div>
            <!--<ul class="mainNav">
                <li class="navitem">archive</li>
                <li class="navitem">blog</li>
                <li class="navitem">about </li>
            </ul>-->

            <?php
                echo $core->Render_ModulefromRes($core->ivyMenu, 'superfish');
            ?>
	    </div>
	</div>
    <div class="clearfix"></div>
    <!-- end topbar -->

    <?php

        //isset($_GET['login']) && include "login.html";



        //echo $core->mgrName."<br>";
        $obName = $core->mgrName;
        /*echo "sitePrez - content.php : "
            .(is_object($core->$obName)
               ? 'este obiect <br>'
               : 'nu este obiect <br>');*/
        echo $core->Handle_Render($core->$obName);
     ?>
</div>

