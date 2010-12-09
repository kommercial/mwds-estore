<?php
/**
 * @version		$Id: admin.templates.php 6138 2007-01-02 03:44:18Z eddiea $
 * @package		Joomla
 * @subpackage	Templates
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant to the
 * GNU General Public License, and as distributed it includes or is derivative
 * of works licensed under the GNU General Public License or other free or open
 * source software licenses. See COPYRIGHT.php for copyright notices and
 * details.
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

/*
 * Make sure the user is authorized to view this page
 */
$user = & JFactory::getUser();
if (!$user->authorize('com_templates', 'manage')) {
	$mainframe->redirect('index.php', JText::_('ALERTNOTAUTH'));
}

// Set the table directory
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_templates'.DS.'tables');

// Import file dependencies
require_once (JPATH_COMPONENT.DS.'helpers'.DS.'template.php');
require_once (JPATH_COMPONENT.DS.'controller.php');

$task = JRequest::getVar('task');
switch ($task)
{
	case 'edit' :
		TemplatesController::editTemplate();
		break;

	case 'save'  :
	case 'apply' :
		TemplatesController::saveTemplate();
		break;

	case 'edit_source' :
		TemplatesController::editTemplateSource();
		break;

	case 'save_source'  :
	case 'apply_source' :
		TemplatesController::saveTemplateSource();
		break;

	case 'choose_css' :
		TemplatesController::chooseTemplateCSS();
		break;

	case 'edit_css' :
		TemplatesController::editTemplateCSS();
		break;

	case 'save_css'  :
	case 'apply_css' :
		TemplatesController::saveTemplateCSS();
		break;

	case 'publish' :
	case 'default' :
		TemplatesController::publishTemplate();
		break;

	case 'cancel' :
		TemplatesController::cancelTemplate();
		break;

	case 'positions' :
		TemplatesController::editPositions();
		break;

	case 'save_positions' :
		TemplatesController::savePositions();
		break;

	case 'preview' :
		TemplatesController::previewTemplate();
		break;

	default :
		TemplatesController::viewTemplates();
		break;
}

?>