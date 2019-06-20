<?php

namespace tasktracker\forms\task;

use tasktracker\entities\task\Tasks;
use tasktracker\helpers\TaskHelper;
use DateTime;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearchForm extends Model
{
    public $id;
    public $name;
    public $status;
    public $responsible;
    public $deadline;
    public $month;
    public $year;
    public $filterBy = 'created_at';

    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'responsible', 'month', 'year', 'filterBy'], 'safe'],
            [['deadline'], 'datetime'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws \Exception
     * @throws \Throwable
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Tasks::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 21,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC]
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status_id' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        if ($this->month && $this->year) {
            $date = new DateTime($this->year . '-' . $this->month . '-01');
            $query->andFilterWhere(['>=', $this->filterBy, $date->format('Y-m-d H:i:s')]);

            $date->modify('last day of this month')->setTime(23, 59, 59);
            $query->andFilterWhere(['<=', $this->filterBy, $date->format('Y-m-d H:i:s')]);
        }

        return $dataProvider;
    }

    public function statusList(): array
    {
        return TaskHelper::statusList();
    }

    public function monthsList(): array
    {
        return TaskHelper::monthsList();
    }

    public function yearsList(): array
    {
        return TaskHelper::yearsList();
    }

    public function dateFieldsList(): array
    {
        return [
            'created_at' => 'created',
            'updated_at' => 'updated',
            'deadline' => 'deadline',
        ];
    }

}