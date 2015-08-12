<?php
larakit_provider('Larakit\Webconfig\LarakitServiceProvider');

//регистрируем расширение твига
Larakit\Twig::register_function(
    'webconfig', function ($code) {
        return \Larakit\Webconfig::get($code);
    }
);
/*
\Larakit\Webconfig::makeItem('themewqer.wer.wer.wer', 'Дизайн сайта')
                  ->setWidget('tb_select')
                  ->setType('string')
                  ->setOptions(
                      [
                          'skin-red'  => 'skin-red',
                          'skin-blue' => 'skin-blue',
                      ]
                  )
                  ->setValue('skin-red')
                  ->setExample('skin-blue')
                  ->setLabel('Тема оформления')
                  ->put();
*/
//\Larakit\Webconfig::register('theme', 'select', 'string', 'skin-blue', 'Тема оформления');