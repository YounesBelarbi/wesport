<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\UserToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class TokenService
{
    private $entityManager;
    private $tokenGenerator;

    public function __construct(EntityManagerInterface $entityManager, TokenGeneratorInterface $tokenGenerator)
    {
        $this->entityManager = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
    }


    public function generateAndSaveToken(string $type, User $user)
    {
        //check if user already has token for this type.
        $userToken = $this->checkUserHasToken($type, $user);
        $currentDate = new \DateTime();
        $token = $this->tokenGenerator->generateToken();

        if ($userToken) {
            // if yes,  replace and send it.
            $userToken->setToken($token);
            $userToken->setExpirationDate($currentDate->modify('+1 month'));
            $userToken->setUpdatedAT(new \DateTime());
            $this->entityManager->flush();
        } else {
            //if no, save new token for this user
            $userToken = new UserToken;

            $userToken->setToken($token);
            $userToken->setType($type);
            $userToken->setUser($user);
            $userToken->setCreatedAt(new \DateTime());
            $userToken->setExpirationDate($currentDate->modify('+1 month'));
            $this->entityManager->persist($userToken);
            $this->entityManager->flush();
        }

        return $token;
    }

    public function checkUserHasToken(string $type, User $user)
    {
        $userToken = $this->entityManager->getRepository(UserToken::class)->findOneBy([
            'user' => $user, 'type' => $type
        ]);

        return $userToken;
    }
}
