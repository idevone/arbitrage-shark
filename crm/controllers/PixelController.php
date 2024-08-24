<?php

namespace app\controllers;

use app\models\Pixel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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
            $model->pixel_title = Yii::$app->request->post('Pixel')['pixel_title'];
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Пиксель успешно создан');
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

    public function actionUpdate($id)
    {
        $model = Pixel::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Модель с данным ID не найдена.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->pixel_id = Yii::$app->request->post('Pixel')['pixel_id'];
            $model->pixel_api = Yii::$app->request->post('Pixel')['pixel_api'];
            $model->pixel_title = Yii::$app->request->post('Pixel')['pixel_title'];
            $model->updated_at = date('Y-m-d H:i:s');

            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Pixel::find()->where(['id' => $id])->one();

        if ($model !== null) {
            if ($model->delete()) {
                Yii::$app->session->setFlash('success', 'Пиксель успешно удален');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось удалить пиксель');
            }
        }

        return $this->redirect(['index']);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}