<?php
/**
 * author E.Demidov 2024
 */

namespace app\notifications;

use Exception;
use yii\base\BaseObject;

class Notification extends BaseObject
{
    /** @var Channel[] */
    public array $channels;
    public string $message;

    /**
     * Create an instance
     *
     * @param array $params notification properties
     * @return static the newly created Notification
     * @throws Exception
     */
    public static function create(array $params = []): static
    {
        return new static($params);
    }

    public function send(): bool
    {
        foreach ($this->channels as $channel) {
            return $channel->send($this);
        }

        return false;
    }
}
