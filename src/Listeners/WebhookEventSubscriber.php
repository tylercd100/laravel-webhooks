<?php

namespace Tylercd100\Laravel\Webhooks\Listeners;

use Tylercd100\Laravel\Webhooks\Interfaces\SendsWebhook;
use Tylercd100\Laravel\Webhooks\Interfaces\Webhookable;
use Tylercd100\Laravel\Webhooks\Models\Webhook;
use Tylercd100\Laravel\Webhooks\Jobs\WebhookJob;
use Tylercd100\Laravel\Webhooks\Exceptions\WebhookException;

class WebhookEventSubscriber
{
    /**
     * Handles all events
     */
    public function handleNewEvent($event_name, $payload) {
        if (count($payload) > 0 && is_object($payload[0]) && $payload[0] instanceof SendsWebhook) {
            $event = $payload[0];
            $name = $event->getWebhookEventName();
            $data = $event->getWebhookableData();

            
            if ($data instanceof Webhookable) {
                if (!empty($data->toWebhook())) {
                    foreach(Webhook::where(["event" => $name])->get() as $webhook) {
                        dispatch(new WebhookJob($webhook, $data));
                    }
                }
            } else {
                throw new WebhookException("Expected ".get_class($data)." to be an instance of \Tylercd100\Laravel\Webhooks\Interfaces\Webhookable");
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
