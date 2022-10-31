<?php

namespace App\Http\Controllers;

use App\Model\Repository\BaseRepository;

abstract class BaseController
{
    protected BaseRepository $repo;
}