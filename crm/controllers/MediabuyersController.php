<?php

namespace app\controllers;

use yii\web\Controller;

class MediabuyersController extends Controller
{

    public function actionIndex()
    {
        return $this->render('index');
    }

}