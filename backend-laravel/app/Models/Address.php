<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';

    protected $fillable = [
        'customer_id',
        'recipient_name',
        'address_name',
        'address_detail',
        'phone',
        'postal_code'
    ];

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
