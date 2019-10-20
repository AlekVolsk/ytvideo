<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

HTMLHelper::_('jquery.framework', false, null, false);

$modal_title = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_TITLE');
$modal_brn_insert = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_BTN_INSERT');
$modal_btn_cancel = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_BTN_CANCEL');
$modal_label_url = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_URL');
$modal_label_ratio = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_RATIO');
$modal_label_title = Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_TITLE');

/* The script is attached to the id of the elements, be careful when making changes to the markup. */

?>
<script>
$html = '\
<div id="ytvideo-modal" class="modal hide fade" role="dialog" aria-hidden="true">\
    <div class="modal-header">\
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>\
        <h3><?php echo $modal_title; ?></h3>\
      </div>\
    <div class="modal-body">\
        <div class="form-vertical">\
            <div class="control-group">\
                <div class="control-label">\
                    <label for="ytvideo-url"><?php echo $modal_label_url; ?></label>\
                </div>\
                <div class="controls">\
                    <input name="ytvideourl" id="ytvideo-url" value="" class="span12" type="text">\
                </div>\
            </div>\
            <div class="control-group">\
                <div class="control-label">\
                    <label for="ytvideo-ratio"><?php echo $modal_label_ratio; ?></label>\
                </div>\
                <div class="controls">\
                    <select name="ytvideoratio" id="ytvideo-ratio" class="span12">\
                        <option value="4-3">4:3</option>\
                        <option value="16-9" selected>16:9</option>\
                        <option value="16-10">16:10</option>\
                        <option value="18-9">18:9</option>\
                    </select>\
                </div>\
            </div>\
            <div class="control-group">\
                <div class="control-label">\
                    <label for="ytvideo-title"><?php echo $modal_label_title; ?></label>\
                </div>\
                <div class="controls">\
                    <input name="ytvideotitle" id="ytvideo-title" value="" class="span12" type="text">\
                </div>\
            </div>\
        </div>\
    </div>\
    <div class="modal-footer">\
        <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php echo $modal_brn_insert; ?></button>\
        <button class="btn" data-dismiss="modal" aria-hidden="true"><?php echo $modal_btn_cancel; ?></button>\
    </div>\
</div>';

jQuery(document).ready(function() {
	jQuery('body').append($html);
});
function urlcheckYtvideo(url) {
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
</script>
