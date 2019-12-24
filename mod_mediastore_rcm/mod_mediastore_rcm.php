<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

JHtml::_('stylesheet', 'mod_mediastore_rcm/owl.carousel.min.css', array(), true);
JFactory::getDocument()->addScript('media/mod_mediastore_rcm/js/owl.carousel.min.js');
JFactory::getDocument()->addScript('media/mod_mediastore_rcm/js/scripts.js');
// include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$items		= modMediaStoreRcmHelper::getList($params);
$count		= count($items);
$class_sfx	= htmlspecialchars($params->get('class_sfx'));
$layout		= $params->get('layout', 'default');
$mini		= (bool) $params->get('view_layout');
$info		= trim($params->get('info'));
$currentItemId = JFactory::getApplication()->input->getInt('id');
$currentItemView = JFactory::getApplication()->input->getVar('view');
if(!$currentItemId || $currentItemView != "product") return false;
require(JModuleHelper::getLayoutPath('mod_mediastore_rcm', $layout));