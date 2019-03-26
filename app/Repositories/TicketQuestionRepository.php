<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class TicketQuestionRepository extends Repository
{
    public function model()
    {
        return 'App\Models\TicketQuestion';
    }

    public function allQuestion()
    {
        $columns = [
            'ticket_questions.id',
            'ticket_questions.description',
            'ticket_questions_lang.title',
            'ticket_questions_lang.lang',
        ];

        return $this->model
                ->join('ticket_questions_lang', 'ticket_questions.id', '=', 'ticket_questions_lang.ticket_question_id')
                ->get($columns);
    }

    public function getByLang($lang)
    {
        $columns = [
            'ticket_questions.id',
            'ticket_questions.description',
            'ticket_questions_lang.title',
            'ticket_questions_lang.lang',
        ];

        return $this->model
            ->join('ticket_questions_lang', 'ticket_questions.id', '=', 'ticket_questions_lang.ticket_question_id')
            ->where('ticket_questions_lang.lang', $lang)
            ->get($columns);
    }

    public function search($search, $count, $lang)
    {
        $columns = [
            'ticket_questions.id',
            'ticket_questions_lang.title',
            'ticket_questions.description',
            'ticket_questions_lang.lang',
            'ticket_questions.created_at'
        ];
        return $this->model
            ->join('ticket_questions_lang', 'ticket_questions.id', '=', 'ticket_questions_lang.ticket_question_id')
            ->where('ticket_questions_lang.lang', $lang)
            ->where(function ($query) use ($search) {
                $query
                    ->where('ticket_questions_lang.title', 'like', '%'.$search.'%')
                    ->orWhere('ticket_questions.description', 'like', '%'.$search.'%');
            })
            ->orderByDesc('ticket_questions.created_at')
            ->paginate($count, $columns);
    }

    public function getDetail($id)
    {
        $columnsEn = [
            'ticket_questions.id',
            'ticket_questions.description',
            \DB::raw('ticket_questions_lang.id AS id_en'),
            \DB::raw('ticket_questions_lang.title AS title_en'),
            'ticket_questions.created_at'
        ];
        $ticketQuestions =  $this->model
            ->join('ticket_questions_lang', 'ticket_questions.id', '=', 'ticket_questions_lang.ticket_question_id')
            ->where('ticket_questions.id', $id)
            ->where('ticket_questions_lang.lang', 'en')
            ->first($columnsEn);

        $columnsJa = [
            'ticket_questions.id',
            \DB::raw('ticket_questions_lang.id AS id_ja'),
            \DB::raw('ticket_questions_lang.title AS title_ja'),
            'ticket_questions.created_at'
        ];
        $ticketQuestionsJa =  $this->model
            ->join('ticket_questions_lang', 'ticket_questions.id', '=', 'ticket_questions_lang.ticket_question_id')
            ->where('ticket_questions.id', $id)
            ->where('ticket_questions_lang.lang', 'ja')
            ->first($columnsJa);

        $ticketQuestions->id_ja = $ticketQuestionsJa->id_ja;
        $ticketQuestions->title_ja = $ticketQuestionsJa->title_ja;
        return $ticketQuestions;
    }

    public function store($data)
    {
        return $this->model->create($data);
    }
}
