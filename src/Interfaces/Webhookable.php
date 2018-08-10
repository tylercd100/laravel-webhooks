<?php

namespace Tylercd100\Laravel\Webhooks\Interfaces;

use Tylercd100\Laravel\Webhooks\Models\Webhook;

interface Webhookable
{
    /**
     * Called before sending. Must be exactly false to halt sending.
     *
     * @param Webhook $webhook
     * @return boolean
     */
    public function canSendWebhook(Webhook $webhook);

    /**
     * Returns an array
     * to use for the webhook payload
     * 
     * @param string $event_name
     * @return array
     */
    public function toWebhook($event_name);
}