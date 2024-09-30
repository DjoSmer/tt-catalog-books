<?php
/**
 * author E.Demidov 2024
 */

namespace app\notifications;

use Exception;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\helpers\ArrayHelper;

class SmspilotChannel extends Channel
{
    public string $phoneNumber;

    protected string $from;
    protected string $apiKey;
    protected string $url = 'https://smspilot.ru/api.php';

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        $params = Yii::$app->params['smspilot'];

        if (!isset($params['apiKey'])) {
            throw new InvalidConfigException('Please set up [smspilot.apiKey] in params settings');
        }

        $this->apiKey = $params['apiKey'];
        $this->from = $params['from'] ?? 'INFORM';
    }

    /**
     * @throws Exception
     */
    public function send(Notification $notification): bool
    {
        $result = $this->call([
            'send' => urlencode($notification->message),
            'to' => urlencode($this->phoneNumber),
            'from' => $this->from,
        ]);

        // {"send":[{"server_id":"10000","phone":"79081234567","price":"1.68","status":"0"}],"balance":"11908.50","cost":"1.68"}
        return $this->check(ArrayHelper::getValue($result, 'send.0.server_id'));
    }

    /**
     * @throws Exception
     */
    protected function call(array $queryParams): array
    {
        $queryParams['apikey'] = $this->apiKey;
        $queryParams['format'] = 'json';

        $query = [];
        foreach ($queryParams as $key => $value) {
            $query[] = "$key=$value";
        }

        $url = $this->url . '?' . implode('&', $query);

        Yii::info('Send - ' . $url);

        $json = file_get_contents($url);
        $j = json_decode($json, true);

        Yii::info('Response - ' . $json);

        // {"error":{"code": "400", "description": "User not found", "description_ru": "Пользователь не найден" }
        if (isset($j['error'])) {
            trigger_error(ArrayHelper::getValue($j, 'error.description', 'Reason not found'), E_USER_WARNING);
        }

        return $j;
    }

    /**
     * @throws Exception
     */
    protected function check($id): bool
    {
        if (!$id) {
            throw new InvalidValueException('The server_id property is empty.');
        }

        $i = 0;
        $isFinish = false;
        do {
            $i++;
            sleep(10);

            $result = $this->call([
                'check' => $id,
            ]);

            $status = (int)ArrayHelper::getValue($result, 'check.0.status', 0);
            if ($status === -2 || $status === -1 || $status === 2) {
                $isFinish = true;
            }
        } while ($i < 10 && !$isFinish);

        return $isFinish;
    }
}
