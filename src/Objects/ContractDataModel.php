<?php

namespace Dcolsay\Ciwa\Objects;

use Illuminate\Support\Arr;
use Dcolsay\Ciwa\Objects\BaseModel;

class ContractDataModel extends BaseModel
{

    protected $fields = [
        "ConsentCode" => 1,
        "Branch" => 2,
        "PhaseOfContract" => 3,
        "ContractStatus" => 4,
        "TypeOfContract" => 5,
        "PurposeOfFinancing" => 6,
        "InterestRate" => 7,
        "CurrencyOfContract" => 8,
        "MethodOfPayment" => 9,
        "TotalAmount" => 10,
        "OutstandingAmount" => 11,
        "PastDueAmount" => 12,
        "PastDueDays" => 13,
        "NumberOfDueInstallments" => 14,
        "TotalMonthlyPayment" => 15,
        "PaymentPeriodicity" => 16,
        "StartDate" => 17,
        "ExpectedEndDate" => 18,
    ];

}
