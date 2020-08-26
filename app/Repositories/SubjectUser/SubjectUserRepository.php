<?php

namespace App\Repositories\SubjectUser;

use App\Models\SubjectUser;
use App\Repositories\BaseRepository;
use App\Repositories\SubjectUser\SubjectUserRepositoryInterface;

class SubjectUserRepository extends BaseRepository implements SubjectUserRepositoryInterface
{
    public function getModel()
    {
        return SubjectUser::class;
    }

}
