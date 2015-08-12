<?php
namespace Larakit\Controller\Admin;

use Illuminate\Support\Arr;
use Larakit\Base\Controller;
use Larakit\Base\Page;
use Larakit\Controller\ControllerAdmin;
use Larakit\Controller\ControllerIndex;
use Larakit\Webconfig;
use Larakit\Widget\WidgetFlash;

class ControllerWebconfig extends ControllerAdmin {

    protected $defaults = [];

    function __construct() {
        parent::__construct();
        $this->addBreadCrumb('larakit_webconfig::admin');
    }

    function formElement(\HTML_QuickForm2_Container $container, $code, $item) {
        $widget  = Arr::get($item, 'widget');
        $options = Arr::get($item, 'options', []);
        $value   = Arr::get($item, 'value');
        $label   = Arr::get($item, 'label');
        $desc    = Arr::get($item, 'desc');
        $example = Arr::get($item, 'example');
        $code    = self::prepareKey($code);
        switch ($widget) {
            case 'tb_select':
                $el = $container->putTbSelect($code);
                break;
            case 'tb_text':
                $el = $container->putTbText($code);
                break;
        }
        if ($options) {
            $el->loadOptions($options);
        }
        if ($value) {
            $el->setValue($value);
            $this->defaults[$code] = $value;
        }
        if ($example) {
            $el->setExample($example);
        }
        if ($desc) {
            $el->setDesc($desc);
        }
        $el->setLabel($label ? $label : $code);
    }

    static function prepareKey($code) {
        return str_replace('.', '_____', $code);
    }

    function index() {
        $form = new \Larakit\Form\TbForm('test');
        //соберем группы
        $groups = [];
        foreach (Webconfig::$defaults as $code => $item) {
            $group                 = Arr::get($item, 'group');
            $groups[$group][$code] = $item;
        }
        $accordion = $form->putAlteAccordion();
        foreach ($groups as $group => $items) {
            $f = $accordion->putAlteAccordionItem($group);
            foreach ($items as $code => $item) {
                $this->formElement($f, $code, $item);
            }
        }
        $values = [];
        foreach (Webconfig::getValues() as $k => $v) {
            $values[self::prepareKey($k)] = $v;
        }
        $form->initValues($values);
        $form->putTbSubmit('Сохранить')
             ->addClass('btn-primary btn-lg');
        if ($form->validate()) {
            foreach (Webconfig::$defaults as $code => $item) {
                $value = Arr::get($item, 'value');
                Webconfig::set($code, \Input::get(self::prepareKey($code), $value));
            }
            WidgetFlash::success('Значения конфигуратора обновлены!');
            return \Redirect::route(\Route::currentRouteName());
        }
        return $this->response(
            [
                'body' => $form
            ]
        );
    }
}