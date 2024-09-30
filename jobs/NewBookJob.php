<?php
/**
 * author E.Demidov 2024
 */

namespace app\jobs;

use app\models\Book;
use app\notifications\NewBookNotification;
use Exception;
use yii\base\BaseObject;
use yii\queue\JobInterface;

/**
 * Class NewBookJob.
 */
class NewBookJob extends BaseObject implements JobInterface
{
    /** @var int */
    public int $bookId;

    /**
     * @inheritdoc
     * @throws Exception
     */
    public function execute($queue)
    {
        $book = Book::findOne($this->bookId);

        NewBookNotification::create()->createNotifyJobs($book);

        return true;
    }
}
