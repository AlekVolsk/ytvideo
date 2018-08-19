# YtVideo

![Github Releases](https://img.shields.io/github/downloads/AlekVolsk/ytvideo/latest/total.svg)

Content plugin for video output from YouTube. Content-plugin for Joomla! 3

**v1.0.1**

**Joomla 3.2 or later**

**PHP 5.6 or later**

Shortcode format:
```
{ytvideo full_url[|title]}
```

For example:
```
{ytvideo https://www.youtube.com/watch?v=rrRZZ_3licM|What is a computer really? / An introduction to programming, lesson 1 (JavaScript ES6)}
```

Specifying a title is optional. To quickly insert a shortcode, there is an editor button that opens a dialog box that allows you to enter the url and title of the video in the appropriate fields.

This solution compares favorably with others in that it downloads video from YouTube not when loading the page, but only after the playback starts, thus creating no delays when loading the page.
