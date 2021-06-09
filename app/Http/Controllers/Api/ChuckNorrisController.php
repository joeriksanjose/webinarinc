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

    public function randomJoke()
    {
        $category = request()->get('category');
        $randomJoke = $this->chuckNorriesService->randomChuck($category);

        return response()->json(['random_joke' => $randomJoke]);
    }

    public function search()
    {
        $query = request()->get('query');
        $jokes = $this->chuckNorriesService->search($query);

        return response()->json(['jokes' => $jokes]);
    }
}
