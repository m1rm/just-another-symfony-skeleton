<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();
        $client->request('GET', '/hello/tester');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello tester!');
    }
}
