<?php

namespace Zea\RestLibrary\Contracts;

use Zea\RestLibrary\Helpers\Settings;
use Zea\RestLibrary\Message\CollectRequest;
use Zea\RestLibrary\Message\RedirectInformation;
use Zea\RestLibrary\Message\ReverseResponse;
use Zea\RestLibrary\Message\ProcessRequest;
use Zea\RestLibrary\Message\ProcessResponse;
use Zea\RestLibrary\Message\Response;
use Zea\RestLibrary\Message\QueryResponse;

abstract class Carrier
{
    protected Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    abstract public function process(ProcessRequest $processRequest): ProcessResponse;

    abstract public function query(string $internalReference): QueryResponse;

    abstract public function collect(CollectRequest $collectRequest): RedirectInformation;

    abstract public function reverse(array $reverseRequest): ReverseResponse;

    abstract public function information(array $informationRequest): Response;
}
