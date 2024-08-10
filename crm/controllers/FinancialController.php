<?php

namespace app\controllers;

use app\models\FinancialRecordForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class FinancialController extends Controller
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
        $model = new FinancialRecordForm();

        if ($model->load(Yii::$app->request->post())) {
            $model->financier = Yii::$app->user->identity->username;
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Financial record created successfully.');
                return $this->redirect(['index']);
            } else {
                Yii::error($model->errors);
                Yii::$app->session->setFlash('error', 'Failed to create financial record: ' . json_encode($model->errors));
            }
        } // TODO: Do we need to add an else block here?

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }

        return $this->render('create');
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}