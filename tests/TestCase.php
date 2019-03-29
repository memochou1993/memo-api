<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        //
    }

    protected function getMessage($response)
    {
        $response = $response->getContent();

        return json_decode($response)->message ?? json_decode($response);
    }

    protected function dd($response)
    {
        dd($this->getMessage($response));
    }

    protected function dump($response)
    {
        dump($this->getMessage($response));
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        //
    }
}
