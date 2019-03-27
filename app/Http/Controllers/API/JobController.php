<?php

namespace App\Http\Controllers\API;

use App\Services\JobServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    private $jobService;

    public function __construct(
        JobServiceInterface $jobService
    ) {
        $this->jobService = $jobService;
    }

    public function index(Request $request)
    {
        $dataSearch = [
            'count' => $request->query('count') ?? 10,
            'search' => $request->query('search') ?? null,
            'hot' => $request->query('hot') ?? 0,
            'location' => $request->query('location') ?? 0,
            'category' => $request->query('category') ?? 0,
            'experience' => $request->query('experience') ?? 0,
            'expired' => $request->query('expired') ?? 0,
            'order' => $request->query('order') ?? 0,
        ];

        $dataResponse = $this->jobService->search($dataSearch);
//        dd($dataResponse);
        return response()->json($dataResponse, 200);
    }

    public function show($id)
    {
        $dataResponse = $this->jobService->show($id);
        return response()->json($dataResponse, 200);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $data = $this->getData($request);
        $this->jobService->store($data, $request->locations);
        return response()->json("OK", 200);
    }

    private function validator($reqeust)
    {
        return $reqeust->validate([
            'title' => 'required|string|max:255',
            'benefit' => 'required|string|max:65535',
            'description' => 'required|string|max:65535',
            'requirement' => 'required|string|max:65535',
            'keyword' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'rank' => 'required|string|max:255',
//            'start_date' => 'date_format:m/d/Y H:mm',
//            'expired_date' => 'date_format:m/d/Y H:mm',
            'category_id' => 'required|numeric|min:1',
            'locations' => 'required|string'
        ]);
    }

    private function getData($request)
    {
        return $request->only([
            'title',
            'salary',
            'year_experience',
            'benefit',
            'description',
            'requirement',
            'keyword',
            'language',
            'rank',
            'start_date',
            'expired_date',
            'category_id',
        ]);
    }

    public function apply($id)
    {
        $this->jobService->apply($id);
        return response()->json('OK', 200);
    }

    public function save($id)
    {
        $this->jobService->save($id);
        return response()->json('OK', 200);
    }
}
