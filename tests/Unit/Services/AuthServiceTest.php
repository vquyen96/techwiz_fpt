<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\AuthService;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\User;

class AuthServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSignInShouldSuccess()
    {
        $credentials = [
            'email' => 'admin@hblab.co.jp',
            'password' => 'Admin@123'
        ];

        $sampleToken = 'xxxx';

        \Auth::shouldReceive('attempt')
            ->with($credentials)
            ->andReturn($sampleToken);

        \Auth::shouldReceive('user')
            ->andReturn(new User());
        
        $authService = new AuthService();
        $response = $authService->signIn($credentials);

        $this->assertEquals($response['access_token'], $sampleToken);
    }

    public function testSignInShouldFail()
    {
        $credentials = [
            'email' => 'admin@hblab.co.jp',
            'password' => 'admin123'
        ];
        
        \Auth::shouldReceive('attempt')
            ->with($credentials)
            ->andReturn(null);

        $this->expectException(HttpException::class);
        
        $authService = new AuthService();
        $response = $authService->signIn($credentials);
    }

    public function testGetMyInfoShouldSuccess()
    {
        $user = new User();
        \Auth::shouldReceive('user')
                ->once()
                ->andReturn($user);
        
        $authService = new AuthService();
        $responseData = $authService->getMyInfo();

        $this->assertEquals($responseData['user'], $user->getBasicInfo());
    }

    public function testSignOutShouldSuccess()
    {
        \Auth::shouldReceive('logout');
        $this->assertTrue(true);
    }
}
