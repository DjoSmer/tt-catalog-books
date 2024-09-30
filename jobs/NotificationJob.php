<?php
/**
 * author E.Demidov 2024
 */

namespace app\jobs;

use app\notifications\Channel;
use app\notifications\Notification;
use Exception;
use yii\base\BaseObject;
use yii\queue\JobInterface;

/**
 * Class NotificationJob.
 */
class NotificationJob extends BaseObject implements JobInterface
{
    /** @var Channel[] */
    public array $channels;
    public string $message;

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function execute($queue)
    {
        $notification = Notification::create(['channels' => $this->channels, 'message' => $this->message]);
        return $notification->send();
    }
}
