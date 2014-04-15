<?php

namespace Rendes\Modules\User\Repositories;
use \Rendes\Components\BaseRepository;

class StudentRepository extends UserRepository
{
    protected $_id = '\Rendes\Modules\User\Entities\Student';
}