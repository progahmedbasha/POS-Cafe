<?php

namespace App\Http\Traits;

use App\Models\Invoice;

trait SaveInvoice
{
    public function saveInvoice($student_id, $group_id, $type, $monthly_level_price_id, $price)
    {
        Invoice::create(['student_id' => $student_id, 'group_id' => $group_id, 'type' => $type, 'monthly_level_price_id' => $monthly_level_price_id, 'price' => $price]);
    }
}