<?php

/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

// phpcs:disable PSR1.Files.SideEffects
\defined('_JEXEC') or die;
// phpcs:enable PSR1.Files.SideEffects

?>
<div class="ytvideo ytvideo-<?php echo $ratio; ?>">
    <a
        class="ytvideo-cover lazyload"
        loading="lazy"
        data-videosrc="<?php echo $id; ?>"
        <?php if ($lazysizes) { ?>
        data-bgset="<?php echo $image; ?>"
        <?php } else { ?>
        style="background-image:url('<?php echo $image; ?>')"
        <?php } ?>
    >
        <?php if ($title) { ?>
        <span class="ytvideo-title"><?php echo $title; ?></span>
        <?php } ?>
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 68 48" width="68" height="48">
            <path id="ytvideo_icon" fill-opacity="0.8" d="M66.52,7.74c-0.78-2.93-2.49-5.41-5.42-6.19C55.79,.13,34,0,34,
                0S12.21,.13,6.9,1.55 C3.97,2.33,2.27,4.81,1.48,7.74C0.06,13.05,0,24,0,24s0.06,10.95,1.48,16.26c0.78,
                2.93,2.49,5.41,5.42,6.19 C12.21,47.87,34,48,34,48s21.79-0.13,27.1-1.55c2.93-0.78,4.64-3.26,
                5.42-6.19C67.94,34.95,68,24,68,24S67.94,13.05,66.52,7.74z"/>
            <path d="M 45,24 27,14 27,34" fill="#fff"/>
        </svg>
    </a>
</div>
