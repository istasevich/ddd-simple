<?php

namespace App\Application\Http\Controllers;

use App\Application\Commands\User\UserRegisterCommand;
use App\Domain\User\Services\UserRegistrationServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserRegistrationServiceInterface
     */
    private $registrationService;
    
    /**
     * UserController constructor.
     *
     * @param UserRegistrationServiceInterface $registrationService
     */
    public function __construct(UserRegistrationServiceInterface $registrationService)
    {
        $this->registrationService = $registrationService;
    }
    
    /**
     * @param Request $request
     * @return mixed
     * @throws \Exception
     */
    public function register(Request $request)
    {
        $command = new UserRegisterCommand(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );
    
        $validation = $command->validate();
    
        if ($validation->fails()) {
            throw new \Exception($validation->getMessageBag(), 400);
        }
        
        return [
            'token' => $this->registrationService->execute($command)
        ];
    }
}