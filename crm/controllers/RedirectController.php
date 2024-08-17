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
            $pixel_api = \app\models\Pixel::find()->select('pixel_api')->where(['pixel_id' => $pixel_id])->scalar();
            $campaign_id = Yii::$app->request->get('campaign_id', '');
            $ad_id = Yii::$app->request->get('ad_id', '');
            $campaign_name = Yii::$app->request->get('campaign_name', '');
            $adset_name = Yii::$app->request->get('adset_name', '');
            $ad_name = Yii::$app->request->get('ad_name', '');
            $placement = Yii::$app->request->get('placement', '');
            $site_source_name = Yii::$app->request->get('site_source_name', '');
            $fbclid = Yii::$app->request->get('fbclid', '');
            $invite_code = $invite_link;
            $client_ip_address = $_SERVER['REMOTE_ADDR'];
            $client_user_agent = $_SERVER['HTTP_USER_AGENT'];

            Yii::$app->db->createCommand()->insert('audience', [
                'pixel_id' => $pixel_id,
                'campaign_id' => $campaign_id,
                'ad_id' => $ad_id,
                'campaign_name' => $campaign_name,
                'adset_name' => $adset_name,
                'ad_name' => $ad_name,
                'placement' => $placement,
                'site_source_name' => $site_source_name,
                'status' => 'PageView',
                'fbclid' => $fbclid,
                'invite_code' => $invite_code,
                'created_at' => date('Y-m-d H:i:s'),
                'client_ip_address' => $client_ip_address,
                'client_user_agent' => $client_user_agent,
            ])->execute();

            return $this->render('index', ['id' => $id, 'invite_link' => $invite_link, 'pixel_id' => $pixel_id]);
        } else {
//            Yii::error("Telegram API error: " . json_encode($responseData), __METHOD__);
            return $this->render('index', ['id' => $id]);
        }
    }
}
