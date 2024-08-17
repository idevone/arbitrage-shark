<?php
/* @var $this yii\web\View */
/* @var $id string */
/* @var $pixel_id string */
/* @var $pixel_api string */
/* @var $invite_code string */
use yii\helpers\Html;
use FacebookAds\Api;
use FacebookAds\Object\ServerSide\Event;
use FacebookAds\Object\ServerSide\EventRequest;
use FacebookAds\Object\ServerSide\UserData;
use FacebookAds\Object\ServerSide\Util;
?>
<head>
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '793430002675606');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=793430002675606&ev=PageView&noscript=1"
        /></noscript>
    <title>Telegram</title>
</head>

<?php
Api::init(null, null, $pixel_api);

$user_data = (new UserData())
    ->setEmail(Util::hash('user@example.com'))
    ->setClientIpAddress($_SERVER['REMOTE_ADDR'])
    ->setClientUserAgent($_SERVER['HTTP_USER_AGENT']);

$event = (new Event())
    ->setEventName('PageView')
    ->setEventTime(time())
    ->setUserData($user_data)
    ->setEventSourceUrl('https://example.com/purchase')
    ->setActionSource('website');

$events = array($event);
$request = (new EventRequest($pixel_id))
    ->setEvents($events);

try {
    $response = $request->execute();
    echo "Событие успешно отправлено: " . json_encode($response);
    header ('Location: tg://join?invite=' . $invite_code);
} catch (Exception $e) {
    echo 'Ошибка при отправке события: ' . $e->getMessage();
}

?>


<h1>Channel: <?= \yii\helpers\Html::encode($id) ?></h1>

<?php if ($id == '1'): ?>
    <p>This is content for Channel 1.</p>
<?php elseif ($id == '2'): ?>
    <p>This is content for Channel 2.</p>
<?php else: ?>
    <p>This is dynamic content for Channel <?= \yii\helpers\Html::encode($id) ?>.</p>
<?php endif; ?>
