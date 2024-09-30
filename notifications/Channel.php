<?php
/**
 * author E.Demidov 2024
 */

namespace app\notifications;

use yii\base\BaseObject;

abstract class Channel extends BaseObject
{
    public abstract function send(Notification $notification);
}
