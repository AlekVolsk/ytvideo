<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.ytvideo
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;

class plgEditorsXtdYtvideobtnInstallerScript
{
    function postflight($type, $parent)
    {
        $db = Factory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->update('#__extensions')
            ->set('enabled=1')
            ->where('type=' . $db->quote('plugin'))
            ->where('element=' . $db->quote('ytvideobtn'));
        $db->setQuery($query)->execute();
    }
}
