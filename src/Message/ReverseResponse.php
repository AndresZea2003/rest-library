<?php

namespace Zea\RestLibrary\Message;

use Zea\RestLibrary\Contracts\Entity;
use Zea\RestLibrary\Entities\Status;
use Zea\RestLibrary\Entities\Transaction;
use Zea\RestLibrary\Traits\StatusTrait;

class ReverseResponse extends Entity
{
    use StatusTrait;

    protected ?Transaction $payment = null;

    public function payment(): ?Transaction
    {
        return $this->payment;
    }

    public function __construct($data = [])
    {
        $this->loadEntity($data['status'] ?? null, 'status', Status::class);
        $this->loadEntity($data['payment'] ?? null, 'payment', Transaction::class);
    }

    public function toArray(): array
    {
        return $this->arrayFilter([
            'status' => $this->status()->toArray(),
            'payment' => $this->payment() ? $this->payment()->toArray() : null,
        ]);
    }
}
