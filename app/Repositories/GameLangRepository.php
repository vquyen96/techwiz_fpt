<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class GameLangRepository extends Repository
{
    public function model()
    {
        return 'App\Models\GameLang';
    }

    public function store($data)
    {
        return $this->model->insert($data);
    }
}
