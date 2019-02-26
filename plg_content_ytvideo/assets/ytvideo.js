/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) 2019 Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.ytvideo > .ytvideo-cover')) {
        document.querySelector('.ytvideo > .ytvideo-cover').addEventListener('click', function (e) {
            var target = e.target || e.srcElement;
            target.innerHTML = "<iframe src='https://youtube.com/embed/" + target.dataset.videosrc + "?autoplay=1&rel=0&iv_load_policy=3' allow='accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture' allowfullscreen style='border:0;'></iframe>";
        });
    }
});