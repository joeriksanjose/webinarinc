<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ChuckNorrisService;

class ChuckNorrisController extends Controller
{
    protected $chuckNorriesService;

    public function __construct(ChuckNorrisService $chuckNorrisService)
    {
        $this->chuckNorriesService = $chuckNorrisService;
    }

    public function categories()
    {
        $categories = $this->chuckNorriesService->categories();
        return response()->json(['categories' => $categories]);
    }
}
