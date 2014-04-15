<?php

namespace ModulaR\modularBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminControllerTest extends WebTestCase
{
    public function testAdmin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/admin');
    }

    public function testConfig()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/config');
    }

}
