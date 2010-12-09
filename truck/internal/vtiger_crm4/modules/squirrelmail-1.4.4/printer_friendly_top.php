<?php

/**
 * printer_friendly top frame
 *
 * top frame of printer_friendly_main.php
 * displays some javascript buttons for printing & closing
 *
 * @copyright (c) 1999-2005 The SquirrelMail Project Team
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id: printer_friendly_top.php,v 1.1 2005/06/14 13:34:58 indigoleopard Exp $
 * @package squirrelmail
 */

/**
 * Path for SquirrelMail required files.
 * @ignore
 */
//define('SM_PATH','../');
define('SM_PATH','modules/squirrelmail-1.4.4/');
/* SquirrelMail required files. */
require_once(SM_PATH . 'include/validate.php');

displayHtmlHeader( _("Printer Friendly"),
             "<script language=\"javascript\" type=\"text/javascript\">\n".
             "<!--\n".
             "function printPopup() {\n".
                "parent.frames[1].focus();\n".
                "parent.frames[1].print();\n".
             "}\n".
             "-->\n".
             "</script>\n", FALSE );


echo '<body text="'.$color[8].'" bgcolor="'.$color[3].'" link="'.$color[7].'" vlink="'.$color[7].'" alink="'.$color[7]."\">\n" .
     html_tag( 'div',
         '<b>'.
         '<form>'.
         '<input type="button" value="' . _("Print") . '" onclick="printPopup()" /> '.
         '<input type="button" value="' . _("Close") . '" onclick="window.parent.close()" />'.
         '</form>'.
         '</b>',
     'right' );
?>
</body></html>
