<?php

namespace App\Http\Controllers;

use App\Models\BudgetPeriod;
use App\Models\BudgetItem;
use App\Models\Development;
use App\Models\SocialAidProgram;
use App\Models\SocialAidRecipient;
use Illuminate\Http\Request;

class TransparencyController extends Controller
{
    public function apbkal()
    {
        $budget = BudgetPeriod::with('items')->where('status', 'active')->first();
        $incomes = $budget ? $budget->items()->income()->orderBy('sort_order')->get() : collect();
        $expenses = $budget ? $budget->items()->expense()->orderBy('sort_order')->get() : collect();

        return view('transparency.apbkal', compact('budget', 'incomes', 'expenses'));
    }

    public function pembangunan()
    {
        $developments = Development::orderByDesc('start_date')->paginate(12);
        return view('transparency.pembangunan', compact('developments'));
    }

    public function bansos()
    {
        $programs = SocialAidProgram::active()->get();
        return view('transparency.bansos', compact('programs'));
    }
}
