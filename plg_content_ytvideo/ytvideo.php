<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\FileSystem\Path;
//use Joomla\CMS\FileSystem\Folder;

class plgContentYtvideo extends CMSPlugin
{

    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        if ($context == 'com_finder.indexer') {
            return false;
        }

        if ($this->params->get('oldframes') == '1') {
            $matches = [];
            preg_match_all('|<iframe.+?src="h?t?t?p?s?:?//w?w?w?.?youtu.?be.?c?o?m?/embed/([a-zA-Z0-9_-]{11}).+?"[^>]+?></iframe>|i', $article->text, $matches);
            if (count($matches[0])) {
                foreach ($matches[0] as $key => $res) {
                    $article->text = str_replace($res, '<div>{ytvideo https://youtube.com/watch?v=' . $matches[1][$key] . '|}</div>', $article->text);
                }
            }
            unset($matches);
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

        $cachFolder = Path::clean(Factory::getConfig()->get('cache_path', ''));
        $cachFolder = is_dir($cachFolder) ? $cachFolder . DIRECTORY_SEPARATOR . 'plg_content_ytvideo' . DIRECTORY_SEPARATOR : '';
        if ($cachFolder && !is_dir($cachFolder)) {
            JFolder::create($cachFolder, 0755);
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
                $r_tmp = str_replace([':', ' '], ['-' . ''], preg_replace('/[0-9]-:[0-9]/', '', $tmp[1]));
                if (in_array($r_tmp, ['18:9', '16:9', '16:10', '4:3', '18-9', '16-9', '16-10', '4-3'])) {

                    unset($tmp[1]);
                }
            }

            $title = '';
            if (count($tmp)) {
                $title = trim(implode(' ', $tmp));
            }

            $match = [];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match);

            $images = ['maxresdefault.jpg', 'sddefault.jpg', 'hqdefault.jpg', 'mqdefault.jpg', 'default.jpg'];

            if (count($match) > 1) {
                $resultImage = false;
                $id = $match[1];
                $cachedImage = $cachFolder . $id . '.jpg';

                if (!file_exists($cachedImage)) {
                    foreach ($images as $img) {
                        $image = 'https://i.ytimg.com/vi/' . $id . '/' . $img;
                        $buffer = @file_get_contents($image);
                        if ((bool) $buffer !== false) {
                            $resultImage = true;
                            if ($cachFolder) {
                                file_put_contents($cachedImage, $buffer);
                                $image = str_replace('\\', '/', str_replace(Path::clean(JPATH_ROOT), '', $cachedImage));
                            }
                            break;
                        }
                    }
                    if (!$resultImage || !file_exists($cachedImage)) {
                        $image = '/' . $this->params->get('emptyimg', 'plugins/content/ytvideo/assets/empty.png');
                    }
                } else {
                    $image = str_replace('\\', '/', str_replace(Path::clean(JPATH_ROOT), '', $cachedImage));
                }

                ob_start();
                include $layout;
                $article->text = str_replace($results[0][$key], ob_get_clean(), $article->text);
            }
        }
    }
}
