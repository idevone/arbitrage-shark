<?php
/* @var $this yii\web\View */
/* @var $id string */
/* @var $invite_link string */

// Получение данных
$pixel_id = Yii::$app->request->get('pixel', '');
//$pixel_api = \app\models\Pixel::find()->select('pixel_api')->where(['pixel_id' => $pixel_id])->scalar();
//
//try {
//    // Инициализация cURL
//    $ch = curl_init();
//
//    // Формирование URL для запроса
//    $url = "https://graph.facebook.com/v20.0/$pixel_id/events";
//
//    curl_setopt($ch, CURLOPT_URL, $url);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//    curl_setopt($ch, CURLOPT_POST, true);
//    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Отключение проверки SSL-сертификата (не рекомендуется для продакшн среды)
//    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Отключение проверки хоста SSL-сертификата (не рекомендуется для продакшн среды)
//
//    // Данные для POST-запроса
//    $postData = [
//        'data' => [
//            [
//                'event_name' => 'PageView',
//                'event_time' => time(),
//                'action_source' => 'website',
//                'event_id' => hash('sha256', uniqid()),
//                'event_source_url' => 'https://tgprojectredirect.top',
//                'user_data' => [
//                    'em' => hash('sha256', 'user@example.com'),
//                    'client_ip_address' => $_SERVER['REMOTE_ADDR'],
//                    'client_user_agent' => $_SERVER['HTTP_USER_AGENT'],
//                ],
//            ],
//        ],
//        'access_token' => $pixel_api,
//    ];
//    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
//    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
//    $response = curl_exec($ch);
//    if ($response === false) {
//        throw new Exception('Curl error: ' . curl_error($ch));
//    }
//    $responseData = json_decode($response, true);
//    if (isset($responseData['error'])) {
//        throw new Exception('Facebook API error: ' . $responseData['error']['message']);
//    }
//    curl_close($ch);
//
//
//} catch (Exception $e) {
//    Yii::error($e->getMessage(), __METHOD__);
//    echo 'Ошибка при отправке события: ' . $e->getMessage();
//}
//?>
<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?= $pixel_id ?>');
    fbq('track', 'PageView');
    window.location.href = 'tg://join?invite=<?= $invite_link ?>';
</script>
