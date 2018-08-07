<?php

namespace Tylercd100\Laravel\Webhooks\Interfaces;

use Illuminate\Contracts\Support\Arrayable;

interface SendsWebhook
{
    /**
     * Returns the name of the webhook event
     *
     * @return string
     */
    public function getWebhookEventName();

    /**
     * Returns an array or an instance of Arrayable
     * to use for the webhook payload
     *
     * @return array|Arrayable
     */
    public function toWebhook();
}