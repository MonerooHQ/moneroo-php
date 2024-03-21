<?php

namespace Moneroo\Tests;

use Moneroo\Configs\Config;
use Moneroo\Exceptions\InvalidPayloadException;
use Moneroo\Moneroo;
use Moneroo\Payment;
use Moneroo\Payout;
use PHPUnit\Framework\TestCase;

class MonerooTest extends TestCase
{
    /**
     * It should construct a Moneroo object.
     *
     * @test
     */
    public function it_should_construct_a_moneroo_object(): void
    {
        $secretKey = 'secret-key';

        $moneroo = new Moneroo($secretKey, false);

        $this->assertEquals($secretKey, $moneroo->secretKey);
        $this->assertEquals(Config::BASE_URL, $moneroo->baseUrl);
    }

    /**
     * It should construct a Moneroo object in dev mode with custom base url.
     *
     * @test
     */
    public function it_should_construct_a_moneroo_object_in_dev_mode_with_custom_base_url(): void
    {
        $secretKey = 'secret-key';
        $customUrl = 'httpd://custom-url.dev';

        $moneroo = new Moneroo($secretKey, true, $customUrl);

        $this->assertEquals($customUrl, $moneroo->baseUrl);
    }

    /**
     * It should throw an exception for empty secret key.
     *
     * @test
     */
    public function it_should_thrown_an_exception_for_empty_secret_key(): void
    {
        $this->expectException(InvalidPayloadException::class);
        $this->expectExceptionMessage('Secret key is not set or not a string.');

        new Moneroo('', '');
    }

    /**
     * Payment and Payout classes should extend Moneroo class.
     *
     * @test
     */
    public function payment_and_payout_classes_should_extend_moneroo_class(): void
    {
        $payment = Payment::class;
        $payout = Payout::class;

        $this->assertTrue(is_subclass_of($payment, Moneroo::class));
        $this->assertTrue(is_subclass_of($payout, Moneroo::class));
    }
}
