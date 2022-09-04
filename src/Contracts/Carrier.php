<?php

namespace Zea\RestLibrary\Contracts;

use Zea\RestLibrary\Helpers\Settings;
use Zea\RestLibrary\Message\CollectRequest;
use Zea\RestLibrary\Message\RedirectInformation;
use Zea\RestLibrary\Message\RedirectRequest;
use Zea\RestLibrary\Message\RedirectResponse;
use Zea\RestLibrary\Message\ReverseResponse;
use Zea\RestLibrary\Message\ProcessRequest;
use Zea\RestLibrary\Message\ProcessResponse;

abstract class Carrier
{
    protected Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    abstract public function process(ProcessRequest $processRequest): ProcessResponse;

    abstract public function request(RedirectRequest $redirectRequest): RedirectResponse;

    abstract public function query(string $requestId): RedirectInformation;

    abstract public function collect(CollectRequest $collectRequest): RedirectInformation;

    abstract public function reverse(string $transactionId): ReverseResponse;
}
