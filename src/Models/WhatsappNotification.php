<?php

namespace EmilioPuljiz\ApiWhatsappBusiness\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappNotification extends Model
{
    use HasFactory;

    protected $table = "whatsapp_notifications";

    protected $fillable = [
        'id',
        'template',
        'title',
        'description',
        'is_active'
    ];
}
