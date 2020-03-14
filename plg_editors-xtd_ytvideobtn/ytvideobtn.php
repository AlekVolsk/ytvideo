<?php
/*
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.ytvideobtn
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\Path;

class PlgEditorsXtdYtvideobtn extends CMSPlugin
{
    protected $autoloadLanguage = true;

    public function onDisplay($name, $asset, $author)
    {
        $layout = Path::clean(PluginHelper::getLayoutPath('editors-xtd', 'ytvideobtn'));
        if (file_exists($layout)) {
            include $layout;
            Factory::getDocument()->addStyleDeclaration('#ytvideo-modal{top:50%;left:50%;width:600px;max-width:98%;margin-left:0;transform:translate(-50%,-50%);}#ytvideo-modal .modal-body{box-sizing:border-box;padding:15px 30px 15px 15px;}');

            $button = new CMSObject;
            $button->modal   = false;
            $button->class   = 'btn btn-danger';
            $button->link    = '#';
            $button->text    = Text::_('YouTube video');
            $button->name    = 'youtube';
            $button->onclick = 'insertYtvideo(\'' . $name . '\');return false;';

            return $button;
        } else return;
    }
}
