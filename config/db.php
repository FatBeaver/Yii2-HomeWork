<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;port=3306;dbname=yii2',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    'enableSchemaCache' => true,
    'schemaCacheDuration' => 3600,
    'schemaCache' => 'cache',
];
