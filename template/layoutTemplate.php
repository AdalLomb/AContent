<?php
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

include(TR_INCLUDE_PATH.'header.inc.php');
?>
 <div class="input-form" style="width: 95%;"> 
     <?php echo "Layout Template";?>
 </div>

<?php

include(TR_INCLUDE_PATH.'footer.inc.php'); 
?>