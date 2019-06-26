<?php

namespace tasktracker\repositories;

use tasktracker\entities\task\Status;

class StatusRepository
{
    public function get($id): Status
    {
        if (!$status = Status::findOne($id)) {
            throw new NotFoundException('Status not found');
        }
        return $status;
    }
}