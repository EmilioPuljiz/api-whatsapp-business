<?php

namespace EmilioPuljiz\ApiWhatsappBusiness\Traits;

use DateTime;
use EmilioPuljiz\ApiWhatsappBusiness\Models\WhatsappConfiguration;
use Exception;
use GuzzleHttp\Client;
use EmilioPuljiz\ApiWhatsappBusiness\Traits\UpdateBearer;

trait SendWhatsapp
{
    use UpdateBearer;

    public function SendWhatsappNotification($phoneNumber, $template, $vars)
    {
        try {
            $whatsappConfiguration = WhatsappConfiguration::all()->first();

            if ($whatsappConfiguration) {
                $phoneNumber = str_replace('+', '', $phoneNumber);
                $now = new DateTime();
                $expires_in = new DateTime($whatsappConfiguration->expires_in);

                if ($now > $expires_in) {
                    $updatedToken = $this->UpdateBearerWhatsapp($whatsappConfiguration);
                    $whatsappConfiguration->access_token = $updatedToken->access_token;
                    $whatsappConfiguration->expires_in = date('Y-m-d H:i:s', (strtotime(date($now->format('Y-m-d H:i:s'))) + (int) $updatedToken->expires_in));
                    $whatsappConfiguration->save();
                }

                $client = new Client();

                $parameters = [];
                foreach ($vars as $var) {
                    array_push($parameters, [
                        'type' => 'text',
                        'text' => $var,
                    ]);
                }

                $data = [
                    'messaging_product' => 'whatsapp',
                    'recipient_type' => 'individual',
                    'to' => $phoneNumber,
                    'type' => 'template',
                    'template' => [
                        'name' => $template,
                        'language' => [
                            'code' => 'es_ar',
                        ],
                        'components' => [
                            [
                                'type' => 'body',
                                'parameters' => $parameters,
                            ],
                        ],
                    ],
                ];

                $json_data = json_encode($data);

                $url = 'https://graph.facebook.com/v18.0/' . $whatsappConfiguration->phone_number_id . '/messages';

                $response = $client->request('POST', $url, [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $whatsappConfiguration->access_token,
                        'Content-Type' => 'application/json',
                    ],
                    'body' => $json_data,
                ]);

                $response_data = $response->getBody()->getContents();

                return json_decode($response_data);
            }

            return 'No existe configuración de Whatsapp';
        } catch (Exception $error) {
            report($error);

            // Puedes personalizar la respuesta de acuerdo a tus necesidades
            return 'Hubo un error al enviar la notificación de WhatsApp';
        }
    }
}
