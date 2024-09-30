<?php
/**
 * author E.Demidov 2024
 */

namespace app\notifications;

use app\jobs\NotificationJob;
use app\models\Book;
use Yii;

class NewBookNotification extends Notification
{
    public function createNotifyJobs(Book $book): bool
    {
        $bookName = $book->name;

        foreach ($book->authors as $author) {
            $subscribers = $author->authorSubscribers;
            $authorFullName = "$author->first_name $author->last_name";

            foreach ($subscribers as $subscriber) {
                $subscriber = $subscriber->subscriber;

                $phoneNumber = $subscriber->phone_number;
                $message = "$authorFullName has $bookName.";

                /**
                 * Создаю еще подзадачи, т.к. кому то может не дойти сразу смс.
                 * Можно было сделать еще таблицу для уведомлений, и там уже управлять кому-что доставили
                 */
                Yii::$app->queue->push(new NotificationJob([
                    'channels' => [new SmspilotChannel(['phoneNumber' => $phoneNumber])],
                    'message' => $message
                ]));
            }
        }
        return true;
    }
}
