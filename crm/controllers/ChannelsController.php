<?php

namespace app\controllers;

use app\models\ChannelForm;
use app\models\TelegramBot;
use Yii;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use GuzzleHttp\Client;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\ServerErrorHttpException;

class ChannelsController extends Controller
{
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'except' => ['login', 'error'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    return Yii::$app->response->redirect(['/login']);
                },
            ],
        ];
    }

    public function actionCreate()
    {
        $utm = 'pixel=<?php echo $_GET["pixel"] ?>&campaign_id=<?php echo $_GET["campaign_id"] ?>&adset_id=<?php echo $_GET["adset_id"] ?>&ad_id=<?php echo $_GET["ad_id"] ?>&campaign_name=<?php echo $_GET["campaign_name"] ?>&adset_name=<?php echo $_GET["adset_name"] ?>&ad_name=<?php echo $_GET["ad_name"] ?>&placement=<?php echo $_GET["placement"] ?>&site_source_name=<?php echo $_GET["site_source_name"] ?>&fbclid=<?php echo $_GET["fbclid"] ?>';
        $channel = new ChannelForm();
        $bot = new TelegramBot();

        if ($channel->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();

            try {
                $channel->channel_name = Yii::$app->request->post('ChannelForm')['channel_name'];
                $channel->channel_id = Yii::$app->request->post('ChannelForm')['channel_id'];
                $channel->channel_bot = Yii::$app->request->post('ChannelForm')['channel_bot'];
                $channel->telegram_account = Yii::$app->request->post('ChannelForm')['telegram_account'];
                if ($channel->fb_pixel === null) {
                    $channel->fb_pixel = '';
                }
                $length = 5;
                $numbers = '0123456789';
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $numbers[random_int(0, strlen($numbers) - 1)];
                }
                $channel->hashId = $randomString;
                $channel->btn_link = 'https://a-shark.co/redirect/' . $channel->hashId . '?' . $utm;
                $channel->created_at = date('Y-m-d H:i:s');
                $channel->updated_at = date('Y-m-d H:i:s');

                $bot->bot_name = Yii::$app->request->post('TelegramBot')['bot_name'];
                $bot->bot_token = $channel->channel_bot;
                $bot->channel_id = $channel->channel_id;
                try {
                    if (!$bot->save() || !$channel->save()) {
                        Yii::$app->session->setFlash('error', 'Ошибка при сохранении данных.' . json_encode($bot->errors));
                        return $this->redirect(['index']);
                    }
                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Канал успешно создан.');
                    return $this->redirect(['index']);
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении данных.' . $e->getMessage());
                    return $this->redirect(['index']);
                }
            } catch (Exception $e) {
                $transaction->rollBack();
                Yii::error('Transaction failed: ' . $e->getMessage(), __METHOD__);
                throw new ServerErrorHttpException('Ошибка при сохранении данных: ' . $e->getMessage());
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $channel,
                'bot' => $bot,
            ]);
        } else {
            return $this->render('create', [
                'model' => $channel,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        // Поиск канала и бота
        $channel = ChannelForm::findOne($id);
        $bot = $channel ? TelegramBot::findOne(['channel_id' => $channel->channel_id]) : null;

        if (!$channel || !$bot) {
            Yii::$app->session->setFlash('error', 'Канал или бот не найдены.');
            return $this->redirect(['index']);
        }

        if ($this->loadModels($channel, $bot)) {
            if ($this->updateModels($channel, $bot)) {
                Yii::$app->session->setFlash('success', 'Канал и бот успешно обновлены.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при сохранении данных.');
            }
        }

        return $this->renderUpdate($channel, $bot);
    }

    private function loadModels($channel, $bot)
    {
        return $channel->load(Yii::$app->request->post()) && $bot->load(Yii::$app->request->post());
    }

    private function updateModels($channel, $bot)
    {
        $request = Yii::$app->request->post('ChannelForm');

        $channel->channel_name = $request['channel_name'];
        $channel->channel_id = $request['channel_id'];
        $channel->channel_bot = $request['channel_bot'];
        $channel->telegram_account = $request['telegram_account'];
        $channel->fb_pixel = $this->processFbPixel($request);
        $channel->updated_at = date('Y-m-d H:i:s');

        $botRequest = Yii::$app->request->post('TelegramBot');
        $bot->bot_name = $botRequest['bot_name'];
        $bot->bot_token = $channel->channel_bot;
        $bot->channel_id = $channel->channel_id;

        return $channel->save() && $bot->save();
    }

    private function processFbPixel($request)
    {
        $selectedPixels = $request['selectedPixels'] ?? null;

        if (is_array($selectedPixels)) {
            return implode(',', $selectedPixels);
        }

        return $selectedPixels ?? '';
    }

    private function renderUpdate($channel, $bot)
    {
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $channel,
                'bot' => $bot,
            ]);
        }

        return $this->render('update', [
            'model' => $channel,
            'bot' => $bot,
        ]);
    }


    public function actionDelete($id): Response
    {
        $channel = ChannelForm::find()->where(['id' => $id])->one();
        $bot = TelegramBot::find()->where(['channel_id' => $channel->channel_id])->one();

        try {
            $channel->delete();
            $bot->delete();
            Yii::$app->session->setFlash('success', 'Канал и бот успешно удалены.');
        } catch (Exception $e) {
            Yii::$app->session->setFlash('error', 'Ошибка при удалении канала и бота.');
        }

        return $this->redirect(['index']);
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }
}