<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\UserFactory;
use App\Story\UserStory;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserApiTest extends ApiTestCase
{
    use ResetDatabase, Factories;

    private string $accessToken = '';

    public function setUp(): void
    {
        UserStory::load();

        $this->testLogin();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testCreateUser(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/users', ['json' => [
            'email' => 'test@test.com',
            'password' => 'Passw0rd',
            'firstname' => 'Test',
            'lastname' => 'Test',
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        $this->assertJsonContains([
            'email' => 'test@test.com',
            'firstname' => 'Test',
            'lastname' => 'Test',
            'roles' => ['ROLE_USER'],
        ]);
    }

    public function testLogin(): void
    {
        $client = static::createClient();
        $response = $client->request('POST', '/api/login', ['json' => [
            'username' => 'maamoune@mail.com',
            'password' => 'Passw0rd',
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'token' => $response->toArray()['token'],
        ]);

        // Stocker le token dans la propriété $accessToken
        $this->accessToken = $response->toArray()['token'];
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testGetCollection(): void
    {
        static::createClient();

        static::createClient()->request('GET', '/api/users', ['headers' => [
            'Authorization' => 'Bearer '.$this->accessToken]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/User',
            '@id' => '/api/users',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 24,
            'hydra:member' => [],
        ]);
    }

    // test GetItem

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testGetUser(): void
    {
        $client = static::createClient();

        $user = UserFactory::repository()->findOneBy([], ['id' => 'ASC']);
        $id = $user->getId(); // the first user is probably Maamoune

        $client->request('GET', '/api/users/'.$id, ['headers' => [
            'Authorization' => 'Bearer '.$this->accessToken]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            '@id' => '/api/users/'.$id,
            '@type' => 'User',
            'email' => 'maamoune@mail.com',
            'firstname' => 'Maamoune',
            'lastname' => 'Hassane',
            'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
        ]);
    }


    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testPutUser(): void
    {
        $client = static::createClient();

        $user = UserFactory::repository()->findOneBy([], ['id' => 'ASC']);
        $id = $user->getId(); // the first user is probably Maamoune

        $client->request('PUT', '/api/users/'.$id, ['json' => [
            'email' => 'm.hassane@mail.com',
            'password' => 'Passw0rd',
            'firstname' => 'Martin',
            'lastname' => 'Hassane',
        ]]);

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            'email' => 'm.hassane@mail.com',
            'firstname' => 'Martin',
            'lastname' => 'Hassane',
            'roles' => ['ROLE_USER'],
        ]);
    }

}
