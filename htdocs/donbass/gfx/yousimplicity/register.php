<?php defined( '_JEXEC' ) or die( 'Restricted index access' ); ?>
<script type="text/javascript" src="<?php echo JURI::base() ?>media/system/js/validate.js"></script>
				<script type="text/javascript">Window.onDomReady(function(){document.formvalidator.setHandler('passverify', function (value) { return ($('password').value == value); }	);});</script>
				<form action="<?php echo JRoute::_( 'index.php?option=com_user' ); ?>" method="post" id="josForm" name="josForm" class="form-validate">
				
				<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
				<tr>
					<td width="30%" height="40">
						<label id="namemsg" for="name">
							<?php echo JText::_( 'NAME' ); ?>:
						</label>
					</td>
				  	<td>
				  		<input type="text" name="name" id="name" size="40" value="" class="inputbox required" maxlength="50" /> *
				  	</td>
				</tr>
				<tr>
					<td height="40">
						<label id="usernamemsg" for="username">
							<?php echo JText::_( 'USERNAME' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" id="username" name="username" size="40" value="" class="inputbox required validate-username" maxlength="25" /> *
					</td>
				</tr>
				<tr>
					<td height="40">
						<label id="emailmsg" for="email">
							<?php echo JText::_( 'EMAIL' ); ?>:
						</label>
					</td>
					<td>
						<input type="text" id="email" name="email" size="40" value="" class="inputbox required validate-email" maxlength="100" /> *
					</td>
				</tr>
				<tr>
					<td height="40">
						<label id="pwmsg" for="password">
							<?php echo JText::_( 'PASSWORD' ); ?>:
						</label>
					</td>
				  	<td>
				  		<input class="inputbox required validate-password" type="password" id="password" name="password" size="40" value="" /> *
				  	</td>
				</tr>
				<tr>
					<td height="40">
						<label id="pw2msg" for="password2">
							<?php echo JText::_( 'VERIFY_PASSWORD' ); ?>:
						</label>
					</td>
					<td>
						<input class="inputbox required validate-passverify" type="password" id="password2" name="password2" size="40" value="" /> *
					</td>
				</tr>
				<tr>
					<td colspan="2" height="40">
						<p class="information_td"><?php echo JText::_( 'REGISTER_REQUIRED' ); ?></p>
					</td>
				</tr>
				</table>
					<button class="button validate" type="submit"><?php echo JText::_('REGISTER'); ?></button>
					<input type="hidden" name="task" value="register_save" />
					<input type="hidden" name="id" value="0" />
					<input type="hidden" name="gid" value="0" />
					<?php echo JHTML::_( 'form.token' ); ?>
				</form>