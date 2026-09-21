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
        $budget = BudgetPeriod::with('budgetItems')->where('status', 'active')->first()
            ?? BudgetPeriod::with('budgetItems')->orderByDesc('fiscal_year')->first();

        $incomes = $budget ? $budget->budgetItems()->income()->orderBy('sort_order')->get() : collect();
        $expenses = $budget ? $budget->budgetItems()->expense()->orderBy('sort_order')->get() : collect();
        $financings = $budget ? $budget->budgetItems()->financing()->orderBy('sort_order')->get() : collect();

        $availableYears = BudgetPeriod::orderByDesc('fiscal_year')->pluck('fiscal_year');

        return view('transparency.apbkal', compact('budget', 'incomes', 'expenses', 'financings', 'availableYears'));
    }

    public function apbkalYear(int $year)
    {
        $budget = BudgetPeriod::with('budgetItems')->where('fiscal_year', $year)->firstOrFail();
        $incomes = $budget->budgetItems()->income()->orderBy('sort_order')->get();
        $expenses = $budget->budgetItems()->expense()->orderBy('sort_order')->get();
        $financings = $budget->budgetItems()->financing()->orderBy('sort_order')->get();

        $availableYears = BudgetPeriod::orderByDesc('fiscal_year')->pluck('fiscal_year');

        return view('transparency.apbkal', compact('budget', 'incomes', 'expenses', 'financings', 'availableYears'));
    }

    public function pembangunan()
    {
        $developments = Development::orderByDesc('start_date')->paginate(12);
        return view('transparency.pembangunan', compact('developments'));
    }

    public function pembangunanDetail(string $slug)
    {
        $development = Development::where('slug', $slug)->firstOrFail();
        $related = Development::where('id', '!=', $development->id)->limit(3)->get();
        return view('transparency.pembangunan-detail', compact('development', 'related'));
    }

    public function bansos()
    {
        $programs = SocialAidProgram::active()->get();
        return view('transparency.bansos', compact('programs'));
    }
}

