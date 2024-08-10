<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use function Psy\debug;

class UsersController extends Controller
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
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->password_hash)) {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
                $model->generateAccessToken();
                $model->role = Yii::$app->request->post('User')['role'];
                $model->status = 'active';
                $model->created_at = date('Y-m-d H:i:s');
                $model->updated_at = date('Y-m-d H:i:s');
                $model->telegram_accounts = '[]';
                $model->username = $model->username ?? 'dev';

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'User created successfully.');
                    return $this->redirect(['index']);
                } else {
                    Yii::error($model->errors);
                    Yii::$app->session->setFlash('error', 'Failed to create user: ' . json_encode($model->errors));
                }
            } else {
                $model->addError('password_hash', 'Поле для пароля не может быть пустым');
            }
        } else {
            Yii::error('Model not loaded with data: ' . print_r(Yii::$app->request->post(), true));
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

    public function actionIndex(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $model = User::find()->where(['id' => $id])->one();

        if (Yii::$app->request->post()) {
            $model->delete();
            return $this->redirect(['index']);
        }

        return $this->render('delete', [
            'model' => $model,
        ]);
    }

    public function actionProcessors(): string
    {
        return $this->render('processors');
    }

    public function actionMediabuyers(): string
    {
        return $this->render('mediabuyers');
    }

    public function actionFinancials(): string
    {
        return $this->render('financials');
    }
}