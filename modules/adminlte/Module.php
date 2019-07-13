<?php

namespace app\modules\adminlte;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\adminlte\controllers';
//    public  $layout = '/admin';
//    public  $layout = '/left-admin-menu';
    public function init()
    {
        parent::init();
        // custom initialization code goes here
    }
}
