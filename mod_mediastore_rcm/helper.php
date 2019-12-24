<?php
/**
 * @copyright	Copyright (c) 2013 Skyline Technology Ltd (http://extstore.com). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_ROOT . '/administrator/components/com_mediastore/helpers/html');
JModelLegacy::addIncludePath(JPATH_ROOT . '/components/com_mediastore/models');
JTable::addIncludePath(JPATH_ROOT . '/administrator/components/com_mediastore/tables');
require_once JPATH_ROOT . '/administrator/components/com_mediastore/helpers/mediastore.php';
require_once JPATH_ROOT . '/administrator/components/com_mediastore/helpers/factory.php';
require_once JPATH_ROOT . '/components/com_mediastore/helpers/route.php';

/**
 * MediaStore Cart Helper Class.
 *
 * @package		Joomla.Site
 * @subpakage	Skyline.MediaStoreCart
 */
class modMediaStoreRcmHelper {
	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	public static function getList() {
		// Create a new query object.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$user	= JFactory::getUser();
		// Select the required fields from the table.
		$query->select(
				'a.*, c.id as category_id'
		);
		$query->select('CASE WHEN CHAR_LENGTH(a.alias) THEN CONCAT_WS(\':\', a.id, a.alias) ELSE a.id END AS slug');
		$query->from('#__mediastore_products AS a');

		// Join over the language.
		$query->select('l.title AS language_title');
		$query->join('LEFT', '#__languages AS l ON l.lang_code = a.language');

		// Join over the users for the checked out user.
		$query->select('uc.name AS editor');
		$query->join('LEFT', '#__users AS uc ON uc.id = a.checked_out');

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');

		// Join over the Categories.
		$query->select('GROUP_CONCAT(DISTINCT cc.title ORDER BY cc.title SEPARATOR \', \') AS category_title');
		$query->join('LEFT', '#__mediastore_productcat_map AS pcc ON pcc.product_id = a.id');
		$query->join('LEFT', '#__categories AS cc ON cc.id = pcc.cat_id');
		$query->group('a.id');

		$query->join('LEFT', '#__mediastore_productcat_map AS pc ON pc.product_id = a.id');
		$query->join('LEFT', '#__categories AS c ON c.id = pc.cat_id');

		// Join over the users for the author.
		$query->select('ua.name AS author_name');
		$query->join('LEFT', '#__users AS ua ON ua.id = a.created_by');
		$db->setQuery($query);

		return $db->loadObjectList();
	}
}