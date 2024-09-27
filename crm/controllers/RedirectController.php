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
