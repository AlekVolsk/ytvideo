# YtVideo

![Version](https://img.shields.io/badge/VERSION-1.8.4-0366d6.svg?style=for-the-badge)
![Joomla](https://img.shields.io/badge/joomla-3.7+-1A3867.svg?style=for-the-badge)
![Php](https://img.shields.io/badge/php-5.6+-8892BF.svg?style=for-the-badge)

_description in Russian [here](README.ru.md)_

Content plugin for Joomla! 3 for video output from YouTube.

This solution compares favorably with others in that it downloads video from YouTube not when loading the page, but only after the playback starts, thus creating no delays when loading the page.

It is possible to optionally replace previously inserted `<iframe>` with links on YouTube to preview links, which will significantly speed up the rendering of the page. It is also possible to optionally replace text links (`<a>`) with YouTube links to preview links. If you need to cancel the conversion of individual text links to them, you must add the attribute `data-no-ytvideo`.

The background image pre-cached and supports lazy loading (available in settings, enabled by default). WebP images are supported.

Shortcode format:
```
{ytvideo full_url[|ratio][|title]}
```

For example:
```
{ytvideo https://www.youtube.com/watch?v=rrRZZ_3licM|16:9|What is a computer really? / An introduction to programming, lesson 1 (JavaScript ES6)}
```

Some parts of the shortcode may be missing, but their order must be preserved: address|ratio|title.

Allowable aspect ratios are:

- 4:3 (TV)
- 5:3 (Wide TV)
- 16:9 (Standard YouTube, HD)
- 16.7:9 (Standard films)
- 18:9 (iPhone)
- 19.9:9 (Wide 70mm)
- 2.35:1 (Panavision)
- 2.55:1 (Cinemascope)
- 2.7:1 (Ultra Panavision, 2K/4K)

A minus sign is allowed to be substituted for a colon, the decimal separator is skipped. Incorrect aspect ratio will be part of the heading following it.

Specifying a title is optional. To quickly insert a shortcode, there is an editor button that opens a dialog box that allows you to enter the url and title of the video in the appropriate fields.
