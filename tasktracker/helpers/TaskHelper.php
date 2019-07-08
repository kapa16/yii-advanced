<?php

namespace tasktracker\helpers;

use common\models\Users;
use tasktracker\entities\project\Projects;
use tasktracker\entities\task\Status;
use tasktracker\entities\task\Tasks;
use DateInterval;
use DateTime;
use yii\helpers\ArrayHelper;

class TaskHelper
{

    public static function statusList(): array
    {
        return ArrayHelper::map(Status::find()->asArray()->all(), 'id', 'name');
    }

    public static function responsibleList(): array
    {
        return ArrayHelper::map(Users::find()->orderBy('username')->asArray()->all(), 'id', 'username');
    }

    public static function projectsList(): array
    {
        return ArrayHelper::map(Projects::find()->orderBy('created_at')->asArray()->all(), 'id', 'name');
    }

    /**
     * @return array
     * @throws \Exception
     */
    public static function monthsList(): array
    {
        $date = new DateTime(date('Y'). '-01-01');
        $intervalMonth = new DateInterval('P1M');
        $months = [' '];
        for ($i = 1; $i <= 12; $i++) {
            $months[] = $date->format('F');
            $date->add($intervalMonth);
        }
        return $months;
    }

    public static function yearsList(): array
    {
        /** @var Tasks $firstTask */
        $firstTask = Tasks::find()->orderBy('created_at')->limit(1)->one();
        $firstYear = date('Y');
        if ($firstTask) {
            $firstYear = (int) (new \DateTime($firstTask->created_at))->format('Y');
        }

        $lastYear = date('Y') + 10;
        $years = [''];
        for ($i = $firstYear; $i < $lastYear; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }
}