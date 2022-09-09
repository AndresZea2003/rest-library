<?php

namespace Zea\RestLibrary\Message;

use Zea\RestLibrary\Contracts\Entity;
use Zea\RestLibrary\Entities\Status;
use Zea\RestLibrary\Entities\Payment;
use Zea\RestLibrary\Traits\StatusTrait;

class Response extends Entity
{
    use StatusTrait;

    protected array $response = [];

    public function __construct($data = [])
    {
        $this->loadEntity($data['status'], 'status', Status::class);
        $this->response = $data;
    }

    public function toArray(): array
    {
        return $this->arrayFilter([
            'status' => $this->status()->toArray(),
            'response' => $this->response,
        ]);
    }
}
