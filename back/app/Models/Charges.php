<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    protected $guarded = ['id'];
    protected $fillable = [
        'isPayed',
        'archive',
    ];

    public function typeCharges()
    {
        return $this->belongsTo(TypesCharge::class, 'typeSchargeId','id');
    }

    public function invoiceStatus()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoiceStatusId','id');
    }
}
