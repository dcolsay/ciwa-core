<?php

namespace Dcolsay\Ciwa\Company;

class CompanyData
{
    protected $items = [];

    const FILLABLE = [
        'customer_code',
        'company_name',
        'legal_form',
        'business_status',
        'establishment_date',
        'number_of_employees',
        'industry_sector',
        'registration_number',
        'registration_number_issuer_country',
        'tax_number',
        'tax_number_country',
        'PO_box',
        'street',
        'number_of_building',
        'city',
        'region',
        'district',
        'country',
        'address_line',
        'mobile_phone',
        'fixed_line',
        'email',
    ];

    public function __construct($items)
    {
        $this->items = collect($items);
    }

    public static function makeFromImport($values)
    {
        new static($values);
    }

    public function toModel()
    {
        return '';
    }
}
