<?php
namespace App\Services;

interface JobServiceInterface
{
    public function search($data);
    public function store($data, $locations);
    public function show($id);
    public function apply($id);
    public function save($id);
}
