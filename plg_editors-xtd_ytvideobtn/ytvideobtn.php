<?php
 /*
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.ytvideobtn
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Object\CMSObject;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

class PlgEditorsXtdYtvideobtn extends CMSPlugin
{
    protected $autoloadLanguage = true;

    public function onDisplay($name, $asset, $author)
    {
        $modal_title = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_TITLE');
        $modal_brn_insert = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_BTN_INSERT');
        $modal_btn_cancel = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_BTN_CANCEL');
        $modal_label_url = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_URL');
        $modal_label_ratio = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_RATIO');
        $modal_label_title = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_TITLE');

        $html = <<<HTML
<div id="ytvideo-modal" class="modal hide fade" role="dialog" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>$modal_title</h3>
      </div>
    <div class="modal-body">
        <div class="form-vertical">
            <div class="control-group">
                <div class="control-label">
                    <label for="ytvideo-url">$modal_label_url</label>
                </div>
                <div class="controls">
                    <input name="ytvideourl" id="ytvideo-url" value="" class="span12" type="text">
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label for="ytvideo-ratio">$modal_label_ratio</label>
                </div>
                <div class="controls">
                    <select name="ytvideoratio" id="ytvideo-ratio" class="span12">
                        <option value="4-3">4:3</option>
                        <option value="16-9" selected>16:9</option>
                        <option value="16-10">16:10</option>
                        <option value="18-9">18:9</option>
                    </select>
                </div>
            </div>
            <div class="control-group">
                <div class="control-label">
                    <label for="ytvideo-title">$modal_label_title</label>
                </div>
                <div class="controls">
                    <input name="ytvideotitle" id="ytvideo-title" value="" class="span12" type="text">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">$modal_brn_insert</button>
        <button class="btn" data-dismiss="modal" aria-hidden="true">$modal_btn_cancel</button>
    </div>
</div>
<style>
#ytvideo-modal
{
    top: 50%;
    left: 50%;
    width: 600px;
    max-width: 98%;
    margin-left: 0;
    transform: translate(-50%,-50%);
}
#ytvideo-modal .modal-body
{
    box-sizing: border-box;
    padding: 15px 30px 15px 15px;
}
</style>
HTML;
        $html = trim(str_replace("\n", '', $html));

        $js = <<<JS
jQuery(document).ready(function()
{
	jQuery('body').append('$html');
});
function urlcheckYtvideo(url)
{
	var u= /http(s?):\/\/[-\w\.]{3,}\.[A-Za-z]{2,3}/;
	return u.test( url );
}
window.insertYtvideo = function(editor)
{
	jQuery('#ytvideo-modal').modal('show');
	jQuery('#ytvideo-modal .btn-primary').click( function()
	{
		var url = jQuery('#ytvideo-url').val().trim();
		var ratio = jQuery('#ytvideo-ratio option:selected').text();
		var title = jQuery('#ytvideo-title').val().trim();
		if (url != '' && urlcheckYtvideo( url ) != false)
		{
			if (title != '') {
				title = '|' + title;
			}
			window.jInsertEditorText('{ytvideo ' + url + '|' + ratio + title + '}', editor);
		}
		jQuery('#ytvideo-url').val('' );
		jQuery('#ytvideo-title').val('');
		jQuery('#ytvideo-modal').modal('hide');
	});
};
JS;
        HTMLHelper::_('jquery.framework', false, null, false);
        Factory::getDocument()->addScriptDeclaration($js);

        $button = new CMSObject;
        $button->modal   = false;
        $button->class   = 'btn btn-danger';
        $button->link    = '#';
        $button->text    = Text::_('YouTube video');
        $button->name    = 'youtube';
        $button->onclick = 'insertYtvideo(\'' . $name . '\');return false;';

        return $button;
    }
}
