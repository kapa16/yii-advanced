<?php

namespace tasktracker\behaviors;

use Yii;
use yii\base\Behavior;

class TranslateBehavior extends Behavior
{
    public function translateTask($word): string
    {
        return Yii::t('app/task', $word);
    }

    public function translateControl($word): string
    {
        return Yii::t('app/control', $word);
    }
}