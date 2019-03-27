<?php
namespace App\Services;

interface CvServiceInterface
{
    public function index($data);
    public function getByUser($user_id);
    public function store($data);
    public function detail($id);
    public function update($data, $id);
}
