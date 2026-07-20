<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function index(): View
    {
        $user = User::with([
            'profile',
            'skills' => fn ($q) => $q->orderBy('category')->orderByDesc('level'),
            'educations' => fn ($q) => $q->orderByDesc('start_year'),
            'experiences' => fn ($q) => $q->orderByDesc('is_current')->orderByDesc('start_date'),
            'projects' => fn ($q) => $q->with(['technologies', 'images'])->orderByDesc('start_date')->limit(6),
            'certificates' => fn ($q) => $q->orderByDesc('issue_date')->limit(4)
        ])->firstOrFail();

        return view('portfolio.index', compact('user'));
    }
}
