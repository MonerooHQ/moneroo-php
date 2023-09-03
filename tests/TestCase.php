<?php

namespace Moneroo\Tests;


use Faker\Factory;
use Moneroo\Factories\HttpFactory;
use Moneroo\Factories\ValidatorFactory;
use Moneroo\Payment;
use Moneroo\Payout;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected  $faker;
    protected HttpFactory $httpFactory;
    protected ValidatorFactory $validatorFactory;

    protected array $monerooClasses;

  public function setUp(): void
  {
    parent::setUp();

    $this->faker = Factory::create();
    $this->httpFactory = new HttpFactory();
    $this->validatorFactory = new ValidatorFactory();

    $this->monerooClasses = [
        Payment::class,
        Payout::class,
    ];

    $this->publicKey = $this->faker->md5();
    $this->secretKey = $this->faker->md5();

  }
}
