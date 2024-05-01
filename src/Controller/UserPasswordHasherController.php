<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsController]
class UserPasswordHasherController extends AbstractController
{

    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher){}

    public function __invoke($data, Request $request)
    {
        $requestData = json_decode($request->getContent(), true);

        if (isset($requestData['password']) && $requestData['password'])
        {
            $data->setPassword($this->passwordHasher->hashPassword($data, $requestData['password']));
        }

        return $data;
    }

}