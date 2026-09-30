<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use Illuminate\Support\Facades\Request;

class HomeController extends Controller
{
    public function index(Request $request, HomeService $homeService)
    {
        $anoSelecionado = $request->year ?? date('Y');
        $data = $homeService->index($anoSelecionado);
 
        return view('dashboard', compact('data', 'anoSelecionado'));
    }
}
