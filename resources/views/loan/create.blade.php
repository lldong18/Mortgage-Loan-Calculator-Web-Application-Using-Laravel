@extends('layout.master')

@section('header')
    <h5>Mortgage Loan Calculator</h5>
    <h1 class="mb-5">Create New Loan</h1>
    <a href="{{ route('loan.index') }}" class="btn btn-outline-secondary px-5">Back To Index</a>
@endsection

@section('main')
    <div class="card">
        <div class="card-body">
            <form method="post">
                @csrf
                <div class="mb-4">
                    <label for="loan-amount" class="form-label">Loan Amount (Principal)</label>
                    <input type="number" min="0" class="form-control @error('loanAmount') is-invalid @enderror" id="loan-amount" name="loanAmount" value="{{ old('loanAmount') }}" required aria-describedby="loanAmountHelp">
                    <div id="loanAmountHelp" class="form-text">The amount of money you borrow from a lender.</div>
                    @error('loanAmount')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="annual-interest-rate" class="form-label">Annual Interest Rate (In Percentage)</label>
                    <input type="number" min="0" max="100" class="form-control @error('annualInterestRate') is-invalid @enderror" id="annual-interest-rate" name="annualInterestRate" value="{{ old('annualInterestRate') }}" required aria-describedby="annualInterestRateHelp">
                    <div id="annualInterestRateHelp" class="form-text">The yearly interest that's charged to borrowers.</div>
                    @error('annualInterestRate')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="loan-term" class="form-label">Loan Term (In Years)</label>
                    <input type="number" min="1" class="form-control @error('loanTerm') is-invalid @enderror" id="loan-term" name="loanTerm" value="{{ old('loanTerm') }}" required aria-describedby="loanTermHelp">
                    <div id="loanTermHelp" class="form-text">The loan's repayment period in years.</div>
                    @error('loanTerm')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="monthly-fixed-extra-payment" class="form-label">Monthly Fixed Extra Payment (Optional)</label>
                    <input type="number" min="0" class="form-control @error('monthlyFixedExtraPayment') is-invalid @enderror" id="monthly-fixed-extra-payment" name="monthlyFixedExtraPayment" value="{{ old('monthlyFixedExtraPayment') }}" aria-describedby="monthlyFixedExtraPaymentHelp">
                    <div id="monthlyFixedExtraPaymentHelp" class="form-text">You may leave the input empty.</div>
                    @error('monthlyFixedExtraPayment')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-5">Create</button>
                </div>
            </form>
        </div>
    </div>
@endsection
