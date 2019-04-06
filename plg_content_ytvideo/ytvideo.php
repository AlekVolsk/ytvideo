<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\HTML\HTMLHelper;

class plgContentYtvideo extends CMSPlugin
{

    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        if ($context == 'com_finder.indexer') {
            return false;
        }

        $results = [];
        preg_match_all('|{ytvideo\s(.*?)}|U', $article->text, $results);
        foreach ($results as $k => $result) {
            if (!$result) {
                unset($results[$k]);
            }
        }
        if (!$results) {
            return false;
        }
		
        $layout = PluginHelper::getLayoutPath('content', 'ytvideo');
        $format = $this->params->get('format', '16-9');

		HTMLHelper::script('plugins/content/ytvideo/assets/ytvideo.js', [], ['options' => ['version' => 'auto']]);

        if ($this->params->get('includes') == '1') {
            $css = str_replace(JPATH_ROOT, '', dirname($layout) . '/' . basename($layout, '.php') . '.css');
            if (!file_exists(JPATH_ROOT . $css)) {
                $css = 'plugins/content/ytvideo/assets/ytvideo.css';
            }
            $css = str_replace('\\', '/', $css);
			HTMLHelper::stylesheet($css, [], ['options' => ['version' => 'auto']]);
        }

        $lazysizes = $this->params->get('lazysizes') == '1';
        if ($lazysizes) {
            HTMLHelper::script('plugins/content/ytvideo/assets/lazysizes/ls.bgset.min.js', [], ['options' => ['version' => 'auto']]);
            HTMLHelper::script('plugins/content/ytvideo/assets/lazysizes/lazysizes.min.js', [], ['options' => ['version' => 'auto']]);
        }

        foreach ($results[1] as $key => $link) {
            $tmp = explode('|', strip_tags($link));
            
            $link = trim($tmp[0]);
            unset($tmp[0]);
            
            $ratio = $format;
            if (count($tmp) && isset($tmp[1])) {
                $ratio = str_replace([':', ' '], ['-'. ''], preg_replace('/[0-9]-:[0-9]/', '', $tmp[1]));
                if (in_array($ratio, ['18:9', '16:9', '16:10', '4:3', '18-9', '16-9', '16-10', '4-3'])) {
                    unset($tmp[1]);
                }
            }
            
            $title = '';
            if (count($tmp)) {
                $title = trim(implode(' ', $tmp));
            }

            $match = [];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match);

            if (count($match) > 1) {
				$id = $match[1];
                $images = ['maxresdefault.jpg', 'sddefault.jpg', 'hqdefault.jpg', 'mqdefault.jpg', 'default.jpg'];
                foreach ($images as $img) {
                    $image = 'https://i.ytimg.com/vi/' . $id . '/' . $img;
                    if ((bool)@file_get_contents($image) !== false) {
                        break;
                    }
                }

				ob_start();
				include $layout;
				$article->text = str_replace($results[0][$key], ob_get_clean(), $article->text);
			}
        }
    }
}
