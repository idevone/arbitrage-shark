<?php

namespace app\controllers;

use app\models\Pixel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class PixelController extends Controller
{
    public function behaviors()
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
        $model = new Pixel();

        if ($model->load(Yii::$app->request->post())) {
            $model->owner = Yii::$app->user->identity->username;
            $model->pixel_id = Yii::$app->request->post('Pixel')['pixel_id'];
            $model->pixel_api = Yii::$app->request->post('Pixel')['pixel_api'];
            $model->channel = 'Не назначен';
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Pixel created successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::error($model->errors);
                Yii::$app->session->setFlash('error', 'Failed to create pixel: ' . json_encode($model->errors));
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}