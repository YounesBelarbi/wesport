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

    public function token(string $type, User $user)
    {
        //check if user already has token for this type.
        $userToken = $this->checkUserHasToken($type, $user);
        $currentDate = new \DateTime();
        $token = $this->generateToken();

        if ($userToken) {
            // if yes,  replace and send it.
            $userToken->setExpirationDate($currentDate->modify('+1 month'));
            $userToken->setUpdatedAT(new \DateTime());
        } else {
            //if no, save new token for this user
            $userToken = new UserToken;
            $userToken->setType($type);
            $userToken->setUser($user);
            $userToken->setCreatedAt(new \DateTime());
            $userToken->setExpirationDate($currentDate->modify('+1 month'));
            $this->entityManager->persist($userToken);
        }

        $userToken->setToken($token);
        $this->entityManager->flush();
        return $token;
    }

    public function checkUserHasToken(string $type, User $user)
    {
        $userToken = $this->entityManager->getRepository(UserToken::class)->findOneBy([
            'user' => $user, 'type' => $type
        ]);
        return $userToken;
    }
    
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(128)), '+/', '-_'), '=');
    }
}
