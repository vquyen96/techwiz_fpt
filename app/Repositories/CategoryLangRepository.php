<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class CategoryLangRepository extends Repository
{
    public function model()
    {
        return 'App\Models\CategoryLang';
    }

    public function store($data)
    {
        return $this->model->insert($data);
    }

    public function destroyByCategoryId($id)
    {
        return $this->model->where('category_id', $id)->delete();
    }
}
