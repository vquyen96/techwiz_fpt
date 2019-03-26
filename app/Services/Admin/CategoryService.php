<?php
namespace App\Services\Admin;

use App\Repositories\CategoryLangRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;
    protected $categoryLangRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryLangRepository $categoryLangRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->categoryLangRepository = $categoryLangRepository;
    }

    public function index($search, $count)
    {
        $lang = \Session::get('website_language', config('app.locale')) ?? 'en';
        return $this->categoryRepository->searchCategory($search, $count, $lang);
    }

    public function show($id)
    {
        return $this->categoryRepository->getDetail($id);
    }

    public function store($data)
    {
        DB::transaction(function () use ($data) {
            $category = $this->categoryRepository->create(['slug' => str_slug($data->slug)]);
            $dataLang = $this->getDataLangToStore($data, $category->id);
            $this->categoryLangRepository->store($dataLang);
        });
        return true;
    }

    protected function getDataLangToStore($data, $categoryId)
    {
        return [
            [
                'category_id' => $categoryId,
                'title' => $data->title_en,
                'description' => $data->description_en,
                'lang' => 'en'
            ],
            [
                'category_id' => $categoryId,
                'title' => $data->title_ja,
                'description' => $data->description_ja,
                'lang' => 'ja'
            ]
        ];
    }

    public function update($data, $id)
    {
        $category = $this->categoryRepository->find($id);
        $dataLang = $this->getDataLangToStore($data, $category->id);
        $categoryLangEn = $this->categoryLangRepository
            ->findWhere(['category_id' => $id, 'lang' => 'en'])->first();
        $categoryLangJa = $this->categoryLangRepository
            ->findWhere(['category_id' => $id, 'lang' => 'ja'])->first();

        DB::transaction(function () use ($category, $categoryLangEn, $categoryLangJa, $data, $dataLang) {
            $category->update(['slug' => str_slug($data->slug)]);
            $categoryLangEn->update($dataLang[0]);
            $categoryLangJa->update($dataLang[1]);
        });
        return true;
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $this->categoryLangRepository->destroyByCategoryId($id);
            $this->categoryRepository->find($id)->delete();
        });
        return true;
    }
}
