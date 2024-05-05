<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\CarFactory;
use App\Factory\ReservationFactory;
use App\Factory\UserFactory;
use App\Story\CarStory;
use App\Story\ReservationStory;
use App\Story\UserStory;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReservationApiTest extends ApiTestCase
{
    use ResetDatabase, Factories;
    private string $accessToken = '';

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function setUp(): void
    {
        UserStory::load();
        CarStory::load();
        ReservationStory::load();

        $client = static::createClient();
        $response = $client->request('POST', '/api/login', ['json' => [
            'username' => 'maamoune@mail.com',
            'password' => 'Passw0rd',
        ]]);

        if ($response->getStatusCode() === 200)
        {
            $this->accessToken = $response->toArray()['token'];
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testUserReservations(): void
    {
        $user = UserFactory::repository()->findOneBy([], ['id' => 'ASC']);
        $id = $user->getId();

        static::createClient()->request('GET', "/api/users/$id/reservations", $this->getAuthHeaders());

        $this->assertResponseIsSuccessful();

        $this->assertJsonContains([
            '@context' => '/api/contexts/User',
            "@id" =>  "/api/users/$id/reservations",
            "@type" => "hydra:Collection",
        ]);

    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testCreateReservation(): void
    {
        $car = CarFactory::repository()->findOneBy([], ['id' => 'ASC']);
        $user = UserFactory::repository()->findOneBy([], ['id' => 'ASC']); // this is probably Maamoune

        $client = static::createClient();
        $client->request('POST', '/api/reservations', ['json' => [
            'startDate' => '2022-12-12',
            'endDate' => '2022-12-15',
            'car' => $car->getId(),
        ], 'headers' => [ 'Authorization' => 'Bearer ' . $this->accessToken ]]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(201);

        $this->assertJsonContains([
            '@context' => '/api/contexts/Reservation',
            "@type" => "Reservation",
            "user" =>  [
                "@id" => "/api/users/{$user->getId()}",
                "@type" => "User",
                "id" => $user->getId(),
                "email" => $user->getEmail(),
                "firstname" => $user->getFirstname(),
                "lastname" => $user->getLastname(),
              ],
            "startDate" => "2022-12-12",
            "endDate" => "2022-12-15",
            "car" => [
                "@id" => "/api/cars/{$car->getId()}",
                "@type" => "Car",
                "id" => $car->getId(),
                "brand" => $car->getBrand(),
                "model" => $car->getModel(),
                "matricule" => $car->getMatricule(),
                "color" => $car->getColor(),
            ],
            'status' => 1,
        ]);
    }


    //test reservation Car is not available

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testReservationCarNotAvailable() : void
    {
        $reservationExist = ReservationFactory::repository()->findOneBy([], ['id' => 'ASC']);

        $client = static::createClient();
        $client->request('POST', '/api/reservations', ['json' => [
            'startDate' => $reservationExist->getStartDate()->format('Y-m-d'),
            'endDate' => $reservationExist->getEndDate()->format('Y-m-d'),
            'car' => $reservationExist->getCar()->getId(),
        ], 'headers' => [ 'Authorization' => 'Bearer ' . $this->accessToken ]]);

        $this->assertResponseStatusCodeSame(400);

        $this->assertJsonContains([
            "type" => "business.logic.violation",
            "violations" => [
            "propertyPath" => "car",
            "title" => "Car not available for the given period",
            "parameters" => [
                "{{ carId }}" => $reservationExist->getCar()->getId(),
                "{{ startDate }}" => $reservationExist->getStartDate()->format('Y-m-d'),
                "{{ endDate }}" => $reservationExist->getEndDate()->format('Y-m-d')
            ],
            "type" => "entity.not_available",
            "template" => "The car with id {{ carId }} is not available for the period from {{ startDate }} to {{ endDate }}."
            ]
        ]);
    }

    private function getAuthHeaders(): array
    {
        return [
            'headers' => [ 'Authorization' => 'Bearer ' . $this->accessToken ]
        ];
    }
}
