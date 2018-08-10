<?php

namespace Tylercd100\Laravel\Webhooks\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tylercd100\Laravel\Webhooks\Exceptions\WebhookException;
use Tylercd100\Laravel\Webhooks\Interfaces\Webhookable;
use Tylercd100\Laravel\Webhooks\Models\Webhook;

class WebhookJob implements ShouldQueue
{
    use Queueable;

    /**
     * The registered Webhook model
     *
     * @var Webhook
     */
    protected $webhook;

    /**
     * The payload
     *
     * @var Webhookable
     */
    protected $payload;

    /**
     * Create a new job instance.
     *
     * @param  Webhook  $webhook
     * @return void
     */
    public function __construct(Webhook $webhook, Webhookable $payload)
    {
        $this->webhook = $webhook;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->canSend()) {
            $this->send();
        }
    }

    public function send()
    {
        $client = new Client();
        try {
            $response = $client->post($this->webhook->target_url, [
                "json" => $this->payload->toWebhook($this->webhook->event),
            ]);
        } catch (Exception $e) {
            throw new WebhookException("Webhook #{$this->webhook->id} could not be delivered: ".$e->getMessage(), $e->getCode(), $e);
        }
    }

    protected function canSend()
    {
        return $this->payload->canSendWebhook($this->webhook);
    }
}
