<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class RedirectController extends Controller
{
    public function actionIndex($id)
    {
        $bot_token = (string)\app\models\ChannelForm::find()->select('channel_bot')->where(['hashId' => $id])->scalar();
        $channel_id = (int)\app\models\ChannelForm::find()->select('channel_id')->where(['hashId' => $id])->scalar();

        $apiUrl = "https://api.telegram.org/bot$bot_token/createChatInviteLink";
        $postData = [
            'chat_id' => $channel_id,
            'creates_join_request' => true
        ];

        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->get($apiUrl, ['json' => $postData]);
            $responseData = json_decode($response->getBody()->getContents(), true);

            if (isset($responseData['ok']) && $responseData['ok']) {
                $invite_link = $responseData['result']['invite_link'];
                $invite_link = explode('+', $invite_link)[1];

                $pixel_id = Yii::$app->request->get('pixel', '');
                $pixel_api = \app\models\Pixel::find()->select('pixel_api')->where(['pixel_id' => $pixel_id])->scalar();
                $campaign_id = Yii::$app->request->get('campaign_id', '');
                $ad_id = Yii::$app->request->get('ad_id', '');
                $campaign_name = Yii::$app->request->get('campaign_name', '');
                $adset_name = Yii::$app->request->get('adset_name', '');
                $adset_id = Yii::$app->request->get('adset_id', '');
                $ad_name = Yii::$app->request->get('ad_name', '');
                $placement = Yii::$app->request->get('placement', '');
                $site_source_name = Yii::$app->request->get('site_source_name', '');
                $fbclid = Yii::$app->request->get('fbclid', '');
                $gclid = Yii::$app->request->get('gclid', '');
                $invite_code = $invite_link;
                $client_ip_address = $_SERVER['REMOTE_ADDR'];
                $client_user_agent = $_SERVER['HTTP_USER_AGENT'];
                $client_referer = $_SERVER['HTTP_REFERER'] ?? null;

                Yii::$app->db->createCommand()->insert('audience', [
                    'pixel_id' => $pixel_id,
                    'campaign_id' => $campaign_id,
                    'ad_id' => $ad_id,
                    'campaign_name' => $campaign_name,
                    'adset_name' => $adset_name,
                    'adset_id' => $adset_id,
                    'ad_name' => $ad_name,
                    'placement' => $placement,
                    'site_source_name' => $site_source_name,
                    'status' => 'PageView',
                    'fbclid' => $fbclid,
                    'invite_code' => $invite_code,
                    'created_at' => date('Y-m-d H:i:s'),
                    'client_ip_address' => $client_ip_address,
                    'client_user_agent' => $client_user_agent,
                    'refer' => $client_referer,
                    'gclid' => $gclid,
                ])->execute();

                return $this->render('index', ['id' => $id, 'invite_link' => $invite_link, 'pixel_id' => $pixel_id]);
            } else {
                Yii::error("Telegram API error: " . json_encode($responseData), __METHOD__);
                return $this->render('index', ['id' => $id, 'invite_link' => '', 'pixel_id' => ""]);
            }
        } catch (\Exception $e) {
            echo "Telegram API error: " . $e->getMessage() . $bot_token . $channel_id . PHP_EOL;
        }
        return $this->render('index', ['id' => $id, 'invite_link' => '', 'pixel_id' => ""]);
    }
}
