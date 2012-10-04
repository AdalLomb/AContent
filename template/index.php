
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


// layout
include(TR_INCLUDE_PATH.'header.inc.php');

if (!defined('TR_INCLUDE_PATH')) { exit; }
if (!defined('TR_BASE_HREF')) { exit; }
require_once(TR_INCLUDE_PATH.'vitals.inc.php');
require_once(TR_INCLUDE_PATH.'classes/DAO/ContentDAO.class.php');
require_once(TR_INCLUDE_PATH.'/../home/classes/StructureManager.class.php');


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

		<div class="input-form" style="width: 95%;">
<!--  -->
<div style=" weight: 10%; margin: 10px;">
<p style="font-style:italic;">The template structures available are:</p>

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

<input type="hidden" name="struct" />
<input type="hidden" name="current_tab" value="1" />

</div>

</div>
<!--  
-->

<!-- cambia qui!!! -->
<?php  //echo _AT('create_content_3', TR_BASE_HREF.'home/editor/edit_content_struct.php?_course_id='.$_course_id, "");
} ?>
<?php 
/*
//Istance DOM class
$dom = new DOMDocument();

//Non calcolare spazi vuoti nel documento
$dom -> preserveWhiteSpace = false;


$dom -> load("C:\Programmi\EasyPHP-5.3.2i\www\AContent\dnd_themod2\structures\competenze-digitali\content.xml")
or die("File XML non valido!");


//Cerca il node radice del codice XML
$root = $dom -> documentElement;

//$rot=dom
if(substr($root -> nodeName, 0, 1) != "#")
{
	echo "<br><br>" . $livel . " node: " . $root -> nodeName;
}
//Cerca fields nel node
$fields = $root -> attributes;

//Elabora fields trovati
foreach($fields as $field)
{
	echo " -- NOME field: " . $field -> name . " - VALORE field: " . $field -> value;
}


//Controllo se il node radice ha children, in caso processo l'albero XML
if($root -> hasChildNodes())
{
	//Funzione per l'elaborazione dell'albero XML (node ROOT, livel 0)
	tree($root, 0);
}

//Funzione tree, come argomenti prevede il puntatore al node da esaminare ed il livel del node
function tree($node, $p)
{
	//Aumento livel, scendi di un node nell'albero
	$p++;

	//Visualizzazione livelli
	$livel = str_repeat("  _  ", $p);

	//Ricava children del node elaborato
	$children = $node -> childNodes;

	//Processa ogni child del node
	foreach($children as $child)
	{

		//Visualizza il nome del node e rimuovi possibili codici superflui
		if(substr($child -> nodeName, 0, 1) != "#")
		{
			echo "<br><br>" . $livel . " node: " . $child -> nodeName;
		}

		//Controlla se il node ha degli fields
		if($child -> hasAttributes())
		{
			//Cerca fields nel node
			$fields = $child -> attributes;

			//Elabora fields trovati
			foreach($fields as $field)
			{
				echo " -- NOME field: " . $field -> name . " - VALORE field: " . $field -> value;
			}
		}


		//Controllo se il node elaborato ha children e ripete iterativamente la funzione su ogni node fino ad arrivare alle foglie dell'albero
		if($child -> hasChildNodes())
		{
			tree($child, $p);
		}
		else
		{
			//Visualizza il valore contenuto nel node
			echo " -- VALORE DEL node: " . $child -> nodeValue;
		}
	}
}
*/
?>
<!--  the page title   
<a name="content" title="Content"></a>
<h2 class="page-title">Template</h2>
<div id="server-msg"></div>

<form>
 	 the main navigation. in our case, tabs 
	the sub navigation  
	<div id="subnavlistcontainer">
		<div id="sub-navigation">
			<ul id="subnavlist">
				<li><a href=".../structureTemplate.php">Structure
						Template</a></li>
				<li><a href="/AContent/template/pageTemplate.php">Page Template</a>
				</li>
				<li><a href="/AContent/template/layoutTemplate.php">Layout Template</a>
				</li>
			</ul>
		</div>
	</div>
</form> 
-->
<?php
// footer
include(TR_INCLUDE_PATH.'footer.inc.php');

?>