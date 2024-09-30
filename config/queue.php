<?php

return [
    'class' => yii\queue\redis\Queue::class,
    'ttr' => 120,
    'attempts' => 5,
    'as log' => yii\queue\LogBehavior::class,
];
