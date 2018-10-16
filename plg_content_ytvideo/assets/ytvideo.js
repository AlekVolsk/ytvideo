/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) 2017 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */
jQuery(document).ready(function($){$('.ytvideo > .ytvideo-cover').click(function(){$(this).parent().html('<iframe src="https://youtube.com/embed/'+$(this).attr('src')+'?autoplay=1&rel=0" frameborder="0" allowfullscreen></iframe>');});});
