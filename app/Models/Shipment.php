<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    // Nama tabel
    protected $table = 'shipments';

    // Kolom yang bisa diisi secara massal
    protected $fillable = [
        'no_invoice',
        'status',
        'order_date',
        'shipped_date',
        'delivered_date',
        'recipient_name',
        'shipping_address',
        'tracking_number',
        'courier',
        'note',
        'total_payment',
    ];

    // Jika ingin menggunakan date casting untuk tanggal
    protected $dates = [
        'order_date',
        'shipped_date',
        'delivered_date',
        'created_at',
        'updated_at',
    ];
}
