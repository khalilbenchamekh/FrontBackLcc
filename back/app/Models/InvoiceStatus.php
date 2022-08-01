<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceStatus extends Model
{
    protected $table = 'invoicestatuses';

    protected $guarded = ['id'];
    public function charges()
    {
        return $this->hasMany(Charges::class);
    }
}
