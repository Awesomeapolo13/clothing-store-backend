<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class HealthCheckActionTest extends WebTestCase
{
    public function test_request_responded_successful_result(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/health-check');
        // Проверяет, является ли запрос успешным
        $this->assertResponseIsSuccessful();
        // Определим возвращает ли ответ json со статусом ok
        $jsonResult = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals('ok', $jsonResult['status']);
    }
}
