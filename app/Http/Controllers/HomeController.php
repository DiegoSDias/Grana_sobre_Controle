<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $meses = [
            ['numero' => '01', 'nome' => 'Janeiro', 'cor' => 'from-blue-500 to-blue-600'],
            ['numero' => '02', 'nome' => 'Fevereiro', 'cor' => 'from-pink-500 to-pink-600'],
            ['numero' => '03', 'nome' => 'Março', 'cor' => 'from-green-500 to-green-600'],
            ['numero' => '04', 'nome' => 'Abril', 'cor' => 'from-yellow-500 to-yellow-600'],
            ['numero' => '05', 'nome' => 'Maio', 'cor' => 'from-purple-500 to-purple-600'],
            ['numero' => '06', 'nome' => 'Junho', 'cor' => 'from-indigo-500 to-indigo-600'],
            ['numero' => '07', 'nome' => 'Julho', 'cor' => 'from-red-500 to-red-600'],
            ['numero' => '08', 'nome' => 'Agosto', 'cor' => 'from-orange-500 to-orange-600'],
            ['numero' => '09', 'nome' => 'Setembro', 'cor' => 'from-teal-500 to-teal-600'],
            ['numero' => '10', 'nome' => 'Outubro', 'cor' => 'from-cyan-500 to-cyan-600'],
            ['numero' => '11', 'nome' => 'Novembro', 'cor' => 'from-violet-500 to-violet-600'],
            ['numero' => '12', 'nome' => 'Dezembro', 'cor' => 'from-rose-500 to-rose-600'],
        ];

        return view('home', compact('meses'));
}
}
