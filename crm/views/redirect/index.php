<?php
/* @var $this yii\web\View */
/* @var $id string */
/* @var $invite_link string */
/* @var $pixel_id string */

$this->title = 'Redirecting...';
$client_referer = $_SERVER["HTTP_REFERER"];
Yii::$app->db->createCommand()->insert('audience', [
    'refer' => $client_referer
])->execute();
echo $client_referer;

?>

<script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?= $pixel_id ?>', {
        'external_id': '<?= $invite_link ?>'
    });
    fbq('track', 'PageView');

    window.location.href = 'tg://join?invite=<?= $invite_link ?>';
</script>

