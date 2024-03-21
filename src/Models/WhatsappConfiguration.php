<?php

namespace EmilioPuljiz\ApiWhatsappBusiness\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappConfiguration extends Model
{
    use HasFactory;

    protected $table = 'whatsapp_configurations';

    protected $fillable = [
        'id',
        'client_id',
        'client_secret',
        'access_token',
        'expires_in',
        'phone_number_id',
        'configuration_id',
    ];
}
