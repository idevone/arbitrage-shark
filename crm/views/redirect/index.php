<?php
/* @var $this yii\web\View */
/* @var $id string */
/* @var $invite_link string */
/* @var $pixel_id string */

$this->title = 'Redirecting...';

$pixel_id = Yii::$app->request->get('pixel', '');
$pixel_api = \app\models\Pixel::find()->select('pixel_api')->where(['pixel_id' => $pixel_id])->scalar();
$campaign_id = Yii::$app->request->get('campaign_id', '');
$ad_id = Yii::$app->request->get('ad_id', '');
$campaign_name = Yii::$app->request->get('campaign_name', '');
$adset_name = Yii::$app->request->get('adset_name', '');
$adset_id = Yii::$app->request->get('adset_id', '');
$ad_name = Yii::$app->request->get('ad_name', '');
$placement = Yii::$app->request->get('placement', '');
$site_source_name = Yii::$app->request->get('site_source_name', '');
$fbclid = Yii::$app->request->get('fbclid', '');
$gclid = Yii::$app->request->get('gclid', '');
$invite_code = $invite_link;
$client_ip_address = $_SERVER['REMOTE_ADDR'];
$client_user_agent = $_SERVER['HTTP_USER_AGENT'];

$client_referer = Yii::$app->request->get('referer', 'Direct');


Yii::$app->db->createCommand()->insert('audience', [
    'pixel_id' => $pixel_id,
    'campaign_id' => $campaign_id,
    'ad_id' => $ad_id,
    'campaign_name' => $campaign_name,
    'adset_name' => $adset_name,
    'adset_id' => $adset_id,
    'ad_name' => $ad_name,
    'placement' => $placement,
    'site_source_name' => $site_source_name,
    'status' => 'PageView',
    'fbclid' => $fbclid,
    'invite_code' => $invite_link,
    'created_at' => date('Y-m-d H:i:s'),
    'client_ip_address' => $client_ip_address,
    'client_user_agent' => $client_user_agent,
    'refer' => $client_referer,
    'gclid' => $gclid,
])->execute();

?>

<script>
    !function (f, b, e, v, n, t, s) {
        if (f.fbq) return;
        n = f.fbq = function () {
            n.callMethod ?
                n.callMethod.apply(n, arguments) : n.queue.push(arguments)
        };
        if (!f._fbq) f._fbq = n;
        n.push = n;
        n.loaded = !0;
        n.version = '2.0';
        n.queue = [];
        t = b.createElement(e);
        t.async = !0;
        t.src = v;
        s = b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t, s)
    }(window, document, 'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?= $pixel_id ?>', {
        'external_id': '<?= $invite_link ?>'
    });
    fbq('track', 'PageView');

    window.location.href = 'tg://join?invite=<?= $invite_link ?>';
</script>

