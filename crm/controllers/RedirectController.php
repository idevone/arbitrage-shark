<?php

namespace app\controllers;

use http\Client;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class RedirectController extends Controller
{
    public function actionIndex($id)
    {


        $bot_token = (string) \app\models\ChannelForm::find()->select('channel_bot')->where(['hashId' => $id])->scalar();
        $channel_id = (int) \app\models\ChannelForm::find()->select('channel_id')->where(['hashId' => $id])->scalar();
        $hashId = $id;

        $apiUrl = "https://api.telegram.org/bot$bot_token/createChatInviteLink";
        $postData = [
            'chat_id' => $channel_id,
            'creates_join_request' => true
        ];

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $response = curl_exec($ch);
        curl_close($ch);

        $responseData = json_decode($response, true);


        Yii::debug("Telegram API response: " . json_encode($responseData), __METHOD__);
        Yii::error("Telegram API response: " . json_encode($responseData), __METHOD__);

        if (isset($responseData['ok']) && $responseData['ok']) {
            $invite_link = $responseData['result']['invite_link'];
            $invite_link = explode('+', $invite_link);

            $pixel_id = $_GET['pixel'] ?? '';
            $campaign_id = $_GET['campaign_id'] ?? '';
            $ad_id = $_GET['ad_id'] ?? '';
            $campaign_name = $_GET['campaign_name'] ?? '';
            $adset_name = $_GET['adset_name'] ?? '';
            $ad_name = $_GET['ad_name'] ?? '';
            $placement = $_GET['placement'] ?? '';
            $site_source_name = $_GET['site_source_name'] ?? '';
            $fbclid = $_GET['fbclid'] ?? '';
            $invite_code = $invite_link[1];

            Yii::$app->db->createCommand()->insert('audience', [
                'pixel_id' => $pixel_id,
                'campaign_id' => $campaign_id,
                'ad_id' => $ad_id,
                'campaign_name' => $campaign_name,
                'adset_name' => $adset_name,
                'ad_name' => $ad_name,
                'placement' => $placement,
                'site_source_name' => $site_source_name,
                'fbclid' => $fbclid,
                'invite_code' => $invite_code,
                'created_at' => date('Y-m-d H:i:s'),
            ])->execute();

            if ($id === $hashId) {

                function sendFacebookEvent($pixel_id, $access_token, $event_name, $event_time, $user_data = []) {
                    // URL для отправки событий в Facebook
                    $url = "https://graph.facebook.com/v12.0/$pixel_id/events?access_token=$access_token";

                    // Подготовка данных события
                    $data = [
                        "data" => [
                            [
                                "event_name" => $event_name,
                                "event_time" => $event_time,
                                "user_data" => $user_data,
                                "action_source" => "website",
                            ]
                        ]
                    ];

                    // Преобразование данных в JSON
                    $json_data = json_encode($data);

                    // Инициализация cURL
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

                    // Выполнение запроса
                    $response = curl_exec($ch);

                    // Проверка на ошибки
                    if (curl_errno($ch)) {
                        echo 'Error:' . curl_error($ch);
                    } else {
                        // Декодирование и вывод ответа
                        $decoded_response = json_decode($response, true);
                        print_r($decoded_response);
                    }

                    // Закрытие cURL сессии
                    curl_close($ch);
                }


                $user_data = [
                    "em" => hash('sha256', 'exadawmple@example.com'), // Email должен быть зашифрован с помощью SHA-256
                    "ph" => hash('sha256', '1232134567890'), // Телефон должен быть зашифрован с помощью SHA-256
                    "client_ip_address" => $_SERVER['REMOTE_ADDR'], // IP-адрес пользователя
                    "client_user_agent" => $_SERVER['HTTP_USER_AGENT'], // User-Agent пользователя
                ];

                sendFacebookEvent(
                    $pixel_id,
                    'EAATnh1j31G0BO9O3sngyLPaFUm99EYHk1UkkcN34GLRQxFux7XLbCkMlftpBSXZAgOrZB5ejrfVhSpOQwBRaURhd7Fe9ljFMzWjKT8v03yLz6s1xbDNCjgLAU38sdpx07kZBS79Lq0puxSbyezGmpsxdjdJlbadhqBacG21fszqbZAthh9o1CZB7KHAkflLOnowZDZD', // Замените на ваш Access Token
                    'Subscribe',
                    time(),
                    $user_data
                );

                return $this->redirect('tg://join?invite=' . $invite_code);
            } else {
                return $this->redirect('https://google.com');
            }
        } else {
            Yii::error("Telegram API error: " . json_encode($responseData), __METHOD__);
//            return $this->redirect('https://google.com');
            return $this->render('index', ['id' => $id]);
        }
        return $this->render('index', ['id' => $id]);
    }
}