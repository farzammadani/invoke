<?php

namespace App\Context\Job\Domain;

class JobDefinition
{
    public string $name;
    public string $schedule;
    public string $url;
    public string $method;
    public array $headers;
    public array $payload;
    public bool $enabled;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->schedule = $data['schedule'];
        $this->url = $data['url'];
        $this->method = $data['method'];
        $this->headers = $data['headers'] ?? [];
        $this->payload = $data['payload'] ?? [];
        $this->enabled = $data['enabled'] ?? true;
    }
}
