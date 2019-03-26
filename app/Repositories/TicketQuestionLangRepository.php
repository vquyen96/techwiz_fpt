<?php
namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class TicketQuestionLangRepository extends Repository
{
    public function model()
    {
        return 'App\Models\TicketQuestionLang';
    }

    public function store($data)
    {
        return $this->model->insert($data);
    }

    public function destroyByQuestionId($id)
    {
        return $this->model->where('ticket_question_id', $id)->delete();
    }
}
