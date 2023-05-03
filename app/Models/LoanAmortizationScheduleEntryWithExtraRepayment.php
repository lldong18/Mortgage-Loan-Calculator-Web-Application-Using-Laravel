<?php

namespace App\Models;

class LoanAmortizationScheduleEntryWithExtraRepayment extends LoanAmortizationScheduleEntryBase
{
    protected $table = 'loan_amortization_schedules_with_extra_repayments';
    protected $guarded = [];

    public function getExtraPayment(): float { return $this->getAttribute('extra_payment'); }
}
