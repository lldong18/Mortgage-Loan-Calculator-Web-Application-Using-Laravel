<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Loan extends Model
{
    protected $table = 'loans';
    protected $guarded = [];

    const UPDATED_AT = null;

    public function getId(): int
    {
        return $this->getAttribute('id');
    }

    public function getAmount(): int
    {
        return $this->getAttribute('amount');
    }

    public function getAnnualInterestRate(): int
    {
        return $this->getAttribute('annual_interest_rate');
    }

    public function getTerm(): int
    {
        return $this->getAttribute('term');
    }

    public function descriptiveTerm(): string
    {
        $termInYears = $this->getTerm();
        $termInMonths = $termInYears * 12;
        return number_format($termInYears) . Str::plural(' Year', $termInYears)
            . ' (' . number_format($termInMonths) . Str::plural(' Month', $termInMonths) . ')';
    }

    public function getMonthlyFixedExtraPayment(): ?int
    {
        return $this->getAttribute('monthly_fixed_extra_payment');
    }

    public function amortizationScheduleEntries(): HasMany
    {
        return $this->hasMany(LoanAmortizationScheduleEntry::class, 'loan_id', 'id');
    }

    public function amortizationScheduleEntriesWithExtraRepayment(): HasMany
    {
        return $this->hasMany(LoanAmortizationScheduleEntryWithExtraRepayment::class, 'loan_id', 'id');
    }

    public static function createNew(int $amount, int $annualInterestRate, int $term, ?int $fixedMonthlyExtraPayment = null): ?self
    {
        $newLoan = new self([
            'amount' => $amount,
            'annual_interest_rate' => $annualInterestRate,
            'term' => $term,
            'monthly_fixed_extra_payment' => $fixedMonthlyExtraPayment,
        ]);
        $newLoan->save();
        $newLoan->refresh();

        $newLoadId = $newLoan->getId();

        $monthlyInterestRate = ($annualInterestRate / 12.0) / 100.0;
        $numberOfMonths = $term * 12;
        $monthlyPayment = ($amount * $monthlyInterestRate) / (1.0 - pow(1.0 + $monthlyInterestRate, -$numberOfMonths));

        $entriesProps = [];

        $startingBalance = $amount;
        for ($i = 0; $i < $numberOfMonths; ++$i) {

            $interest = $startingBalance * $monthlyInterestRate;
            $totalPayment = min($monthlyPayment, $startingBalance);
            $principal = $totalPayment - $interest;
            $endingBalance = $monthlyPayment <= $startingBalance ? $startingBalance - $principal : 0;

            $entriesProps[] = [
                'loan_id' => $newLoadId,
                'month_number' => $i + 1,
                'starting_balance' => $startingBalance,
                'monthly_payment' => $monthlyPayment,
                'total_payment' => $totalPayment,
                'principal' => $principal,
                'interest' => $interest,
                'ending_balance' => $endingBalance,
            ];

            $startingBalance = $endingBalance;
        }

        LoanAmortizationScheduleEntry::insert($entriesProps);

        if ($fixedMonthlyExtraPayment > 0) {
            $entriesProps = [];
            $startingBalance = $amount;

            for ($i = 0; $i < $numberOfMonths; ++$i) {

                $interest = $startingBalance * $monthlyInterestRate;

                $extraPayment = 0;
                if ($fixedMonthlyExtraPayment + $monthlyPayment < $startingBalance) {
                    $extraPayment = $fixedMonthlyExtraPayment;
                } else if ($startingBalance > $fixedMonthlyExtraPayment) {
                    $extraPayment = $startingBalance - $fixedMonthlyExtraPayment;
                }
                $totalPayment = min($monthlyPayment + $extraPayment, $startingBalance);
                $principal = $totalPayment - $interest;
                $endingBalance = $monthlyPayment + $extraPayment <= $startingBalance ? $startingBalance - $principal : 0;

                $entriesProps[] = [
                    'loan_id' => $newLoadId,
                    'month_number' => $i + 1,
                    'starting_balance' => $startingBalance,
                    'extra_payment' => $extraPayment,
                    'monthly_payment' => $monthlyPayment,
                    'total_payment' => $totalPayment,
                    'principal' => $principal,
                    'interest' => $interest,
                    'ending_balance' => $endingBalance,
                ];

                if ($endingBalance == 0)
                    break;

                $startingBalance = $endingBalance;
            }

            LoanAmortizationScheduleEntryWithExtraRepayment::insert($entriesProps);
        }

        return $newLoan;
    }
}
