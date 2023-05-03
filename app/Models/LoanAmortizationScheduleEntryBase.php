<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanAmortizationScheduleEntryBase extends Model
{
    public function getId():              int   { return $this->getAttribute('id');               }
    public function getLoanId():          int   { return $this->getAttribute('loan_id');          }
    public function getMonthNumber():     int   { return $this->getAttribute('month_number');     }
    public function getStartingBalance(): float { return $this->getAttribute('starting_balance'); }
    public function getMonthlyPayment():  float { return $this->getAttribute('monthly_payment');  }
    public function getTotalPayment():    float { return $this->getAttribute('total_payment');    }
    public function getPrincipal():       float { return $this->getAttribute('principal');        }
    public function getInterest():        float { return $this->getAttribute('interest');         }
    public function getEndingBalance():   float { return $this->getAttribute('ending_balance');   }

}
