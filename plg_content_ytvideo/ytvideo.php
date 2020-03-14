<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\FileSystem\Path;

class plgContentYtvideo extends CMSPlugin
{

    public function onContentPrepare($context, &$article, &$params, $page = 0)
    {
        if ($context == 'com_finder.indexer') {
            return false;
        }

        $isWebP = $this->isWebP();

        if ($this->params->get('oldframes') == '1') {
            $matches = [];
            preg_match_all('|<iframe.+?src="h?t?t?p?s?:?//w?w?w?.?youtu.?be(?:-nocookie)?.?c?o?m?/embed/([a-zA-Z0-9_-]{11}).+?"[^>]+?></iframe>|i', $article->text, $matches);
            if (count($matches[0])) {
                foreach ($matches[0] as $key => $res) {
                    $article->text = str_replace($res, '<div>{ytvideo https://youtube.com/watch?v=' . $matches[1][$key] . '|}</div>', $article->text);
                }
            }
            unset($matches);
        }
        
        if ($this->params->get('oldlinks') == '1') {
            $matches = [];
            $title = '';
            preg_match_all('|<a.+?href="h?t?t?p?s?:?//w?w?w?.?youtu.?be(?:-nocookie)?.?c?o?m?/(?:watch\?v=)?([a-zA-Z0-9_-]{11})(?:.+)?"+?>(.+?)</a>|i', $article->text, $matches);
            if (count($matches[0])) {
                foreach ($matches[0] as $key => $res) {
                    $title = mb_strpos($matches[2][$key], '://') === false ? strip_tags($matches[2][$key]) : '';
                    $article->text = str_replace($res, '<div>{ytvideo https://youtube.com/watch?v=' . $matches[1][$key] . ($title ? '|' . $title : '') . '}</div>', $article->text);
                }
            }
            unset($matches, $title);
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

        $cachFolder = Path::clean(Factory::getConfig()->get('cache_path', JPATH_CACHE));
        $cachFolder = $cachFolder . DIRECTORY_SEPARATOR . 'plg_content_ytvideo' . DIRECTORY_SEPARATOR;
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
                    $ratio = $r_tmp;
                    unset($tmp[1]);
                }
            }

            $title = '';
            if (count($tmp)) {
                $title = trim(strip_tags(implode(' ', $tmp)));
            }

            $match = [];
            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match);

            $images = ['maxresdefault', 'hq720', 'sddefault', 'hqdefault', 'mqdefault', 'default'];

            if (count($match) > 1) {
                $resultImage = false;
                $id = $match[1];
                $cachedImage = $cachFolder . $id . ($isWebP ? '.webp' : '.jpg');

                if (!file_exists($cachedImage)) {
                    foreach ($images as $img) {
                        $image = 'https://i.ytimg.com/vi' . ($isWebP ? '_webp/' : '/') . $id . '/' . $img . ($isWebP ? '.webp' : '.jpg');
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
                        $image = '/' . $this->params->get('emptyimg', 'plugins/content/ytvideo/assets/empty' . ($isWebP ? '.webp' : '.png'));
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

    private function isWebP() {
        $agent = $_SERVER['HTTP_USER_AGENT'];
    
        preg_match('/(Android)(?:\'&#x20;| )([0-9.]+)/', $agent, $Android);
        preg_match('/(Version)(?:\/| )([0-9.]+)/', $agent, $Safari);
        preg_match('/(OPR)(?:\/| )([0-9.]+)/', $agent, $Opera);
        preg_match('/(Edge)(?:\/| )([0-9.]+)/', $agent, $Edge);
        preg_match('/(Trident)(?:\/| )([0-9.]+)/', $agent, $IE);
        preg_match('/(rv)(?:\:| )([0-9.]+)/', $agent, $rv);
        preg_match('/(MSIE|Opera|Firefox|Chrome|Chromium|YandexSearch|YaBrowser)(?:\/| )([0-9.]+)/', $agent, $bi);
    
        $isAndroid = isset($Android[1]);
        $isWin10 = strpos($agent, 'Windows NT 10.0') !== false;
        
        if ($Safari && !$isAndroid) {
            $name = 'Safari';
            $ver = (int)$Safari[2];
        } elseif ($Opera) {
            $name = 'Opera';
            $ver = (int)$Opera[2];
        } elseif ($Edge) {
            $name = 'Edge';
            $ver = (int)$Edge[2];
        } elseif ($IE) {
            $name = 'IE';
            $ver = isset($rv[2]) ? (int)$rv[2] : ($isWin10 ? 11 : (int)$IE[2]);
        } else {
            $name = isset($bi[1]) ? $bi[1] : ($isAndroid ? 'Android' : 'Unknown');
            $ver = isset($bi[2]) ? (int)$bi[2] :  ($isAndroid ? (float)$Android[2] : 0);
        }
        
        $browsers = [
            'Chrome' => 32,
            'Firefox' => 65,
            'Opera' => 19,
            'Edge' => 18,
            'YaBrowser' => 1,
            'YandexSearch' => 1,
            'Android' => 4.2
        ];
        
        return in_array($name, array_keys($browsers)) && ($ver >= $browsers[$name]);
    }
}
