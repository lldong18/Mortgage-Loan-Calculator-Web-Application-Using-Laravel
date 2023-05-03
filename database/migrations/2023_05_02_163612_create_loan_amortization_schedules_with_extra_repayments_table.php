<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanAmortizationSchedulesWithExtraRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_amortization_schedules_with_extra_repayments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('loan_id')->unsigned()->nullable(false);
            $table->integer('month_number')->unsigned()->nullable(false);
            // The accepted datatype for money, according to "Generally Accepted Accounting Principles" (or GAAP) for big numbers is `Decimal(13, 4)`
            list ($total, $places) = [13, 4];
            $table->decimal('starting_balance', $total, $places)->nullable(false);
            $table->decimal('monthly_payment', $total, $places)->nullable(false);
            $table->decimal('extra_payment', $total, $places)->nullable(false);
            $table->decimal('total_payment', $total, $places)->nullable(false);
            $table->decimal('principal', $total, $places)->nullable(false);
            $table->decimal('interest', $total, $places)->nullable(false);
            $table->decimal('ending_balance', $total, $places)->nullable(false);

            $table->foreign('loan_id', 'LASWEP_loan_id_foreign')->references('id')->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loan_amortization_schedules_with_extra_repayments');
    }
}
