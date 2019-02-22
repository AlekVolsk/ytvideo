# YtVideo

![Version](https://img.shields.io/badge/VERSION-1.2.0-0366d6.svg?style=for-the-badge)
![Joomla](https://img.shields.io/badge/joomla-3.7+-1A3867.svg?style=for-the-badge)
![Php](https://img.shields.io/badge/php-5.6+-8892BF.svg?style=for-the-badge)

Контентный плагин для Joomla! 3 для вывода видео с YouTube.

Формат шорткода:
```
{ytvideo full_url[|заголовок]}
```

Пример использования:
```
{ytvideo https://www.youtube.com/watch?v=rrRZZ_3licM|What is a computer really? / An introduction to programming, lesson 1 (JavaScript ES6)}
```

Указывать заголовок необязательно. Чтобы быстро вставить шорткод, есть кнопка редактора, которая открывает диалоговое окно, в котором можно ввести URL-адрес и заголовок видео в соответствующих полях.

Это решение выгодно отличается от других тем, что загружает видео с YouTube не при загрузке страницы, а только после начала воспроизведения, что не создает задержек при загрузке страницы.