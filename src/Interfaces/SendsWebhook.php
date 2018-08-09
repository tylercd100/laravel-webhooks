<?php

namespace Tylercd100\Laravel\Webhooks\Interfaces;

interface SendsWebhook
{
    /**
     * Returns the name of the webhook event
     *
     * @return string
     */
    public function getWebhookEventName();

    /**
     * Returns the webhookable data. Most likely an eloquent model
     *
     * @return Webhookable
     */
    public function getWebhookableData();
}