<?php

return [
    'class' => 'yii\db\Connection',
    // 'dsn' => 'pgsql:host=vultr-prod-47ece5d5-eb9c-4855-94c5-8804581daa12-vultr-prod-92d7.vultrdb.com;port=16751;dbname=audience-postgres',
    // 'username' => 'vultradmin',
    // 'password' => 'AVNS_nLThkCM8QhWbexMvWAk',
    'dsn' => getenv('DB_DSN'),
    'username' => getenv('DB_USER'),
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',
];
