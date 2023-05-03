<?php

namespace Tests\Feature;

use App\Models\Loan;
use App\Models\LoanAmortizationScheduleEntry;
use App\Models\LoanAmortizationScheduleEntryWithExtraRepayment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class TheTest extends TestCase
{
    use RefreshDatabase;

    public function test_loanIndexPageExists()
    {
        $response = $this->get(route('loan.index'));
        $response->assertOk();
    }

    public function test_loanCreatePageExists()
    {
        $response = $this->get(route('loan.create'));
        $response->assertOk();
    }

    public function test_shouldPassWhenAllInputsAreValid()
    {
        Session::start();

        $entries = [];
        foreach ([
                     ['loanAmount', 1000],
                     ['annualInterestRate', 5],
                     ['loanTerm', 1],
                 ] as $validEntry) {
            $response = $this->post(route('loan.create'), $entries);
            $response->assertStatus(302);
            $entries[$validEntry[0]] = $validEntry[1];
        }
        $response = $this->post(route('loan.create'), $entries);
        $response->assertRedirect(route('loan.show', 1));
    }

    private function genInput($loanAmount, $annualInterestRate, $loanTerm, $monthlyFixedExtraPayment = null): array
    {
        return [
            'loanAmount' => $loanAmount,
            'annualInterestRate' => $annualInterestRate,
            'loanTerm' => $loanTerm,
            'monthlyFixedExtraPayment' => $monthlyFixedExtraPayment,
        ];
    }

    public function test_shouldFailWithInvalidInput()
    {
        Session::start();

        foreach ([
                     $this->genInput(null, 5, 1, null),
                     $this->genInput('x', 5, 1, null),
                     $this->genInput(-1, 5, 1, null),
                     $this->genInput(1000, null, 1, null),
                     $this->genInput(1000, 'x', 1, null),
                     $this->genInput(1000, -1, 1, null),
                     $this->genInput(1000, 101, 1, null),
                     $this->genInput(1000, 5, null, null),
                     $this->genInput(1000, 5, 'x', null),
                     $this->genInput(1000, 5, -1, null),
                     $this->genInput(1000, 5, 0, null),
                     $this->genInput(1000, 5, 1, 'x'),
                     $this->genInput(1000, 5, 1, -1),
                 ] as $entries) {
            $response = $this->post(route('loan.create'), $entries);
            $response->assertStatus(302);
        }
    }

    public function test_correct_monthly_payment()
    {
        foreach ([
                     $this->genInput(1000, 5, 1),
                     $this->genInput(2000, 10, 2),
                     $this->genInput(3000, 15, 3),
                 ] as $entries) {
            list ('loanAmount' => $amount, 'annualInterestRate' => $annualInterestRate, 'loanTerm' => $term) = $entries;
            $monthlyInterestRate = ($annualInterestRate / 12.0) / 100.0;
            $numberOfMonths = $term * 12;
            $monthlyPayment = ($amount * $monthlyInterestRate) / (1.0 - pow(1.0 + $monthlyInterestRate, -$numberOfMonths));

            $loan = Loan::createNew($amount, $annualInterestRate, $term);
            /** @var LoanAmortizationScheduleEntry $entry */
            $entry = $loan->amortizationScheduleEntries()->first();

            $this->assertEquals(number_format($monthlyPayment, 4), number_format($entry->getMonthlyPayment(), 4));
        }
    }

    public function test_header_is_displayed_on_loan_summary()
    {
        Loan::createNew(1000, 5, 1);
        $response = $this->get(route('loan.show', 1));
        $this->assertStringContainsString('id="summary-table"', $response->getContent());
    }

    public function test_amortization_tables_are_correctly_generated()
    {
        Loan::createNew(1000, 5, 1, 150);
        $this->assertDatabaseCount((new LoanAmortizationScheduleEntry())->getTable(), 12);
        $this->assertDatabaseCount((new LoanAmortizationScheduleEntryWithExtraRepayment())->getTable(), 5);
    }
}
