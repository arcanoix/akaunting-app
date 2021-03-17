<?php

namespace App\Http\Controllers\Settings;

use App\Abstracts\Http\Controller;
use App\Models\FiscalRegime;

class Company extends Controller
{
    public function edit()
    {
        $fiscal_regime = FiscalRegime::orderBy('name')->pluck('name', 'id');

        return view('settings.company.edit', compact('fiscal_regime'));
    }
}
