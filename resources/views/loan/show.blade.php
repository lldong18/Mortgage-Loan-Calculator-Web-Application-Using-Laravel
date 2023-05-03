<?php
/** @var \App\Models\Loan $loan */
/** @var \Illuminate\Database\Eloquent\Collection $amortizationScheduleEntriesWithExtraRepayment */
?>
@extends('layout.master')

@section('header')
    <h5>Mortgage Loan Calculator</h5>
    <h1 class="mb-5">Loan Summary (#{{ $loan->getId() }})</h1>
    <a href="{{ route('loan.index') }}" class="btn btn-outline-secondary px-5">Back To Index</a>
@endsection

@section('main')
    <div class="card mb-4">
        <div class="card-body">
            <table class="table table-sm table-hover mb-0" id="summary-table">
                <tbody>
                <tr>
                    <td>Loan Amount</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($loan->getAmount()) }}</td>
                </tr>
                <tr>
                    <td>Annual Interest rate</td>
                    <td>%{{ number_format($loan->getAnnualInterestRate(), 2) }}</td>
                </tr>
                <tr>
                    <td>Loan Term</td>
                    <td>{{ $loan->descriptiveTerm() }}</td>
                </tr>
                <tr>
                    <td>Optional Extra Payments</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($loan->getMonthlyFixedExtraPayment()) }}</td>
                </tr>
                <tr>
                    <td>Effective Interest Rate</td>
                    <td>??</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    @include('loan.amortization-schedules.extra-repayment', compact('amortizationScheduleEntriesWithExtraRepayment'))
    <?php $extraPaymentsCount = $amortizationScheduleEntriesWithExtraRepayment->count(); ?>
    @include('loan.amortization-schedules.regular', compact('amortizationScheduleEntries', 'extraPaymentsCount'))

@endsection
