<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher){}

    const CARS = [
        'Audi' => [
            'A1',
            'A3',
            'A4',
            'A5',
            'A6',
            'A7',
            'A8',
            'Q2',
            'Q3',
            'Q5',
            'Q7',
            'Q8',
            'TT',
            'R8',
        ],
        'BMW' => [
            'Serie 1',
            'Serie 2',
            'Serie 3',
            'Serie 4',
            'Serie 5',
            'Serie 6',
            'Serie 7',
            'X1',
            'X2',
            'X3',
            'X4',
            'X5',
            'X6',
            'X7',
            'Z4',
            'i3',
            'i8',
        ],
        'Mercedes' => [
            'Classe A',
            'Classe B',
            'Classe C',
            'Classe E',
            'Classe S',
            'Classe G',
            'Classe M',
            'Classe R',
            'Classe GL',
            'Classe GLK',
            'Classe GLA',
            'Classe GLC',
            'Classe GLE',
            'Classe GLS',
            'Classe GLE Coupé',
            'Classe GLC Coupé',
            'Classe S Coupé',
            'Classe S Cabriolet',
            'Classe E Coupé',
            'Classe E Cabriolet',
            'Classe CLA',
            'Classe CLS',
            'Classe SL',
            'Classe SLK',
            'Classe SLS',
            'Classe AMG GT',
            'Classe V',
            'Classe X',
            'Classe EQ',
        ],
        'Volkswagen' => [
            'Polo',
            'Golf',
            'Passat',
            'Tiguan',
            'Touran',
            'Sharan',
            'T-Roc',
            'T-Cross',
            'Arteon',
            'Up',
            'Beetle',
            'Scirocco',
            'Jetta',
            'CC',
            'Touareg',
            'Caddy',
            'Transporter',
            'Caravelle',
            'Multivan',
            'California',
            'Amarok',
            'ID.3',
            'ID.4',
            'ID.5',
            'ID.6',
            'ID.7',
            'ID.8',
            'ID.9',
            'ID.10',
        ],
        'Toyota' => [
            'Yaris',
            'Corolla',
            'Camry',
            'Auris',
            'Prius',
            'Avensis',
            'Verso',
            'RAV4',
            'Land Cruiser',
            'Hilux',
            'Proace',
            'GT86',
            'Supra',
            'Aygo',
            'C-HR',
            'Highlander',
            'Sienna',
            'Tacoma',
            'Tundra',
            '4Runner',
            'Sequoia',
            'Mirai',
            'Urban Cruiser',
            'iQ',
            'Verso-S',
            'Urban Cruiser',
            'Corolla Verso',
            'Verso-S',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
            'Corolla Sedan',
            'Corolla Hatchback',
            'Corolla GR Sport',
            'Corolla Trek',
            'Corolla GRMN',
            'Corolla Cross',
            'Corolla Touring Sports',
        ],
        'Ford' => [
            'Fiesta',
            'Focus',
            'Mondeo',
            'Kuga',
            'EcoSport',
            'Edge',
            'Puma',
            'Mustang',
            'Ranger',
            'Tourneo',
            'Transit',
            'GT',
            'Bronco',
            'Maverick',
            'F-150',
            'F-250',
            'F-350',
            'F-450',
            'F-550',
            'F-650',
            'F-750',
            'F-850',
            'F-950',
            'F-1050',
            'F-1150',
            'F-1250',
            'F-1350',
            'F-1450',
            'F-1550',
            'F-1650',
            'F-1750',
            'F-1850',
            'F-1950',
            'F-2050',
            'F-2150',
            'F-2250',
            'F-2350',
            'F-2450',
            'F-2550',
            'F-2650',
            'F-2750',
            'F-2850',
            'F-2950',
            'F-3050',
            'F-3150',
            'F-3250',
            'F-3350',
            'F-3450',
            'F-3550',
            'F-3650',
            'F-3750',
            'F-3850',
            'F-3950',
            'F-4050',
            'F-4150',
            'F-4250',
            'F-4350',
            'F-4450',
            'F-4550',
            'F-4650',
            'F-4750',
            'F-4850',
            'F-4950',
            'F-5050',
            'F-5150',
            'F-5250',
            'F-5350',
            'F-5450',
            'F-5550',
            'F-5650',
            'F-5750',
            'F-5850',
            'F-5950',
            'F-6050',
            'F-6150',
            'F-6250',
            'F-6350',
            ],
        'Fiat' => [
            '500',
            '500X',
            '500L',
            '500C',
            'Panda',
            'Tipo',
            'Punto',
            'Doblò',
            'Qubo',
            'Talento',
            'Ducato',
            'Fullback',
            '124 Spider',
            '500e',
            '500L Living',
            '500L Trekking',
            '500L Cross',
            '500L Wagon',
            '500L Urban',
            '500L City Cross',
            '500L S-Design',
            '500L S-Design Wagon',
            '500L S-Design City Cross',
            '500L S-Design Urban',
            '500L S-Design Cross',
            '500L S-Design Trekking',
            '500L S-Design Living',
            '500L S-Design',
            '500L S-Design Wagon',
            '500L S-Design City Cross',
            '500L S-Design Urban',
            '500L S-Design Cross',
            '500L S-Design Trekking',
            '500L S-Design Living',
            '500L S-Design',
            '500L S-Design Wagon',
            '500L S-Design City Cross',
            '500L S-Design Urban',
            '500L S-Design Cross',
            '500L S-Design Trekking',
            '500L S-Design Living',
            '500L S-Design',
            '500L S-Design Wagon',
            '500L S-Design City Cross',
            '500L S-Design Urban',
            '500L S-Design Cross',
            '500L S-Design Trekking',
            '500L S-Design Living',
            '500L S-Design',
            '500L S-Design Wagon',
            '500L S-Design City Cross',
            '500L S-Design Urban',
            '500L S-Design Cross',
            '500L S-Design Trekking',
            '500L S-Design Living',
            '500L S-Design',
            '500L S-Design Wagon',
            '500L S-Design City Cross',
            '500L S-Design Urban',
            '500L S-Design Cross',
            '500L S-Design Trekking',
            '500L S-Design'
            ],
        'Renault' => [
            'Clio',
            'Captur',
            'Megane',
            'Scenic',
            'Kadjar',
            'Talisman',
            'Koleos',
            'Twingo',
            'Zoe',
            'Espace',
            'Kangoo',
            'Trafic',
            'Master',
            'Alaskan',
            'Arkana',
            'Duster',
            'Fluence',
            'Kwid',
            'Laguna',
            'Latitude',
            'Lodgy',
            'Modus',
            'Safrane',
            'Symbol',
            'Thalia',
            'Wind',
            'Avantime',
            'Fuego',
            'Rodeo',
            'Vel Satis',
            'Express',
            'Rapid',
            'Rapid Spaceback',
            'Scala',
            'Talisman Estate',
            'Talisman Grandtour',
            'Twingo Z.E.',
            'Zoe Z.E.',
            'Kangoo Z.E.',
            'Master Z.E.',
            'Twizy',
            'Kangoo Express',
            'Kangoo Z.E. Van',
            'Kangoo Z.E. Maxi',
            'Kangoo Z.E. Maxi Crew',
            'Kangoo Z.E. Maxi Crew Van',
            'Kangoo Z.E. Maxi Van',
            'Kangoo Z.E. Van',
            'Kangoo Z.E. Maxi',
            'Kangoo Z.E. Maxi Crew',
            'Kangoo Z.E. Maxi Crew Van',
            'Kangoo Z.E. Maxi Van',
            'Kangoo Z.E. Van',
            'Kangoo Z.E. Maxi',
            'Kangoo Z.E. Maxi Crew',
            'Kangoo Z.E. Maxi Crew Van',
            'Kangoo Z.E. Maxi Van',
            'Kangoo Z.E. Van',
            'Kangoo Z.E. Maxi',
            'Kangoo Z.E. Maxi Crew',
            'Kangoo Z.E. Maxi Crew Van',
            'Kangoo Z.E. Maxi Van',
            'Kangoo Z.E. Van',
            'Kangoo Z.E. Maxi',
            'Kangoo Z.E. Maxi Crew',
            ],
        'Peugeot' => [
            '108',
            '208',
            '308',
            '508',
            '2008',
            '3008',
            '5008',
            'Rifter',
            'Traveller',
            'Partner',
            'Expert',
            'Boxer',
            'iOn',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            'e-Rifter',
            'e-Partner',
            'e-208',
            'e-2008',
            'e-Expert',
            'e-Traveller',
            'e-Boxer',
            ],
        'Citroen' => [
            'C1',
            'C3',
            'C4',
            'C5',
            'C3 Aircross',
            'C4 Cactus',
            'C4 Spacetourer',
            'C5 Aircross',
            'Berlingo',
            'SpaceTourer',
            'Jumpy',
            'Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-Jumpy',
            'e-Jumper',
            'AMI',
            'e-C4',
            'e-C4 Spacetourer',
            'e-Berlingo',
            'e-SpaceTourer',
            'e-J',
            ],
        ];

    const COLORS = [
        'Blanc',
        'Noir',
        'Gris',
        'Bleu',
        'Rouge',
        'Jaune',
        'Vert',
        'Orange',
        'Marron',
        'Beige',
        'Violet',
        'Rose',
        'Bleu clair',
        'Bleu foncé',
        'Rouge clair',
        'Rouge foncé',
        'Jaune clair',
        'Jaune foncé',
        'Vert clair',
        'Vert foncé',
        'Orange clair',
        'Orange foncé',
        'Marron clair',
        'Marron foncé',
        'Beige clair',
        'Beige foncé',
        'Violet clair',
        'Violet foncé',
        'Rose clair',
        'Rose foncé',
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::CARS as $brand => $models)
        {
            $numberOfModels = rand(5, 10); // Random number of models between 5 and 10
            $randomModels = array_rand($models, $numberOfModels); // Random models from the brand

            foreach ($randomModels as $model)
            {
                $matricule = chr(rand(65, 90)) . chr(rand(65, 90)) .'-'. rand(10, 99) . chr(rand(65, 90)) . chr(rand(65, 90));

                $car = new Car();
                $car->setBrand($brand);
                $car->setModel($models[$model]);
                $car->setColor(self::COLORS[array_rand(self::COLORS)]);
                $car->setMatricule($matricule);
                $manager->persist($car);
            }
        }

        $user = new User();
        $user->setEmail('maa@mail.com')
            ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstname('Maamoune')
            ->setLastname('Hassane')
        ;

        $manager->persist($user);

        // Create 10 users all with the same password 'password'
        for ($i = 0; $i < 10; $i++)
        {
            $isAdministrator = $faker->boolean(10); // 10% chance to be an administrator

            $user = new User();
            $user->setEmail($faker->email)
                 ->setPassword($this->passwordHasher->hashPassword($user, 'password'))
                 ->setRoles($isAdministrator ? ['ROLE_ADMIN'] : [])
                ->setFirstname($faker->firstName)
                ->setLastname($faker->lastName)
            ;

            $manager->persist($user);
        }

        $manager->flush();
    }
}
