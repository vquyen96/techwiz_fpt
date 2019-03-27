<?php

namespace App\Http\Controllers\API;

use App\Services\CvServiceInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    private $cvService;

    public function __construct(
        CvServiceInterface $cvService
    ) {
        $this->cvService = $cvService;
    }

    public function index(Request $request)
    {
        $data = [
            'search' => $request->query('count') ?? null,
            'count' => $request->query('count') ?? 20,
            'location_id' => $request->query('location_id') ?? 0,
            'category_id' => $request->query('category_id') ?? 0,
            'min_salary' => $request->query('salary') ?? 0,
            'max_salary' => $request->query('salary') ?? 10000,
            'type' => $request->query('type') ?? 0,
            'status' => $request->query('status') ?? 0,
        ];

        return $this->cvService->index($data);
    }

    public function user()
    {
        return $this->cvService->getByUser(Auth::id());
    }

    public function show($id)
    {
        return $this->cvService->detail($id);
    }

    public function store(Request $request)
    {
        $this->validator($request);
        $data = $this->getData($request);
        $dataResponse = $this->cvService->store($data);
        return response()->json($dataResponse, 200);
    }

    private function validator($request)
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'tel' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'introduce' => 'required|string|max:65530',
            'skill' => 'required|string|max:65530',
            'experience' => 'required|string|max:65530',
            'location_id' => 'required|numeric|min:0',
            'category_id' => 'required|numeric|min:0',
            'status' => 'required|numeric|min:1',
            'file' => 'mimes:doc,docx,pdf,pptx|max:5120',
        ]);
    }
    private function getData($request)
    {
        return $request->only([
            'title',
            'name',
            'tel',
            'email',
            'salary',
            'introduce',
            'skill',
            'experience',
            'location_id',
            'category_id',
            'status'
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validator($request);
        $data = $this->getData($request);
        $dataResponse = $this->cvService->update($data, $id);
        return response()->json($dataResponse, 200);
    }
}
