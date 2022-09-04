<?php

namespace Zea\RestLibrary\Entities;

use Zea\RestLibrary\Contracts\Entity;

class Discount extends Entity
{
    protected string $code;
    protected string $type;
    protected float $amount;
    protected float $base;
    protected float $percent;

    public function __construct($data = [])
    {
        $this->load($data, ['code', 'type', 'amount', 'base', 'percent']);
    }

    public function code(): string
    {
        return $this->code;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function amount(): float
    {
        return $this->amount;
    }

    public function base(): float
    {
        return $this->base;
    }

    public function percent(): float
    {
        return $this->percent;
    }

    public function toArray(): array
    {
        return $this->arrayFilter([
            'code' => $this->code(),
            'type' => $this->type(),
            'amount' => $this->amount(),
            'base' => $this->base(),
            'percent' => $this->percent(),
        ]);
    }
}
