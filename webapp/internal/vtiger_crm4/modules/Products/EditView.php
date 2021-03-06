<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('include/database/PearDatabase.php');
require_once('XTemplate/xtpl.php');
require_once('include/uifromdbutil.php');
require_once('modules/Products/Product.php');
require_once('include/FormValidationUtil.php');

global $app_strings;
global $app_list_strings;
global $mod_strings;
global $current_user;

$focus = new Product();

if(isset($_REQUEST['record'])) 
{
    $focus->id = $_REQUEST['record'];
    $focus->mode = 'edit'; 	
    $focus->retrieve_entity_info($_REQUEST['record'],"Products");
    $focus->name=$focus->column_fields['description'];		
}
if(isset($_REQUEST['vendorid']) && $_REQUEST['vendorid']!='')
{
        $focus->column_fields['vendorid'] = $_REQUEST['vendorid'];
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
    	$focus->mode = ''; 	
} 

//get Block 1 Information

$block_1 = getBlockInformation("Products",1,$focus->mode,$focus->column_fields);



//get Address Information

$block_2 = getBlockInformation("Products",2,$focus->mode,$focus->column_fields);
$block_3 = getBlockInformation("Products",3,$focus->mode,$focus->column_fields);
$block_4 = getBlockInformation("Products",4,$focus->mode,$focus->column_fields);
$block_6 = getBlockInformation("Products",6,$focus->mode,$focus->column_fields);

//get Custom Field Information
$block_5 = getBlockInformation("Products",5,$focus->mode,$focus->column_fields);
if(trim($block_5) != '')
{
        $cust_fld = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="formOuterBorder">';
        $cust_fld .=  '<tr><td>';
	$block_5_header = getBlockTableHeader("LBL_CUSTOM_INFORMATION");
        $cust_fld .= $block_5_header;
        $cust_fld .= '<table width="100%" border="0" cellspacing="1" cellpadding="0">';
        $cust_fld .= $block_5;
        $cust_fld .= '</table>';
        $cust_fld .= '</td></tr></table>';
        $cust_fld .='<BR>';
}

//needed when creating a new product with a default vendor name to passed 
if (isset($_REQUEST['name']) && is_null($focus->name)) {
	$focus->name = $_REQUEST['name'];
	
}
if (isset($_REQUEST['vendorid']) && is_null($focus->vendorid)) {
	$focus->vendorid = $_REQUEST['vendorid'];
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$xtpl=new XTemplate ('modules/Products/EditView.html');
$xtpl->assign("MOD", $mod_strings);
$xtpl->assign("APP", $app_strings);
$xtpl->assign("BLOCK1", $block_1);
$xtpl->assign("BLOCK2", $block_2);
$xtpl->assign("BLOCK3", $block_3);
$xtpl->assign("BLOCK4", $block_4);
$xtpl->assign("BLOCK6", $block_6);
$block_1_header = getBlockTableHeader("LBL_PRODUCT_INFORMATION");
$block_2_header = getBlockTableHeader("LBL_PRICING_INFORMATION");
$block_3_header = getBlockTableHeader("LBL_STOCK_INFORMATION");
$block_4_header = getBlockTableHeader("LBL_DESCRIPTION_INFORMATION");
$block_6_header = getBlockTableHeader("LBL_IMAGE_INFORMATION");
$xtpl->assign("BLOCK1_HEADER", $block_1_header);
$xtpl->assign("BLOCK2_HEADER", $block_2_header);
$xtpl->assign("BLOCK3_HEADER", $block_3_header);
$xtpl->assign("BLOCK4_HEADER", $block_4_header);
$xtpl->assign("BLOCK6_HEADER", $block_6_header);

if (isset($focus->name)) $xtpl->assign("NAME", $focus->name);
else $xtpl->assign("NAME", "");

if(isset($cust_fld))
{
        $xtpl->assign("CUSTOMFIELD", $cust_fld);
}
$xtpl->assign("ID", $focus->id);

$xtpl->assign("CALENDAR_LANG", "en");$xtpl->assign("CALENDAR_DATEFORMAT", parse_calendardate($app_strings['NTC_DATE_FORMAT']));
if($focus->mode == 'edit')
{
        $xtpl->assign("MODE", $focus->mode);
}

if(isset($_REQUEST['return_module'])) $xtpl->assign("RETURN_MODULE", $_REQUEST['return_module']);
if(isset($_REQUEST['return_action'])) $xtpl->assign("RETURN_ACTION", $_REQUEST['return_action']);
if(isset($_REQUEST['return_id'])) $xtpl->assign("RETURN_ID", $_REQUEST['return_id']);
if(isset($_REQUEST['activity_mode'])) $xtpl->assign("ACTIVITYMODE", $_REQUEST['activity_mode']);
$xtpl->assign("THEME", $theme);
$xtpl->assign("IMAGE_PATH", $image_path);$xtpl->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);




$product_tables = Array('products','productcf','productcollaterals'); 

 $validationData = getDBValidationData($product_tables);
 $fieldName = '';
 $fieldLabel = '';
 $fldDataType = '';

 $rows = count($validationData);
 foreach($validationData as $fldName => $fldLabel_array)
 {
   if($fieldName == '')
   {
     $fieldName="'".$fldName."'";
   }
   else
   {
     $fieldName .= ",'".$fldName ."'";
   }
   foreach($fldLabel_array as $fldLabel => $datatype)
   {
	if($fieldLabel == '')
	{
			
     		$fieldLabel = "'".$fldLabel ."'";
	}		
      else
       {
      $fieldLabel .= ",'".$fldLabel ."'";
        }
 	if($fldDataType == '')
         {
      		$fldDataType = "'".$datatype ."'";
    	}
	 else
        {
       		$fldDataType .= ",'".$datatype ."'";
     	}
   }
 }



$xtpl->assign("VALIDATION_DATA_FIELDNAME",$fieldName);
$xtpl->assign("VALIDATION_DATA_FIELDDATATYPE",$fldDataType);
$xtpl->assign("VALIDATION_DATA_FIELDLABEL",$fieldLabel);






$xtpl->parse("main");

$xtpl->out("main");

?>
