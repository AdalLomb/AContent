<?php
/************************************************************************/
/* AContent                                                             */
/************************************************************************/
/* Copyright (c) 2010                                                   */
/* Inclusive Design Institute                                           */
/*                                                                      */
/* This program is free software. You can redistribute it and/or        */
/* modify it under the terms of the GNU General Public License          */
/* as published by the Free Software Foundation.                        */
/************************************************************************/

define('TR_INCLUDE_PATH', '../include/');

include_once(TR_INCLUDE_PATH.'vitals.inc.php');
include_once(TR_INCLUDE_PATH.'classes/DAO/DAO.class.php');
include_once(TR_INCLUDE_PATH.'classes/DAO/LanguagesDAO.class.php');
include_once(TR_INCLUDE_PATH.'classes/DAO/LanguageTextDAO.class.php');
if (!defined('TR_INCLUDE_PATH')) { exit; }
if (!defined('TR_BASE_HREF')) { exit; }

// definisco aspetto
include(TR_INCLUDE_PATH.'header.inc.php');



//require_once(TR_INCLUDE_PATH.'vitals.inc.php');
//require_once(TR_INCLUDE_PATH.'classes/DAO/ContentDAO.class.php');
//require_once(TR_INCLUDE_PATH.'/../home/classes/StructureManager.class.php');


global $_course_id;
$contentDAO = new ContentDAO();

$mod_path					= array();
$mod_path['dnd_themod']		= realpath(TR_BASE_HREF			. 'dnd_themod').'/';
$mod_path['dnd_themod_int']	= realpath(TR_INCLUDE_PATH		. '../dnd_themod').'/';
$mod_path['dnd_themod_sys']	= $mod_path['dnd_themod_int']	. 'system/';
$mod_path['structs_dir']		= $mod_path['dnd_themod']		. 'structures/';
$mod_path['structs_dir_int']	= $mod_path['dnd_themod_int']	. 'structures/';

include_once($mod_path['dnd_themod_sys'].'Structures.class.php');

$structs	= new Structures($mod_path);

$structsList = $structs->getStructsList();

$output = '';

if (!is_array($structsList) || count($structsList) == 0) {
	$msg->addWarning('NO_STRUCT');
	$msg->printWarnings();
} else {
	
	$check = false;
	 
	
?>
     <!--  &nbsp;--> 

        <!--      	<form enctype="multipart/form-data" name="form" method="post" action="http://localhost/GitHub/ParteCatia/catiaprandi-AContent-300cef1/home/course/course_start.php?_course_id=2">
	  	<input type="hidden" name="current_tab" value="1" /> 
		<div align="center">
		
				<table class="etabbed-table" border="0" cellpadding="0" cellspacing="0" width="95%">
	<tr>		
						<td class="editor_tab">
					

					<input type="submit" name="button_0" value="Manually" title="Manually - alt m" class="editor_buttontab" accesskey="m" onmouseover="this.style.cursor='pointer';"  />				</td>
				<td class="tab-spacer">&nbsp;</td>
									<td class="editor_tab_selected">
					
					Structure				</td>
				<td class="tab-spacer">&nbsp;</td>
									<td class="editor_tab">
					

					<input type="submit" name="button_2" value="Wizard" title="Wizard - alt w" class="editor_buttontab" accesskey="w" onmouseover="this.style.cursor='pointer';"  />				</td>
				<td class="tab-spacer">&nbsp;</td>
							<td >&nbsp;</td>
							
	</tr>
	</table>
	
		</div>-->
	 	<div class="input-form" style="width: 95%;"> 
<!--  -->
<div style=" weight: 10%; margin: 10px;">
<p style="font-style:italic;" >The template structures available are:</p>

<!-- <p >Choose the structure to use as model for your lesson:</p> -->
	
	
	<div style="margin: 10px;">
	<?php 
		$value = "";
		foreach ($structsList as $val) { 
		  	if(isset($_POST['struct']) && $_POST['struct'] == $val['short_name'])
				$check = true;
			else 
				$check = false;
				
	?>
		<script>
		function initContentMenu() {
  			var tree_collapse_icon = "images/tree/tree_collapse.gif";
  			var tree_expand_icon = "images/tree/tree_expand.gif";
			
		};
		</script>
	
		<div style=" margin-bottom: 10px; <?php if($check) echo 'border: 2px #cccccc dotted;';?> ">
		<!--<input  type="checkbox" id="<?php echo $val['short_name'];?>" name="struct" value="<?php echo $val['short_name'];?>" onclick="document.form.submit();" <?php if($check) echo 'checked="checked";'?>/>-->
		
		<ul>
		<li id="<?php echo $val['short_name'];?>"> <?php echo $val['name'];?> </li>

		<!-- <label for="<?php echo $val['short_name'];?>"><?php echo $val['name'];?></label><br />-->
		<p style="margin-left: 10px; font-size:90%;"><span style="font-style:italic;">Description:</span>
					<?php echo $val['description']; ?></p>
		
					
					<div style="font-size:95%; margin-left: 10px;">
					
						<a title="outline_collapsed" id="a_outline_<?php echo $val['short_name'];?>" onclick="javascript: trans.utility.toggleOutline('<?php echo $val['short_name'];?>', 'Hide outline', 'Show outline'); " href="javascript:void(0)">Show outline</a>
						<div style="display: none;" id="div_outline_<?php echo $val['short_name'];?>">
							<?php $struc_manag = new StructureManager($val['short_name']);
							$struc_manag->printPreview(false, $val['short_name']); ?>
			
						</div>
			</ul>
			</div>
			
			
<?php } ?>
</div>
</div>
</div>
<div class="input-form">
	<fieldset class="group_form"><legend class="group_form"><?php echo _AT('create_course'); ?></legend>
	<form name="form1" method="post" action="home/ims/ims_import.php" enctype="multipart/form-data" onsubmit="openWindow('<?php echo TR_BASE_HREF; ?>home/prog.php');">
		<input type="hidden" name="allow_test_import" value="1" />
		<input type="hidden" name="allow_a4a_import" value="1" />
		<table class="form_data">
		<tr><td>
		<?php echo _AT('create_course_1'); ?>
	<!-- 	<a href="home/course/course_property.php"><?php echo htmlentities_utf8(_AT('structure_wizard')); ?></a><br /><br /> -->
		</td></tr>

		<tr><td>
		<?php echo _AT('create_course_2');?>
		</td></tr>
		<tr><td>
			<label for="to_file"><?php echo _AT('upload_content_package'); ?></label>
			<input type="file" name="file" id="to_file" />
		</td></tr>
	
		<tr><td>
			<label for="to_url"><?php echo _AT('specify_url_to_content_package'); ?></label>
			<input type="text" name="url" value="http://" size="40" id="to_url" />
		</td></tr>

		<tr><td>
			<input type="checkbox" name="ignore_validation" id="ignore_validation" value="1" />
			<label for="ignore_validation"><?php echo _AT('ignore_validation'); ?></label> <br />
		</td></tr>
	
		<tr><td>
			<input type="checkbox" name="hide_course" id="hide_course" value="1" /><label for="hide_course"><?php echo _AT('hide_course'); ?></label>
		</td></tr>
	
		<tr align="center"><td>
			<input type="submit" name="submit" value="<?php echo _AT('import'); ?>" />
		</td></tr>
		</table>
	</form>
	</fieldset>
	</div>

<script language="javascript" type="text/javascript">
function openWindow(page) {
	newWindow = window.open(page, "progWin", "width=400,height=200,toolbar=no,location=no");
	newWindow.focus();
}
</script>


</div>

<input type="hidden" name="struct" />
<input type="hidden" name="current_tab" value="1" />

</div>
<!--  input type="submit" class= "submit" name="create_struct" value="Create course with one or more structure" style="margin: 20px; position: relative; left: 65%;"  />
-->

<!-- cambia qui!!! -->
<?php //  echo _AT('create_content_3', TR_BASE_HREF.'home/editor/edit_content_struct.php?_course_id='.$_course_id, "");
} 
//define('TR_INCLUDE_PATH', '../include/');
//require(TR_INCLUDE_PATH.'vitals.inc.php');
//require_once(TR_INCLUDE_PATH.'classes/Utility.class.php');


 


//global $_current_user;

//if (isset($_current_user) && $_current_user->isAuthor())
//{

//}

// definiscono la parte sotto
include(TR_INCLUDE_PATH.'footer.inc.php'); 
?>