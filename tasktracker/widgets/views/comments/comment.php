<?php

use tasktracker\entities\task\Comments;

/** @var Comments $model */

$author = $model->author->username ?? 'anonymous';
$str = <<<card
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-heading">{$author}
            <span class="label label-success pull-right">{$model->created_at}</span>
        </div>
        <div class="panel-body">
            {$model->text}
        </div>
    </div>
</div>

card;


echo $str;
