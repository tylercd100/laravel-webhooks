<?php

namespace Tylercd100\Laravel\Webhooks\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tylercd100\Laravel\Webhooks\Models\Webhook;
use Tylercd100\Laravel\Webhooks\Exceptions\WebhookException;
use GuzzleHttp\Client;

class WebhookJob implements ShouldQueue
{
    use Queueable;

    protected $webhook;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @param  Webhook  $webhook
     * @return void
     */
    public function __construct(Webhook $webhook, $data)
    {
        $this->webhook = $webhook;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();
        try {
            $response = $client->post($this->webhook->target_url, [
                "json" => $this->data
            ]);
        } catch (Exception $e) {
            throw new WebhookException("Webhook #{$this->webhook->id} could not be delivered: ".$e->getMessage(), $e->getCode(), $e);
        }
    }
}
