<?php

namespace app\controllers;

use yii\web\Controller;

class BotsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}