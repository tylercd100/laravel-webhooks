<?php

namespace Tylercd100\Laravel\Webhooks\Listeners;

use Tylercd100\Laravel\Webhooks\Interfaces\SendsWebhook;
use Tylercd100\Laravel\Webhooks\Models\Webhook;
use Tylercd100\Laravel\Webhooks\Jobs\WebhookJob;

class WebhookEventSubscriber
{
    /**
     * Handles all events
     */
    public function handleNewEvent($name, $payload) {
        if (count($payload) > 0 && is_object($payload[0]) && $payload[0] instanceof SendsWebhook) {
            $event = $payload[0];
            $name = $event->getWebhookEventName();
            $data = $event->getWebhookableData();

            if (!empty($data)) {
                foreach(Webhook::where(["event" => $name])->get() as $webhook) {
                    dispatch(new WebhookJob($webhook, $data));
                }
            }
        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            '*',
            'Tylercd100\Laravel\Webhooks\Listeners\WebhookEventSubscriber@handleNewEvent'
        );
    }
}
