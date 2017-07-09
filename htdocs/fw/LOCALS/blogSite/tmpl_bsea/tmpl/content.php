<!-- begin mainContainer -->
<div class="mainContainer">
	<div class="fullwidth topbar black blkcat<?= $core->idTree ?> space" id='topbar-bsea'> <!-- begin topbar -->
	    <div class="block overflow">
		    <div class="logo">
                <a class="inherit" href="/">The Black Sea </a>
                &nbsp; <span class="blue"> Diving Deep into Stories</span>
            </div>
            <!--<ul class="mainNav">
                <li class="navitem">archive</li>
                <li class="navitem">blog</li>
                <li class="navitem">about </li>
            </ul>-->

            <div class='search-form'>
                <form action='' method='post'>
                    <input type='text' value='' name='searchText'>
                    <input type='submit' name='search' value='search'>
                    <!--?mgrName=blog&hndl=search-->
                    <input type='hidden' name='mgrName' value='blog'>
                    <input type='hidden' name='hndl' value='search'>
                </form>
            </div>
            <?php
                echo $core->Render_ModulefromRes($core->ivyMenu, 'superfish');
            ?>
	    </div>
	</div>
    <div class="clearfix"></div>
    <!-- end topbar -->
    <div>
        <div>
            <?php echo !$core->admin ? '' : $core->Render_Module($core->feedback); ?>
        </div>
        <div class="clearfix"></div>
    </div>
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

