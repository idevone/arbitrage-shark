<?php

namespace app\controllers;

use Yii;
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
            $invite_link = explode('+', $invite_link)[1];

            $pixel_id = Yii::$app->request->get('pixel', '');
            $campaign_id = Yii::$app->request->get('campaign_id', '');
            $ad_id = Yii::$app->request->get('ad_id', '');
            $campaign_name = Yii::$app->request->get('campaign_name', '');
            $adset_name = Yii::$app->request->get('adset_name', '');
            $ad_name = Yii::$app->request->get('ad_name', '');
            $placement = Yii::$app->request->get('placement', '');
            $site_source_name = Yii::$app->request->get('site_source_name', '');
            $fbclid = Yii::$app->request->get('fbclid', '');
            $invite_code = $invite_link;

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
                $this->sendFacebookEvent(
                    $pixel_id,
                    'EAATnh1j31G0BO9O3sngyLPaFUm99EYHk1UkkcN34GLRQxFux7XLbCkMlftpBSXZAgOrZB5ejrfVhSpOQwBRaURhd7Fe9ljFMzWjKT8v03yLz6s1xbDNCjgLAU38sdpx07kZBS79Lq0puxSbyezGmpsxdjdJlbadhqBacG21fszqbZAthh9o1CZB7KHAkflLOnowZDZD', // Access Token
                    'PageView',
                    time(),
                    [
                        "em" => hash('sha256', 'exadawmple@example.com'),
                        "ph" => hash('sha256', '1232134567890'),
                        "client_ip_address" => $_SERVER['REMOTE_ADDR'],
                        "client_user_agent" => $_SERVER['HTTP_USER_AGENT'],
                    ]
                );

                return $this->redirect('tg://join?invite=' . $invite_code);
            } else {
                return $this->redirect('https://google.com');
            }
        } else {
            Yii::error("Telegram API error: " . json_encode($responseData), __METHOD__);
            return $this->render('index', ['id' => $id]);
        }
    }

    private function sendFacebookEvent($pixel_id, $access_token, $event_name, $event_time, $user_data = [])
    {
        $url = "https://graph.facebook.com/v12.0/$pixel_id/events";

        $data = [
            "data" => [
                [
                    "event_name" => $event_name,
                    "event_time" => $event_time,
                    "user_data" => $user_data,
                    "action_source" => "website",
                ]
            ],
            "access_token" => $access_token,
//            "test_event_code" => "TEST8520",
        ];

        $json_data = json_encode($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);

        $response = curl_exec($ch);
        curl_close($ch);

        Yii::debug("Facebook Event API response: " . $response, __METHOD__);
    }
}
