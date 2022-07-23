<?php

namespace App\Api\Action\User;

use App\Service\User\UserRegisterService;

class Register 
{
    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    public function __invoke(Request $request): User
    {
        return $this->userRegisterService->create($request);
    }

}


?>