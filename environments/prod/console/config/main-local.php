<?php
return [
    'components' => [
        'panelUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'http://panel.example.com',
            'rules' => require(\Yii::getAlias('@panel/config') . '/url.php'),
        ],
        'frontendUrlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'baseUrl' => 'http://example.com',
            'rules' => require(\Yii::getAlias('@frontend/config') . '/url.php'),
        ],
    ],
];
