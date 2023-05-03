<?php /** @var \Illuminate\Database\Eloquent\Collection $amortizationScheduleEntriesWithExtraRepayment */ ?>
@if($amortizationScheduleEntriesWithExtraRepayment->count() > 0)
    <div class="card mb-4">
        <div class="card-header text-center">
            <h5 class="my-2">Amortization Schedule (With Extra Payments)</h5>
        </div>

        <div class="card-body">
            <table class="table table-striped table-hover mb-0">
                <thead class="thead-light">
                <tr>
                    <th>Month #</th>
                    <th>Starting Balance</th>
                    <th>Scheduled Payment</th>
                    <th>Extra Payment</th>
                    <th>Total Payment</th>
                    <th>Principal</th>
                    <th>Interest</th>
                    <th>Ending Balance</th>
                </tr>
                </thead>
                <tbody>
                    <?php /** @var \App\Models\LoanAmortizationScheduleEntryWithExtraRepayment $extraPaymentEntry */ ?>
                @foreach($amortizationScheduleEntriesWithExtraRepayment as $extraPaymentEntry)
                    <tr>
                        <td>{{ number_format($extraPaymentEntry->getMonthNumber()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getStartingBalance()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getMonthlyPayment()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getExtraPayment()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getTotalPayment()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getPrincipal()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getInterest()) }}</td>
                        <td>{{ \App\Helpers\Utilities::moneyFormat($extraPaymentEntry->getEndingBalance()) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif
