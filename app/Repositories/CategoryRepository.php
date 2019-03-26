<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class CategoryRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Category';
    }

    public function getAllCategory($column = array('*'))
    {
        $columns = [
            'id',
            'title'
        ];
        return $this->model->where('status', 1)->orderBy('title', 'asc')->get($columns);
    }

    public function getAllEn()
    {
        $columns = [
            'categories.id',
            'categories_lang.title',
            'categories_lang.description',
            'categories_lang.lang',
            'categories.slug',
            'categories.parent_id',
        ];
        return $this->model->join('categories_lang', 'categories.id', '=', 'categories_lang.category_id')
            ->where('categories_lang.lang', 'en')
            ->get($columns);
    }

    public function searchCategory($search, $count, $lang)
    {
        $columns = [
            'categories.id',
            'categories_lang.title',
            'categories_lang.description',
            'categories_lang.lang',
            'categories.slug',
            'categories.parent_id',
            'categories.created_at'
        ];
        return $this->model
            ->join('categories_lang', 'categories.id', '=', 'categories_lang.category_id')
            ->where('categories_lang.lang', $lang)
            ->where(function ($query) use ($search) {
                $query
                    ->where('categories_lang.title', 'like', '%'.$search.'%')
                    ->orWhere('categories.slug', 'like', '%'.$search.'%')
                    ->orWhere('categories_lang.description', 'like', '%'.$search.'%');
            })
            ->orderByDesc('categories.created_at')
            ->paginate($count, $columns);
    }

    public function getDetail($id)
    {
        $columnsEn = [
            'categories.id',
            \DB::raw('categories_lang.id AS id_en'),
            \DB::raw('categories_lang.title AS title_en'),
            \DB::raw('categories_lang.description AS description_en'),
            'categories.slug',
            'categories.created_at'
        ];
        $categories =  $this->model->join('categories_lang', 'categories.id', '=', 'categories_lang.category_id')
            ->where('categories.id', $id)
            ->where('categories_lang.lang', 'en')
            ->first($columnsEn);

        $columnsJa = [
            'categories.id',
            \DB::raw('categories_lang.id AS id_ja'),
            \DB::raw('categories_lang.title AS title_ja'),
            \DB::raw('categories_lang.description AS description_ja'),
            'categories.slug',
            'categories.created_at'
        ];
        $categoriesJa =  $this->model->join('categories_lang', 'categories.id', '=', 'categories_lang.category_id')
            ->where('categories.id', $id)
            ->where('categories_lang.lang', 'ja')
            ->first($columnsJa);

        $categories->id_ja = $categoriesJa->id_ja;
        $categories->title_ja = $categoriesJa->title_ja;
        $categories->description_ja = $categoriesJa->description_ja;
        return $categories;
    }
}
