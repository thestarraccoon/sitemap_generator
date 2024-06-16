# Sitemap generation library
Библиотека для генерации sitemap в форматах JSON, XML, CSV

## Содержание
- [Технологии](#технологии)
- [Начало работы](#начало-работы)

## Технологии
- PHP

## Использование
Расскажите как установить и использовать ваш проект, покажите пример кода:

Установите библиотеку через composer:
```sh
$ composer require thestarraccoon/sitemap-generation-library
```

Перейдайте массив страниц, формат, и путь для сохранения файла.
Пример:
```php
$pages = [
    [
        'loc' => 'https://example.com/home',
        'lastmod' => '2024-06-10',
        'changefreq' => 'daily',
        'priority' => '1.0'
    ],
    [
        'loc' => 'https://example.com/about-us',
        'lastmod' => '2024-06-09',
        'changefreq' => 'monthly',
        'priority' => '0.8'
    ],
    [
        'loc' => 'https://example.com/contact',
        'lastmod' => '2024-06-08',
        'changefreq' => 'yearly',
        'priority' => '0.5'
    ],
    [
        'loc' => 'https://example.com/services',
        'lastmod' => '2024-06-07',
        'changefreq' => 'weekly',
        'priority' => '0.9'
    ],
    [
        'loc' => 'https://example.com/products',
        'lastmod' => '2024-06-06',
        'changefreq' => 'daily',
        'priority' => '0.7'
    ],
    [
        'loc' => 'https://example.com/blog',
        'lastmod' => '2024-06-05',
        'changefreq' => 'weekly',
        'priority' => '0.6'
    ],
    [
        'loc' => 'https://example.com/blog/post-1',
        'lastmod' => '2024-06-04',
        'changefreq' => 'monthly',
        'priority' => '0.7'
    ],
    [
        'loc' => 'https://example.com/blog/post-2',
        'lastmod' => '2024-06-03',
        'changefreq' => 'monthly',
        'priority' => '0.6'
    ],
    [
        'loc' => 'https://example.com/blog/post-3',
        'lastmod' => '2024-06-02',
        'changefreq' => 'daily',
        'priority' => '0.8'
    ],
    [
        'loc' => 'https://example.com/privacy-policy',
        'lastmod' => '2024-06-01',
        'changefreq' => 'yearly',
        'priority' => '0.4'
    ]
];

$fileType = 'xml';
$pathToFile = '/generates/sitemap.docx';

$main = new SitemapGenerateInit($pages, $fileType, $pathToFile);
$main->initSitemapGenerate();
```
