<?php

namespace App\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\Auth;
use App\Enums\Tickets\Status as TicketStatus;

class TicketRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Ticket';
    }

    public function myTicket($perPage, $ticketStatus)
    {
        $ordering = 'DESC';
        $query = $this->model
            ->where('user_id', Auth::id());
        $query = $this->applyFilterStatus($query, $ticketStatus);
        return $query->orderBy('updated_at', $ordering)
            ->paginate($perPage);
    }

    private function applyFilterStatus($query, $ticketStatus)
    {
        $filteringQuery = $query;
        switch ($ticketStatus) {
            case "pending":
                $filteringQuery = $filteringQuery
                    ->where('status', TicketStatus::CREATED)
                    ->orWhere('status', TicketStatus::IN_PROGRESS);
                break;
            case "solved":
                $filteringQuery = $filteringQuery
                    ->where('status', TicketStatus::SOLVED);
                break;
            case "close":
                $filteringQuery = $filteringQuery
                    ->where('status', TicketStatus::CLOSED);
                break;
            default:
                break;
        }
        return $filteringQuery;
    }

    public function searchList($search, $status, $question)
    {
        $ticketSearch = $this->model;
        if (isset($search)) {
            $userIds = \DB::table('users')
                ->where('name', 'like', '%'.$search.'%')
                ->get(['id'])
                ->toArray();
            $userIds = array_column(json_decode(json_encode($userIds), true), 'id');

            $ticketSearch = $ticketSearch->where(function ($query) use ($search, $userIds) {
                $query
                    ->where('title', 'like', '%'.$search.'%')
                    ->orWhere('content', '%'.$search.'%')
                    ->orWhereIn('user_id', $userIds)
                    ->orWhere('id', 'like', '%'.$search.'%');
            });
        }
        if (isset($status)) {
            $ticketSearch = $ticketSearch->where('status', $status);
        }
        if (isset($question)) {
            $ticketSearch = $ticketSearch->where('ticket_question_id', $question);
        }
        return $ticketSearch;
    }

    public function findById($id)
    {
        $lang = \Session::get('website_language', config('app.locale'));
        $columns = [
            'tickets.id',
            'tickets.title',
            'content',
            'ticket_questions.description',
            'tickets.user_id',
            'tickets.product_url',
            'tickets.status',
            \DB::raw('ticket_questions_lang.title AS question_title'),
            'tickets.created_at',
            'tickets.updated_at',
        ];
        return $this->model->join('ticket_questions', 'tickets.ticket_question_id', '=', 'ticket_questions.id')
            ->join('ticket_questions_lang', 'ticket_questions.id', '=', 'ticket_questions_lang.ticket_question_id')
            ->where('tickets.id', '=', $id)
            ->where('ticket_questions_lang.lang', '=', $lang)
            ->first($columns);
    }
}
