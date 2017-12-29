<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/20/17
 * Time: 8:37 AM
 */

namespace domain\services;

use domain\entities\Setting;
use domain\exceptions\DomainException;
use phpDocumentor\Reflection\Types\Null_;
use yii\base\Model;
use yii\helpers\ArrayHelper;


class ConfigService implements IConfigService
{
    public $path;
    private $menuService;
    private $xmlDOM;

    public function __construct(IMenuService $menuService)
    {
        $this->menuService = $menuService;
        $this->path  = \Yii::getAlias('@common').DIRECTORY_SEPARATOR.'config'.
            DIRECTORY_SEPARATOR.'settings.xml';
        $this->init();
    }

    public function getAll()
    {
        $output = [];

        $menuList = ArrayHelper::map($this->menuService->getMenuList(), 'id', 'title');
        $i = 0;

        foreach ($this->xmlDOM->children() as $key => $set)
        {
            $setting = new Setting();

            $setting->id = $i++;
            $setting->title = (string)$set->title;
            $setting->value = (string)$set->value;


            if((string)$set->type == 'menu') {
                $setting->options = $menuList;
            }

            $output[] = $setting;
        }

        return $output;
    }


    public function getOne($title)
    {

        foreach ($this->xmlDOM->children() as $key => $set)
        {
            if((string)$set->title == $title)
            {
                $setting = new Setting();

                $setting->id = $i++;
                $setting->title = (string)$set->title;
                $setting->value = (string)$set->value;

                return $setting;
            }
        }

        return false;
    }



    /* @param $settings array Setting[]
     * @throws DomainException
     * @return bool
     */
    public function save(array $settings)
    {
        if(!Model::validateMultiple($settings))
            throw new DomainException('Your entry values aren\'t valid');

        foreach ($settings as $setting) {
            $this->xmlDOM->setting[$setting->id]->title = $setting->title;
            $this->xmlDOM->setting[$setting->id]->value = $setting->value;
        }

        $this->xmlDOM->saveXML($this->path);
    }

    private function init()
    {
        if(file_exists($this->path)) {
            $this->xmlDOM = simplexml_load_file($this->path);
            return;
        }

        $dom = new \DOMDocument('1.0');
        $settings = $dom->appendChild($dom->createElement('settings'));

        $setting = $settings->appendChild($dom->createElement('setting'));
        $title = $setting->appendChild($dom->createElement('title'));
        $title->appendChild($dom->createTextNode('Header menu'));
        $type = $setting->appendChild($dom->createElement('type'));
        $type->appendChild($dom->createTextNode('menu'));

        $setting->appendChild($dom->createElement('value'));

        $settings = $settings->appendChild($dom->createElement('setting'));
        $title2 = $settings->appendChild($dom->createElement('title'));
        $title2->appendChild($dom->createTextNode('Frontend main-page menu'));
        $type = $settings->appendChild($dom->createElement('type'));
        $type->appendChild($dom->createTextNode('menu'));

        $settings->appendChild($dom->createElement('value'));

        $dom->formatOutput = true;

        $dom->save($this->path);

        $this->xmlDOM = simplexml_import_dom($dom);
    }

}