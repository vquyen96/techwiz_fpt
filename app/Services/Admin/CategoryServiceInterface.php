<?php
namespace App\Services\Admin;

interface CategoryServiceInterface
{
    public function index($search, $count);
    public function show($id);
    public function store($data);
    public function update($data, $id);
    public function destroy($id);
}
