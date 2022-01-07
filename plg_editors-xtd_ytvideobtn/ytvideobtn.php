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
use Joomla\CMS\Version;

class PlgEditorsXtdYtvideobtn extends CMSPlugin
{
    protected $autoloadLanguage = true;

    public function onDisplay($name, $asset, $author)
    {
        $layout = Path::clean(PluginHelper::getLayoutPath('editors-xtd', 'ytvideobtn'));
        $layout = str_replace('.php',  '_j' . Version::MAJOR_VERSION . '.php', $layout);
        if (file_exists($layout)) {
            include $layout;
            Factory::getDocument()->addStyleDeclaration('#ytvideo-modal{top:50%;left:50%;width:600px;max-width:98%;margin-left:0;transform:translate(-50%,-50%);}#ytvideo-modal .modal-body{box-sizing:border-box;padding:15px 30px 15px 15px;}');

            $button = new CMSObject;
            $button->modal   = false;
            $button->class   = 'btn btn-danger';
            $button->link    = '#';
            $button->text    = Text::_('YouTube video');
            $button->name    = 'youtube';
            $button->icon    = 'youtube';
            $button->iconSVG = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 48" width="32" height="17"><path d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z" fill="#f00"></path><path d="M 45,24 27,14 27,34" fill="#fff"></path></svg>';
            $button->onclick = 'insertYtvideo(\'' . $name . '\');return false;';

            return $button;
        } else return;
    }
}
