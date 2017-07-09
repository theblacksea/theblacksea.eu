<!-- begin mainContainer -->
<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
	<!-- topbar starts -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="index.html">
                    <span>The BlackSea</span>
                </a>

				<!-- theme selector starts -->
				<!--<div class="btn-group pull-right theme-container" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-tint"></i><span class="hidden-phone"> Change Theme / Skin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu" id="themes">
						<li><a data-value="classic" href="#"><i class="icon-blank"></i> Classic</a></li>
						<li><a data-value="cerulean" href="#"><i class="icon-blank"></i> Cerulean</a></li>
						<li><a data-value="cyborg" href="#"><i class="icon-blank"></i> Cyborg</a></li>
						<li><a data-value="redy" href="#"><i class="icon-blank"></i> Redy</a></li>
						<li><a data-value="journal" href="#"><i class="icon-blank"></i> Journal</a></li>
						<li><a data-value="simplex" href="#"><i class="icon-blank"></i> Simplex</a></li>
						<li><a data-value="slate" href="#"><i class="icon-blank"></i> Slate</a></li>
						<li><a data-value="spacelab" href="#"><i class="icon-blank"></i> Spacelab</a></li>
						<li><a data-value="united" href="#"><i class="icon-blank"></i> United</a></li>
					</ul>
				</div>-->
				<!-- theme selector ends -->

				<!-- user dropdown starts -->
				<!--<div class="btn-group pull-right" >
					<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
						<i class="icon-user"></i><span class="hidden-phone"> admin</span>
						<span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="#">Profile</a></li>
						<li class="divider"></li>
						<li><a href="login.html">Logout</a></li>
					</ul>
				</div>-->
				<!-- user dropdown ends -->

				<div class="btn-group pull-right">
					<ul class="nav">
						<li>
                            <form method='post' action='<?php echo BASE_URL;?>' id='previewPage'>
                               <input type='hidden' name='ivySett' value='frontAdmin'>
                               <input type='hidden' name='tmplConst' value='true'>
                               <input type='submit' class='btn ' name='changeAdmin' value='visit site'>
                            </form>
                        </li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div>
	<!-- topbar ends -->
	<?php } ?>
	<div class="container-fluid">
		<div class="row-fluid">
		<?php if(!isset($no_visible_elements) || !$no_visible_elements) { ?>

			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">

						<li class="nav-header hidden-tablet">Records</li>
						<li>
                            <a class="ajax-link" href="/?idT=88&idC=88">
                                <span class="hidden-tablet"> Stories</span>
                            </a>
                        </li>
                        <li>
                            <a class="ajax-link" href="/?idT=86&idC=86">
                                <span class="hidden-tablet"> Blogs</span>
                            </a>
                        </li>
                        <?php if(isset($core->blog)) {?>
                        <li>
                            <a class  ="ajax-link" href="#"
                               onclick='ivyMods.blog.popUpblogSettings(); return false;'
                                >
                                <span class="hidden-tablet"> blog Settings</span>
                            </a>
                        </li>
                        <?php } ?>

                        <li class="nav-header hidden-tablet"></li>

                        <?php if($core->user->uclass == 'admin') {?>
                        <li>
                            <a class="ajax-link" href="/?route=genAdmin-listItems">
                                <span class="hidden-tablet">Gen Admin</span>
                            </a>
                        </li>
                        <li>
                            <a class="ajax-link" href="/?idT=3&idC=3">
                                <span class="hidden-tablet"> Users</span>
                            </a>
                        </li>
                        <li>
                            <a class="ajax-link" href="/?idT=3&idC=3&mtf=addUser">
                                <span class="hidden-tablet"> add user</span>
                            </a>
                        </li>

                        <?} ?>

                        <li class="nav-header hidden-tablet"></li>
                        <?php
                            if(is_object($core->user)) {
                                echo $core->Render_objectFromPath($core->user,
                                    'GENERAL/user/tmpl/userMenu.html');
                            }
                        ?>

						<!--<li class="nav-header hidden-tablet">Main</li>

						<li><a class="ajax-link" href="index.html"><i class="icon-home"></i><span class="hidden-tablet"> Dashboard</span></a></li>
						<li><a class="ajax-link" href="ui.html"><i class="icon-eye-open"></i><span class="hidden-tablet"> UI Features</span></a></li>
						<li><a class="ajax-link" href="form.html"><i class="icon-edit"></i><span class="hidden-tablet"> Forms</span></a></li>
						<li><a class="ajax-link" href="chart.html"><i class="icon-list-alt"></i><span class="hidden-tablet"> Charts</span></a></li>
						<li><a class="ajax-link" href="typography.html"><i class="icon-font"></i><span class="hidden-tablet"> Typography</span></a></li>
						<li><a class="ajax-link" href="gallery.html"><i class="icon-picture"></i><span class="hidden-tablet"> Gallery</span></a></li>
						<li class="nav-header hidden-tablet">Sample Section</li>
						<li><a class="ajax-link" href="table.html"><i class="icon-align-justify"></i><span class="hidden-tablet"> Tables</span></a></li>
						<li><a class="ajax-link" href="calendar.html"><i class="icon-calendar"></i><span class="hidden-tablet"> Calendar</span></a></li>
						<li><a class="ajax-link" href="grid.html"><i class="icon-th"></i><span class="hidden-tablet"> Grid</span></a></li>
						<li><a class="ajax-link" href="file-manager.html"><i class="icon-folder-open"></i><span class="hidden-tablet"> File Manager</span></a></li>
						<li><a href="tour.html"><i class="icon-globe"></i><span class="hidden-tablet"> Tour</span></a></li>
						<li><a class="ajax-link" href="icon.html"><i class="icon-star"></i><span class="hidden-tablet"> Icons</span></a></li>
						<li><a href="error.html"><i class="icon-ban-circle"></i><span class="hidden-tablet"> Error Page</span></a></li>
						<li><a href="login.html"><i class="icon-lock"></i><span class="hidden-tablet"> Login Page</span></a></li>
                        -->
					</ul>
					<label id="for-is-ajax" class="hidden-tablet" for="is-ajax"><input id="is-ajax" type="checkbox"> Ajax on menu</label>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>

			<div id="content" class="span10">
			<!-- content starts -->
<?php } ?>
    <!--Feedback handler-->
    <div>
        <?php echo $core->Render_Module($core->feedback); ?>
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


<?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>
        <!-- content ends -->
        </div><!--/#content.span10-->
    <?php } ?>
    </div><!--/fluid-row-->
    <?php if(!isset($no_visible_elements) || !$no_visible_elements)	{ ?>

    <hr>

    <div class="modal hide fade" id="myModal">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h3>Settings</h3>
        </div>
        <div class="modal-body">
            <p>Here settings can be configured...</p>
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">Close</a>
            <a href="#" class="btn btn-primary">Save changes</a>
        </div>
    </div>

    <footer>
        <p class="pull-left">&copy; <a href="http://usman.it" target="_blank">Muhammad Usman</a> <?php echo date('Y') ?></p>
        <p class="pull-right">Powered by: <a href="http://usman.it/free-responsive-admin-template">Charisma</a></p>
    </footer>
    <?php } ?>

</div><!--/.fluid-container-->

