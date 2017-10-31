<?php

return [
    'oauth2_server' => [
        'class' => \app\authorize\AuthorizationCode::class,
        'privateKeyPath' => 'file:///data/private.key',
        'encryptionKey' => 'JBMXsCcbue84XkbBI35NXsf3Bs5qeLD4mebjFftUKBA=',
        'refreshTokenTTL' => 'P1M',
        'codeTTL' => 'PT1H',
        'accessTokenTTL' => 'PT1H'
    ],
];
