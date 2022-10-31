<?php

namespace App\Model\Repository;

use App\Model\Entity\Category;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct();
        $this->model = new Category();
        $this->table = 'categories';
    }
}
