<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) 2017 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

class plgContentYtvideo extends JPlugin
{
	
	public function onContentPrepare($context, $article, $params)
	{
		if ($context == 'com_finder.indexer')
		{
			return;
		}
		
		$regex = '|<[^>]+>{ytvideo\s(.*?)}</[^>]+>|U';
		
		preg_match_all($regex, $article->text, $results);
		if (!$results)
		{
			return;
		}


		
		$layout = JPluginHelper::getLayoutPath('content', 'ytvideo');
		
		JHtml::_('jquery.framework', false, null, false);
		$doc = JFactory::getDocument();
		$doc->addScript('/plugins/content/ytvideo/assets/ytvideo.js', 'text/javascript', true);
		
		if ($this->params->get('includes') == '1')
		{
			$css = str_replace(JPATH_ROOT, '', dirname($layout) . '/' . basename($layout, '.php') . '.css');
			if (!file_exists(JPATH_ROOT . $css))
			{
				$css = '/plugins/content/ytvideo/assets/ytvideo.css';
			}
			$css = str_replace('\\', '/', $css);
			$doc->addStyleSheet($css);
		}
		
		foreach ($results[1] as $key => $link)
		{
			$tmp = explode('|', strip_tags($link));
			$link = $tmp[0];
			$title = '';
			if (count($tmp) > 1)
			{
				$title = trim($tmp[1]);
			}
			
			preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $link, $match);
			$id = $match[1];
			$images = [ 'maxresdefault.jpg', 'sddefault.jpg', 'hqdefault.jpg', 'mqdefault.jpg', 'default.jpg' ];
			foreach ($images as $img)
			{
				$image = 'https://i.ytimg.com/vi/' . $id . '/' . $img;
				if (@file_get_contents($image) !== 0)
				{
					break;
				}
			}
			
			ob_start();
			include $layout;
			$article->text = str_replace($results[0][$key], ob_get_clean(), $article->text);
		}
	}
	
}