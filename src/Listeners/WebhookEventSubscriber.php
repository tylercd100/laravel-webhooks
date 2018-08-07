<?php

namespace Tylercd100\Laravel\Webhooks\Listeners;

use Tylercd100\Laravel\Webhooks\Interfaces\SendsWebhook;
use Tylercd100\Laravel\Webhooks\Models\Webhook;
use Tylercd100\Laravel\Webhooks\Jobs\WebhookJob;
use Illuminate\Contracts\Support\Arrayable;

class WebhookEventSubscriber
{
    /**
     * Handles all events
     */
    public function onEvent($event) {
        if ($event instanceof SendsWebhook) {
            $name = $event->getWebhookEventName();
            $data = $event->toWebhook();
            if ($data instanceof Arrayable) {
                $data = $data->toArray();
            }
            foreach(Webhook::where(["event" => $name])->get() as $webhook) {
                dispatch(new WebhookJob($webhook, $data));
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
            'Tylercd100\Laravel\Webhooks\Listeners\WebhookEventSubscriber@onEvent'
        );
    }

}