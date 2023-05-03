<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        return view('loan.index', [
            'loans' => (new Loan())->newModelQuery()->latest('id')->paginate(15)
        ]);
    }

    public function create(Request $request)
    {
        return view('loan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'loanAmount' => ['required', 'numeric', 'min:0'],
            'annualInterestRate' => ['required', 'numeric', 'min:0', 'max:100'],
            'loanTerm' => ['required', 'numeric', 'min:1'],
            'monthlyFixedExtraPayment' => ['nullable', 'numeric', 'min:0'],
        ]);

        list (
            'loanAmount' => $loanAmount,
            'annualInterestRate' => $annualInterestRate,
            'loanTerm' => $loanTerm,
            'monthlyFixedExtraPayment' => $monthlyFixedExtraPayment,
            ) = $request;

        $loan = Loan::createNew($loanAmount, $annualInterestRate, $loanTerm, $monthlyFixedExtraPayment);

        return redirect(route('loan.show', ['id' => $loan->getId()]));
    }

    public function show(Request $request, int $loanId)
    {
        $loan = Loan::find($loanId);
        return isset($loan)
            ? view('loan.show', [
                'loan' => $loan,
                'amortizationScheduleEntries' => $loan->amortizationScheduleEntries()->get(),
                'amortizationScheduleEntriesWithExtraRepayment' => $loan->amortizationScheduleEntriesWithExtraRepayment()->get(),
            ])
            : view('loan.index')->withErrors(["Invalid loan Id of ${loanId}!"]);
    }
}
