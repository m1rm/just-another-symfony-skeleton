<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldControllerTest extends WebTestCase
{
    public function testIndex() {
        $this->createClient();
        $response = $this->getClient()->request('GET', '/hello/tester');
        $this->assertResponseStatusCodeSame(200);

        $greeting = $response->getNode(0)->nodeValue;

        $this->assertSame('Hello tester!', $greeting);
    }

}