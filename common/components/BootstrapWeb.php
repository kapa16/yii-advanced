<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;

class BootstrapWeb implements BootstrapInterface
{

    public function bootstrap($app)
    {
        $this->setLanguage();
    }

    private function setLanguage(): void
    {
        Yii::$app->language = Yii::$app->session->get('language', 'en');
    }
}