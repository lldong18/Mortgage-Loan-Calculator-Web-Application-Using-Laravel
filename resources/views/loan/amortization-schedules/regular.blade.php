<?php
/** @var \Illuminate\Database\Eloquent\Collection $amortizationScheduleEntries */
/** @var int $extraPaymentsCount */
?>
<div class="card mb-4">
    <div class="card-header text-center">
        <h5 class="my-2">Amortization Schedule{{ $extraPaymentsCount > 0 ? ' (Without Extra Payments)' : '' }}</h5>
    </div>
    <div class="card-body">

        <table class="table table-striped table-hover mb-0">
            <thead class="thead-light">
            <tr>
                <th>Month #</th>
                <th>Starting Balance</th>
                <th>Scheduled Payment</th>
                <th>Total Payment</th>
                <th>Principal</th>
                <th>Interest</th>
                <th>Ending Balance</th>
            </tr>
            </thead>
            <tbody>
            <?php /** @var \App\Models\LoanAmortizationScheduleEntry $amortizationScheduleEntry */ ?>
            @foreach($amortizationScheduleEntries as $amortizationScheduleEntry)
                <tr>
                    <td>{{ number_format($amortizationScheduleEntry->getMonthNumber()) }}</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($amortizationScheduleEntry->getStartingBalance()) }}</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($amortizationScheduleEntry->getMonthlyPayment()) }}</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($amortizationScheduleEntry->getTotalPayment()) }}</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($amortizationScheduleEntry->getPrincipal()) }}</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($amortizationScheduleEntry->getInterest()) }}</td>
                    <td>{{ \App\Helpers\Utilities::moneyFormat($amortizationScheduleEntry->getEndingBalance()) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
