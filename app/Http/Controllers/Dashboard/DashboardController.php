<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Hrm\Employee\Employee;
use App\Models\Sales\Lead\Lead;
use App\Models\Sales\Opportunity\Opportunity;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Marchant\OrderBalance;
use App\Models\Marchant\BalanceRequest;
use App\Models\Marchant\RequestWhitelist;
use App\Models\Payment\Account;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data=[];

        return view('dashboard.index', $data);
    }
}
