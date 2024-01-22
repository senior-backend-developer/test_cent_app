<?php

namespace App\Services\Notifications;

use App\Services\Notifications\Message\Message;

class NotificationService
{
    public const CHANNEL = 'admin';
    private string $channel;

    public function __construct(string $channel = self::CHANNEL)
    {
        $this->channel = $channel;
    }

    /**
     * Отправка уведомления по выбранному каналу
     *
     * @param Message $message
     *
     * @return void
     */
    public function dispatch(Message $message): void
    {

    }
}