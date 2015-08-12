<?php
use Larakit\Widget\WidgetSideBar;

//****************************************
//  Управление настройками сайта
//****************************************
\Larakit\Base\Route::add('larakit_webconfig::admin')
                   ->setFilter('larakit.user.admin')
                   ->setTitle('WEB-конфиг')
                   ->setBaseUrl(Config::get('larakit::url_admin') . 'webconfigs/')
                   ->setNamespace('Admin')
                   ->setIcon('fa fa-gear')
                   ->setController('Webconfig')
                   ->put();
WidgetSideBar::factory('admin')
             ->setGroup(Config::get('larakit::admin_groups.base'))
             ->addItem('larakit_webconfig::admin', 'setting.webconfig');