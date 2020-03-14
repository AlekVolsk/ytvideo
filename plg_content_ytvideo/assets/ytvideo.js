/*
 * @package     Joomla.Plugin
 * @subpackage  Content.ytvideo
 * @copyright   Copyright (C) Aleksey A. Morozov. All rights reserved.
 * @license     GNU General Public License version 3 or later; see http://www.gnu.org/licenses/gpl-3.0.txt
 */

(function () {
    if (!Array.prototype.forEach) {
        Array.prototype.forEach = function (callback, thisArg) {
            thisArg = thisArg || window;
            for (var i = 0; i < this.length; i++) {
                callback.call(thisArg, this[i], i, this);
            }
        };
    }
    if (typeof NodeList.prototype.forEach !== "function") {
        NodeList.prototype.forEach = Array.prototype.forEach;
    }
})();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.ytvideo > .ytvideo-cover').forEach(function (el) {
        el.addEventListener('click', function (e) {
            var target = e.target || e.srcElement;
            target.innerHTML = "<iframe src='//youtube.com/embed/" + target.dataset.videosrc + "?autoplay=1&rel=0&iv_load_policy=3' allow='accelerometer;autoplay;encrypted-media;gyroscope;picture-in-picture' allowfullscreen style='border:0;'></iframe>";
        });
    });
});
