<?php
/* * ********************************************************************* */
/* AContent                                                             */
/* * ********************************************************************* */
/* Copyright (c) 2010                                                   */
/* Inclusive Design Institute                                           */
/*                                                                      */
/* This program is free software. You can redistribute it and/or        */
/* modify it under the terms of the GNU General Public License          */
/* as published by the Free Software Foundation.                        */
/* * ********************************************************************* */



define('TR_INCLUDE_PATH', '../include/');

include_once(TR_INCLUDE_PATH . 'vitals.inc.php');
include_once(TR_INCLUDE_PATH . 'classes/DAO/DAO.class.php');
include_once(TR_INCLUDE_PATH . 'classes/DAO/LanguagesDAO.class.php');
include_once(TR_INCLUDE_PATH . 'classes/DAO/LanguageTextDAO.class.php');
require_once(TR_INCLUDE_PATH . '/../home/classes/StructureManager.class.php');

include(TR_INCLUDE_PATH . 'header.inc.php');

if (!defined('TR_INCLUDE_PATH')) {
    exit;
}
if (!defined('TR_BASE_HREF')) {
    exit;
}



global $_course_id;
$contentDAO = new ContentDAO();

$mod_path = array();
$mod_path['templates'] = realpath(TR_BASE_HREF . 'templates') . '/';
$mod_path['templates_int'] = realpath(TR_INCLUDE_PATH . '../templates') . '/';
$mod_path['templates_sys'] = $mod_path['templates_int'] . 'system/';
$mod_path['structs_dir'] = $mod_path['templates'] . 'structures/';
$mod_path['structs_dir_int'] = $mod_path['templates_int'] . 'structures/';

include_once($mod_path['templates_sys'] . 'Structures.class.php');

$structs = new Structures($mod_path);

$structsList = $structs->getStructsList();

$output = '';

if (!is_array($structsList) || count($structsList) == 0) {
    $msg->addWarning('NO_STRUCT');
    $msg->printWarnings();
} else {

    $check = false;
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>Structure Template</title>
        </head>
        <body>
            <div class="input-form" style="width: 95%;"> 
                <div style=" weight: 10%; margin: 10px;">
                    <!--  &nbsp; 
                  <!--   <table class="form-data" style="width: 95%;"> 
                          <tr>
                              <td width="55%">    -->                
                    <div style=" weight: 10%; margin: 10px;">
                        <p style="font-style:italic;"><label for="structures_available"><?php echo _AT('structures_available'); ?></label></p>

                        &nbsp;
                        <?php
                        $value = "";
                        foreach ($structsList as $val) {
                            if (isset($_POST['struct']) && $_POST['struct'] == $val['short_name'])
                                $check = true;
                            else
                                $check = false;
                            ?>


                            <div style=" margin-bottom: 10px; <?php if ($check) echo 'border: 2px #cccccc dotted;'; ?> ">

                                <ul>
                                    <input name="type_strucuture" type="radio" id="<?php echo $val['short_name']; ?>"/> <?php echo $val['name']; ?>

                                    <p style="margin-left: 10px; font-size:90%;"><span style="font-style:italic;"><?php echo _AT('description'); ?>:</span>
                                        <?php echo $val['description']; ?></p>


                                    <div style="font-size:95%; margin-left: 10px;">

                                        <a title="outline_collapsed" id="a_outline_<?php echo $val['short_name']; ?>" onclick="javascript: trans.utility.toggleOutline('<?php echo $val['short_name']; ?>', 'Hide outline', 'Show outline'); " href="javascript:void(0)">Show outline</a>
                                        <div style="display: none;" id="div_outline_<?php echo $val['short_name']; ?>">
                                            <?php
                                            $struc_manag = new StructureManager($val['short_name']);
                                            $struc_manag->printPreview(false, $val['short_name']);
                                            ?>
                                        </div>
                                    </div>  
                                </ul>
                            </div>
                        <?php } ?>
                        <!--   </td>
                           <td>
                               <div  class="input-form" style="width: 95%;">  
                                   <table  class="form-data" align="center"> 
                                       <tfoot>
                                           <tr>
                                               <td colspan="8" align="right">
                                                   <input type="submit" name="modify" value="<?php // echo _AT('modify');  ?>" class="submit" />
                                                   <input type="submit" name="cancel" value="<?php // echo _AT('cancel');  ?>" class="submit" />
                                               </td> 
                                           </tr>
                                       </tfoot>
                                       <tr><td><label for="title"><?php //echo _AT('title');  ?></label></td></tr>
                                       <tr><td><input id="title" name="title" type="text" maxlength="255" size="45" /> </td></tr>                   
                                       <tr><td><label for="description"><?php //echo _AT('description');  ?></label></td></tr>
                                       <tr><td><input id="description" name="description" type="text" maxlength="255" size="45" /></td></tr> 
                                       <tr><td><label for="outline"><?php //echo _AT('outline');  ?></label></td></tr>
                                       <tr><td><textarea id="outline" cols="15" rows="8" name="outline"></textarea></td></tr>
                                  <!--    <tr><td>&nbsp;</td></tr> 
                                   </table> 
                               </div> 
                           </td>
                       </tr>  
                   </table>-->
                    </div>
                    <input type="hidden" name="struct" />
                    &nbsp;
                    <?php
                }
                $current_tab = "Structure Template";
                ?>
                <!--    <hr size="00.1"> --> 



         <!--   <fieldset class="group_form"><legend class="group_form"><?php echo _AT('course_property'); ?></legend>

                <table class="form-data" align="center">
                    <tr><td colspan="2" align="left">
                <!-- <label> <b>Create New Structure</b></label> -->
                <div>
                    <?php echo _AT('create_structure'); ?>
                    <a href="template/NewStructureTemplate.php"><?php echo htmlentities_utf8(_AT('structure_wizard')); ?></a><br /><br />
                </div>
                <!-- </td>
             </tr>

             <tr>
                 <td colspan="2" align="left"><br/><?php //echo _AT('required_field_text');  ?></td>
             </tr>

             <tr>
                 <td align="left"><span class="required" title="<?php // echo _AT('required_field');  ?>">*</span>
                     <label for="title"><?php // echo _AT('title');  ?></label>:</td>
                 <td align="left"><input id="title" name="title" type="text" maxlength="255" size="45" /> </td>
             </tr>
             
             <tr>
                 <td align="left"><label for="description"><?php //echo _AT('description');  ?></label></td>
                 <td align="left"><textarea id="description" cols="45" rows="2" name="description"></textarea></td>
             </tr>

             <tr>
                 <td colspan="2">

                     <p class="submit_button">
                         <input type="submit" name="submit" value="<?php // echo _AT('save');  ?>" class="submit" />
                         <input type="submit" name="cancel" value="<?php // echo _AT('cancel');  ?>" class="submit" />

                     </p>
                 </td>
             </tr>
         </table> 
     </fieldset> -->
            </div>
            <!-- funzione per creare una nuova pagina senza dichiararla-->
            <form enctype="multipart/form-data" name="form" method="post" action="<?php echo TR_BASE_HREF . 'template/strcutureTemplate.php'; ?>">
                <input type="hidden" name="current_tab" value="<?php echo $current_tab; ?>" />
                <div align="center">
                    <?php output_tabs($current_tab); ?>
                </div>
                <div class="input-form" style="width: 95%;">
                    <?php include('NewStructureTemplate.php'); ?>
                </div>

            </form>
    </body>
</html>


<?php
// footer
include(TR_INCLUDE_PATH . 'footer.inc.php');
?>

