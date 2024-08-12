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
        $bot_token = \app\models\ChannelForm::find()->select('channel_bot')->where(['hashId' => $id])->scalar();
        $channel_id = \app\models\ChannelForm::find()->select('channel_id')->where(['hashId' => $id])->scalar();
        $hashId = \app\models\ChannelForm::find()->select('hashId')->where(['hashId' => $id])->scalar();

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
                'invite_link' => $invite_code,
                'created_at' => date('Y-m-d H:i:s'),
            ])->execute();

            if ($id === $hashId) {
                return $this->redirect('tg://join?invite=' . $invite_code);
            } else {
                return $this->redirect('https://google.com');
            }
        } else {
            return $this->redirect('https://google.com');
        }
    }
}