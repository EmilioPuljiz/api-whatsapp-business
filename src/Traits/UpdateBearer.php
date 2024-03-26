<?php

namespace EmilioPuljiz\ApiWhatsappBusiness\Traits;

use Exception;
use GuzzleHttp\Client;

trait UpdateBearer
{
    public static function UpdateBearerWhatsapp($whatsappConfiguration)
    {
        try {
            $client = new Client();
            $url = 'https://graph.facebook.com/v18.0/oauth/access_token?grant_type=fb_exchange_token&client_id='.$whatsappConfiguration->client_id.'&client_secret='.$whatsappConfiguration->client_secret.'&fb_exchange_token='.$whatsappConfiguration->access_token;

            $response = $client->request('POST', $url);

            $response_data = $response->getBody()->getContents();

            return json_decode($response_data);
        } catch (Exception $error) {
            report($error);

            // Puedes personalizar la respuesta de acuerdo a tus necesidades
            return 'Hubo un error al enviar la notificación de WhatsApp';
        }
    }
}
