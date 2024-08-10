<?php

/** @var yii\web\View $this */

/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\widgets\Menu;

$currentRoute = Yii::$app->controller->route;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
    <style>
        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link svg {
            fill: currentColor;
            color: white; /* Белый цвет для иконок */
        }

        .nav-link.active svg {
            color: white; /* Белый цвет для активной иконки */
        }

        .sidebar .nav-link:not(.active):hover {
            filter: brightness(0.7);
        }

    </style>
</head>

<body class="d-flex flex-column h-100">
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="bootstrap" viewBox="0 0 118 94">
        <title>Bootstrap</title>
        <path fill-rule="evenodd" clip-rule="evenodd"
              d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
    </symbol>
    <symbol id="home" viewBox="0 0 16 16">
        <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"></path>
    </symbol>
    <symbol id="users" viewBox="0 0 16 16">
        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1zm-7.978-1L7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002-.014.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4m3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0M6.936 9.28a6 6 0 0 0-1.23-.247A7 7 0 0 0 5 9c-4 0-5 3-5 4q0 1 1 1h4.216A2.24 2.24 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816M4.92 10A5.5 5.5 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275ZM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0m3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4"/>
    </symbol>
    <symbol id="user" viewBox="0 0 16 16">
        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z"/>
    </symbol>
    <symbol id="chart" viewBox="0 0 16 16">
        <path d="M4 11H2v3h2zm5-4H7v7h2zm5-5v12h-2V2zm-2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM6 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1zm-5 4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z"/>
    </symbol>
    <symbol id="dashboard" viewBox="0 0 16 16">
        <path d="M6 1v3H1V1zM1 0a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zm14 12v3h-5v-3zm-5-1a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1zM6 8v7H1V8zM1 7a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V8a1 1 0 0 0-1-1zm14-6v7h-5V1zm-5-1a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1z"/>
    </symbol>
    <symbol id="speedometer2" viewBox="0 0 16 16">
        <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"></path>
        <path fill-rule="evenodd"
              d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"></path>
    </symbol>
    <symbol id="table" viewBox="0 0 16 16">
        <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"></path>
    </symbol>
    <symbol id="people-circle" viewBox="0 0 16 16">
        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"></path>
        <path fill-rule="evenodd"
              d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"></path>
    </symbol>
    <symbol id="grid" viewBox="0 0 16 16">
        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"></path>
    </symbol>
    <symbol id="telegram" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
    </symbol>
    <symbol id="log-pulse" viewBox="0 0 16 16">
        <path fill-rule="evenodd"
              d="M10 1.5a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5zm-5 0A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5v1A1.5 1.5 0 0 1 9.5 4h-3A1.5 1.5 0 0 1 5 2.5zm-2 0h1v1H3a1 1 0 0 0-1 1V14a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V3.5a1 1 0 0 0-1-1h-1v-1h1a2 2 0 0 1 2 2V14a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V3.5a2 2 0 0 1 2-2m6.979 3.856a.5.5 0 0 0-.968.04L7.92 10.49l-.94-3.135a.5.5 0 0 0-.895-.133L4.232 10H3.5a.5.5 0 0 0 0 1h1a.5.5 0 0 0 .416-.223l1.41-2.115 1.195 3.982a.5.5 0 0 0 .968-.04L9.58 7.51l.94 3.135A.5.5 0 0 0 11 11h1.5a.5.5 0 0 0 0-1h-1.128z"/>
    </symbol>
    <symbol id="facebook" viewBox="0 0 16 16">
        <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/>
    </symbol>
    <symbol id="proxy" viewBox="0 0 16 16">
        <path d="M5.5 1.5A1.5 1.5 0 0 1 7 0h2a1.5 1.5 0 0 1 1.5 1.5v11a1.5 1.5 0 0 1-1.404 1.497c.35.305.872.678 1.628 1.056A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.224-.947c.756-.378 1.277-.75 1.628-1.056A1.5 1.5 0 0 1 5.5 12.5zM7 1a.5.5 0 0 0-.5.5v11a.5.5 0 0 0 .5.5h2a.5.5 0 0 0 .5-.5v-11A.5.5 0 0 0 9 1z"/>
        <path d="M8.5 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
    </symbol>
    <symbol id="audience" viewBox="0 0 16 16">
        <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5M.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5m15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5"/>
        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
    </symbol>
    <symbol id="channel" viewBox="0 0 16 16">
        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
        <path d="M5.5 12a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-3-8.5a1 1 0 0 1 1-1c5.523 0 10 4.477 10 10a1 1 0 1 1-2 0 8 8 0 0 0-8-8 1 1 0 0 1-1-1m0 4a1 1 0 0 1 1-1 6 6 0 0 1 6 6 1 1 0 1 1-2 0 4 4 0 0 0-4-4 1 1 0 0 1-1-1"/>
    </symbol>
    <symbol id="report" viewBox="0 0 16 16">
        <path d="M14.778.085A.5.5 0 0 1 15 .5V8a.5.5 0 0 1-.314.464L14.5 8l.186.464-.003.001-.006.003-.023.009a12 12 0 0 1-.397.15c-.264.095-.631.223-1.047.35-.816.252-1.879.523-2.71.523-.847 0-1.548-.28-2.158-.525l-.028-.01C7.68 8.71 7.14 8.5 6.5 8.5c-.7 0-1.638.23-2.437.477A20 20 0 0 0 3 9.342V15.5a.5.5 0 0 1-1 0V.5a.5.5 0 0 1 1 0v.282c.226-.079.496-.17.79-.26C4.606.272 5.67 0 6.5 0c.84 0 1.524.277 2.121.519l.043.018C9.286.788 9.828 1 10.5 1c.7 0 1.638-.23 2.437-.477a20 20 0 0 0 1.349-.476l.019-.007.004-.002h.001M14 1.221c-.22.078-.48.167-.766.255-.81.252-1.872.523-2.734.523-.886 0-1.592-.286-2.203-.534l-.008-.003C7.662 1.21 7.139 1 6.5 1c-.669 0-1.606.229-2.415.478A21 21 0 0 0 3 1.845v6.433c.22-.078.48-.167.766-.255C4.576 7.77 5.638 7.5 6.5 7.5c.847 0 1.548.28 2.158.525l.028.01C9.32 8.29 9.86 8.5 10.5 8.5c.668 0 1.606-.229 2.415-.478A21 21 0 0 0 14 7.655V1.222z"/>
    </symbol>
    <symbol id="cash" viewBox="0 0 16 16">
        <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
        <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195z"/>
        <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083q.088-.517.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
        <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 6 6 0 0 1 3.13-1.567"/>

    </symbol>
    <symbol id="graph-up-arrow" viewBox="0 0 16 16">
        <path fill-rule="evenodd"
              d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
    </symbol>
    <symbol id="edit" viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
        <path fill-rule="evenodd"
              d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
    </symbol>
</svg>
<?php $this->beginBody() ?>

<header id="header" class="" style="display: none">
    <?php
    NavBar::begin([]);
    NavBar::end();
    ?>
</header>

<main id="main" class="d-flex flex-nowrap" role="main">

    <?php if (!Yii::$app->user->isGuest): ?>

        <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; min-height: 100vh">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <?= Html::img('@web/images/logo.svg', ['alt' => 'Logo', 'style' => 'width: 40px; height: 32px;']) ?>
                <span class="fs-4">Arbitrage Shark</span>
            </a>
            <hr>
            <!--            <span class="fs-6 text-secondary">Аналитика</span>-->
            <!--            --><?php
            //            echo Nav::widget([
            //                'options' => ['class' => 'nav nav-pills flex-column '],
            //                'items' => [
            //                    [
            //                        'label' => Html::tag('svg', '<use xlink:href="#chart"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Статистика',
            //                        'url' => ['/'],
            //                        'encode' => false,
            //                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == 'site/index' ? ' active' : '')],
            //                    ],
            //                ]
            //            ]);
            ?>

            <?php if (Yii::$app->user->identity->role == 'TeamleadMediabuyer' || Yii::$app->user->identity->role == 'Admin' || Yii::$app->user->identity->role == 'Mediabuyer') { ?>
                <span class="fs-6 text-secondary mt-3">Отдел медиабаинга</span>
                <?php
                $items = [];
                if (Yii::$app->user->identity->role == 'TeamleadMediabuyer' || Yii::$app->user->identity->role == 'Admin') {
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#chart"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Статистика',
                        'url' => ['/statistic/mediabuyers'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/statistic/mediabuyers' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#users"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Сотрудники',
                        'url' => ['/users/mediabuyers'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/users/mediabuyers' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#report"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Отчеты сотрудников',
                        'url' => ['/reports/mediabuyers'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/reports/mediabuyers' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#facebook"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Facebook Pixel',
                        'url' => ['/pixel/index'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/pixel/index' ? ' active' : '')],
                    ];
                } elseif (Yii::$app->user->identity->role == 'Mediabuyer') {
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#chart"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Статистика',
                        'url' => ['/statistic/mediabuyer'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/statistic/mediabuyer' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#report"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Отчеты',
                        'url' => ['/reports/mediabuyer'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/reports/mediabuyer' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#facebook"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Facebook Pixel',
                        'url' => ['/pixel/index'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/pixel/index' ? ' active' : '')],
                    ];
                }
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-pills flex-column '],
                    'items' => $items
                ]);
            } ?>

            <?php if (Yii::$app->user->identity->role == 'TeamLeadProcessor' || Yii::$app->user->identity->role == 'Admin' || Yii::$app->user->identity->role == 'Processor') { ?>
                <span class="fs-6 text-secondary mt-3">Отдел обработчиков</span>
                <?php
                $items = [];
                if (Yii::$app->user->identity->role == 'TeamLeadProcessor' || Yii::$app->user->identity->role == 'Admin') {
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#graph-up-arrow"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Статистика',
                        'url' => ['/statistic/processors'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/statistic/processors' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#users"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Сотрудники',
                        'url' => ['/users/processors'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == 'users/processors' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#report"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Отчеты сотрудников',
                        'url' => ['/reports/processors'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == 'reports/processors' ? ' active' : '')],
                    ];
                } elseif (Yii::$app->user->identity->role == 'Processor') {
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#graph-up-arrow"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Статистика',
                        'url' => ['/statistic/processors'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/statistic/processors' ? ' active' : '')],
                    ];
                    $items[] = [
                        'label' => Html::tag('svg', '<use xlink:href="#report"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Отчеты сотрудников',
                        'url' => ['/reports/processors'],
                        'encode' => false,
                        'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == 'reports/processors' ? ' active' : '')],
                    ];
                }
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-pills flex-column '],
                    'items' => $items
                ]);
            } ?>

            <?php if (Yii::$app->user->identity->role == 'Financial' || Yii::$app->user->identity->role == 'Admin') { ?>
                <span class="fs-6 text-secondary mt-3">Отдел финансов</span>
                <?php
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-pills flex-column '],
                    'items' => [
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#chart"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Статистика',
                            'url' => ['/financial/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/financial/index' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#users"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Сотрудники',
                            'url' => ['/users/financials'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/users/financials' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#report"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Отчеты сотрудников',
                            'url' => ['/reports/financials'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/reports/financials' ? ' active' : '')],
                        ],
                    ]
                ]);
            } ?>

            <?php if (Yii::$app->user->identity->role == 'Admin') { ?>
                <span class="fs-6 text-secondary mt-3">Администрирование</span>
                <?php
                echo Nav::widget([
                    'options' => ['class' => 'nav nav-pills flex-column '],
                    'items' => [
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#users"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Пользователи',
                            'url' => ['/users/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/users' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#channel"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . ' Telegram каналы',
                            'url' => ['/channels/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == 'site/accounts' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#telegram"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Telegram аккаунты',
                            'url' => ['/accounts/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == 'view/accounts' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#cash"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Настройка кассы',
                            'url' => ['/cashdesk/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/cashdesk/index' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#facebook"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Facebook Pixel',
                            'url' => ['/pixel/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/pixel/index' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#proxy"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Просмотр Proxy',
                            'url' => ['/proxy/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/proxy' ? ' active' : '')],
                        ],
                        [
                            'label' => Html::tag('svg', '<use xlink:href="#user"></use>', ['class' => 'bi pe-none me-2', 'width' => 16, 'height' => 16]) . 'Клиенты каналов',
                            'url' => ['/audience/index'],
                            'encode' => false,
                            'linkOptions' => ['class' => 'nav-item nav-link text-white' . ($currentRoute == '/audience' ? ' active' : '')],
                        ],
                    ]
                ]);
            } ?>

            <div class="dropdown mt-auto">
                <hr>
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong> <?php echo Yii::$app->user->identity->username; ?> </strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">Новый проект...</a></li>
                    <li><a class="dropdown-item" href="#">Настройки</a></li>
                    <li><a class="dropdown-item" href="#">Профиль</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <?= Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Выход',
                            ['class' => 'dropdown-item logout']
                        )
                        . Html::endForm()
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <div class="<?= Yii::$app->user->isGuest ? 'col-12' : 'col-md-9 col-lg-10' ?> ms-sm-auto px-4">
        <?= $content ?>
    </div>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
