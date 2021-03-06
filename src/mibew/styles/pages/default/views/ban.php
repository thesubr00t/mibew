<?php
/*
 * Copyright 2005-2013 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

function tpl_content() { global $page, $mibewroot, $errors;
?>

<?php if( $page['saved'] ) { ?>
	<?php echo getlocal2("page_ban.sent",array($page['address'])) ?>

	<script type="text/javascript"><!--
		if(window.opener && window.opener.location) {
			window.opener.location.reload();
		}
		setTimeout( (function() { window.close(); }), 1500 );
	//--></script>
<?php } else { ?>

<?php echo getlocal("page_ban.intro") ?>
<br/>
<br/>
<?php
require_once(dirname(__FILE__).'/inc_errors.php');
?>


<?php if( $page['thread'] ) { ?>
	<?php echo getlocal2("page_ban.thread",array(htmlspecialchars($page['thread']))) ?><br/>
	<br/>
<?php } ?>

<form name="banForm" method="post" action="<?php echo $mibewroot ?>/operator/ban.php">
<?php print_csrf_token_input() ?>
<input type="hidden" name="banId" value="<?php echo $page['banId'] ?>"/>
<?php if( $page['threadid'] ) { ?>
<input type="hidden" name="threadid" value="<?php echo $page['threadid'] ?>"/>
<?php } ?>
	<div class="mform"><div class="formtop"><div class="formtopi"></div></div><div class="forminner">
	
	<div class="fieldForm">
		<div class="field">
			<label for="address" class="flabel"><?php echo getlocal('form.field.address') ?><span class="required">*</span></label>
			<div class="fvalue">
				<input id="address" type="text" name="address" size="40" value="<?php echo form_value('address') ?>" class="formauth"/>
			</div>
			<label for="address" class="fdescr"> &mdash; <?php echo getlocal('form.field.address.description') ?></label>
			<br clear="all"/>
		</div>

		<div class="field">
			<label for="days" class="flabel"><?php echo getlocal('form.field.ban_days') ?><span class="required">*</span></label>
			<div class="fvalue">
				<input id="days" type="text" name="days" size="4" value="<?php echo form_value('days') ?>" class="formauth"/>
			</div>
			<label for="days" class="fdescr"> &mdash; <?php echo getlocal('form.field.ban_days.description') ?></label>
			<br clear="all"/>
		</div>

		<div class="field">
			<label for="comment" class="flabel"><?php echo getlocal('form.field.ban_comment') ?><span class="required">*</span></label>
			<div class="fvalue">
				<input id="comment" type="text" name="comment" size="40" value="<?php echo form_value('comment') ?>" class="formauth"/>
			</div>
			<label for="comment" class="fdescr"> &mdash; <?php echo getlocal('form.field.ban_comment.description') ?></label>
			<br clear="all"/>
		</div>
		
		<div class="fbutton">
			<input type="image" name="save" value="" src='<?php echo $mibewroot.getlocal("image.button.save") ?>' alt='<?php echo getlocal("button.save") ?>'/>
		</div>
	</div>
	
	</div><div class="formbottom"><div class="formbottomi"></div></div></div>
	
	<div class="asterisk">
		<?php echo getlocal("common.asterisk_explanation") ?>
	</div>
	
</form>
<?php } ?>


<?php 
} /* content */

require_once(dirname(__FILE__).'/inc_main.php');
?>