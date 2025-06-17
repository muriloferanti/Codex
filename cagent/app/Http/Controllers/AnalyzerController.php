<?php

namespace App\Http\Controllers;

use App\Services\HtmlAnalyzerService;
use Illuminate\Http\Request;

class AnalyzerController extends Controller
{
    protected $analyzer;

    public function __construct(HtmlAnalyzerService $analyzer)
    {
        $this->analyzer = $analyzer;
    }

    public function analyze(Request $request)
    {
        $html = $request->input('html');

        if (!$html) {
            return response()->json(['error' => 'HTML is required'], 400);
        }

        $result = $this->analyzer->analyze($html);

        return response()->json(['data' => $result]);
    }
}
