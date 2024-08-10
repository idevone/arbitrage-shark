<?php

namespace app\controllers;

use app\models\TelegramAccount;
use app\models\TelegramAuthForm;
use danog\MadelineProto\API;
use danog\MadelineProto\Exception;
use danog\MadelineProto\Logger;
use danog\MadelineProto\Settings\AppInfo;
use danog\MadelineProto\Tools;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class AccountsController extends Controller
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

    /** @noinspection t */
    public function actionCreate(): string
    {
        $model = new TelegramAccount();

        if ($model->load(Yii::$app->request->post())) {
            $model->phone_number = Yii::$app->request->post('TelegramAccount')['phone_number'];
            $model->user_id = Yii::$app->request->post('TelegramAccount')['user_id'];
            $model->username = Yii::$app->request->post('TelegramAccount')['username'];
            $model->first_name = Yii::$app->request->post('TelegramAccount')['first_name'];
            $model->last_name = Yii::$app->request->post('TelegramAccount')['last_name'];
            $model->status = 'inactive';
            $model->responsible = 'dev';
            $model->api_id = Yii::$app->request->post('TelegramAccount')['api_id'];
            $model->api_hash = Yii::$app->request->post('TelegramAccount')['api_hash'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect('index');
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        };

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public
    function actionIndex(): string
    {
        return $this->render('index');
    }
}