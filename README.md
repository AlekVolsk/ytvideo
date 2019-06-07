# YtVideo

![Version](https://img.shields.io/badge/VERSION-1.5.1-0366d6.svg?style=for-the-badge)
![Joomla](https://img.shields.io/badge/joomla-3.7+-1A3867.svg?style=for-the-badge)
![Php](https://img.shields.io/badge/php-5.6+-8892BF.svg?style=for-the-badge)

_description in Russian [here](README.ru.md)_

Content plugin for Joomla! 3 for video output from YouTube.

This solution compares favorably with others in that it downloads video from YouTube not when loading the page, but only after the playback starts, thus creating no delays when loading the page.

The background image pre-cached and supports lazy loading (available in settings, enabled by default).

Shortcode format:
```
{ytvideo full_url[|[ratio]|title]}
```

For example:
```
{ytvideo https://www.youtube.com/watch?v=rrRZZ_3licM|16:9|What is a computer really? / An introduction to programming, lesson 1 (JavaScript ES6)}
```

Example of use without specifying the format (note the double slash):

```
{ytvideo https://www.youtube.com/watch?v=rrRZZ_3licM||What is a computer really? / An introduction to programming, lesson 1 (JavaScript ES6)}
```

Allowable aspect ratios are: `4:3`, `16:10`, `16:9`, `18:9` (a minus sign is allowed to be substituted for a colon). Incorrect aspect ratio will be part of the heading following it.

Specifying a title is optional. To quickly insert a shortcode, there is an editor button that opens a dialog box that allows you to enter the url and title of the video in the appropriate fields.
