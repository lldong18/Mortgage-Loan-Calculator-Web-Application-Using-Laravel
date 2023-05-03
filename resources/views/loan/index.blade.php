<?php
/** @var Illuminate\Contracts\Pagination $loans */
/** */
?>
@extends('layout.master')

@section('header')
    <h5>Welcome to</h5>
    <h1 class="mb-5">Mortgage Loan Calculator</h1>
    <a href="{{ route('loan.create') }}" class="btn btn-success px-5">Create Loan</a>
@endsection

@section('main')
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Loans</h3>

            @if($loans->count() > 0)
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Amount</th>
                        <th>Annual Interest Rate</th>
                        <th>Term</th>
                        <th>Monthly Fixed Extra Payment</th>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                        <?php /** @var \App\Models\Loan $loan */ ?>
                    @foreach($loans as $loan)
                        <tr>
                            <td>{{ $loan->getId() }}</td>
                            <td>{{ \App\Helpers\Utilities::moneyFormat($loan->getAmount()) }}</td>
                            <td>%{{ number_format($loan->getAnnualInterestRate(), 2) }}</td>
                            <td>{{ $loan->descriptiveTerm() }}</td>
                            <td>{{ \App\Helpers\Utilities::moneyFormat($loan->getMonthlyFixedExtraPayment()) }}</td>
                            <td class="text-end">
                                <a href="{{ route('loan.show', $loan->getId()) }}" class="btn btn-sm btn-outline-primary">Show</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $loans->links() }}
            @else
                <div class="p-5 text-center opacity-50">
                    There are no loans! Please create one :)
                </div>
            @endif
        </div>
    </div>
@endsection
