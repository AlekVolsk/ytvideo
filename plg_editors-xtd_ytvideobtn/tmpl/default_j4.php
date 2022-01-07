<?php defined('_JEXEC') or die;
/*
 * @package     Joomla.Plugin
 * @subpackage  Editors-xtd.ytvideo
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

use Joomla\CMS\Language\Text;

?>

<div id="ytvideo-modal" class="joomla-modal modal fade" role="dialog" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_TITLE'); ?></h3>
                <button type="button" class="btn-close novalidate" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-vertical">
                    <div class="control-group">
                        <div class="control-label">
                            <label for="ytvideo_url"><?php echo Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_URL'); ?></label>
                        </div>
                        <div class="controls">
                            <input name="ytvideourl" id="ytvideo_url" value="" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label for="ytvideo_ratio"><?php echo Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_RATIO'); ?></label>
                        </div>
                        <div class="controls">
                            <select name="ytvideoratio" id="ytvideo_ratio" class="form-control">
                                <option value="4-3">4:3 (TV)</option>
                                <option value="5-3">5:3 (Wide TV)</option>
                                <option value="16-9" selected>16:9 (Standard YouTube, HD)</option>
                                <option value="167-9">16.7:9 (Standard films)</option>
                                <option value="18-9">18:9 (iPhone)</option>
                                <option value="199-9">19.9:9 (Wide 70mm)</option>
                                <option value="235-1">2.35:1 (Panavision)</option>
                                <option value="255-1">2.55:1 (Cinemascope)</option>
                                <option value="27-1">2.7:1 (Ultra Panavision, 2K/4K)</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control-label">
                            <label for="ytvideo_title"><?php echo Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_LABEL_TITLE'); ?></label>
                        </div>
                        <div class="controls">
                            <input name="ytvideotitle" id="ytvideo_title" value="" class="form-control" type="text">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="ytvideo_ins"><?php echo Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_BTN_INSERT'); ?></button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo Text::_('PLG_EDITORS-XTD_YTVIDEOBTN_MODAL_BTN_CANCEL'); ?></button>
            </div>
        </div>
    </div>
</div>

<script>
(() => {

function urlcheckYtvideo(url) {
    let u= /http(s?):\/\/[-\w\.]{3,}\.[A-Za-z]{2,3}/;
    return u.test( url );
}

window.insertYtvideo = function(editor)
{
    let ytvideoModal = new bootstrap.Modal(document.getElementById('ytvideo-modal'), {});
    ytvideoModal.show();

    document.getElementById('ytvideo_ins').addEventListener('click', function() {
        let url = document.getElementById('ytvideo_url').value.trim();
        let ratio = document.getElementById('ytvideo_ratio').value;
        let title = document.getElementById('ytvideo_title').value.trim();
        if (url != '' && urlcheckYtvideo( url ) != false)
        {
            if (title != '') {
                title = '|' + title;
            }
            Joomla.editors.instances[editor].replaceSelection('{ytvideo ' + url + '|' + ratio + title + '}');
        }
        document.getElementById('ytvideo_url').value = '';
        document.getElementById('ytvideo_title').value = '';
        ytvideoModal.hide();
        return true;
    });
};

})();
</script>

<style>
.modal {display: none}
</style>
