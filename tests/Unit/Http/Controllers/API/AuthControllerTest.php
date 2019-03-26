<?php

namespace Tests\Unit\Controllers\API;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\AuthServiceInterface;
use App\Http\Controllers\API\AuthController;
use App\Services\AuthService;
use App\Http\Requests\Auth\SignInRequest;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSignInSuccessfully()
    {
        $credentials = [
            'email' => 'admin@hblab.co.jp',
            'password' => 'Admin@123'
        ];
        $request = \Mockery::mock(SignInRequest::class);

        $request->shouldReceive('only')->andReturn($credentials);

        $sample = [
            'access_token' => 'abc',
        ];
        $mockAuthService = \Mockery::mock(AuthServiceInterface::class);
        $mockAuthService->shouldReceive('signIn')
                        ->andReturn($sample);
        
        $authController = new AuthController($mockAuthService);
        $response = $authController->signIn($request);

        $this->assertEquals($response->getData()->access_token, $sample['access_token']);
    }

    public function testGetMeShouldSuccess()
    {
        $sampleUser = new User();

        $mockAuthService = \Mockery::mock(AuthServiceInterface::class);
        $mockAuthService->shouldReceive('getMyInfo')
                ->andReturn($sampleUser);
        
        $authController = new AuthController($mockAuthService);
        $response = $authController->me();

        $this->assertEquals(200, $response->status());
    }

    public function testSignOutShouldSuccess()
    {
        $mockAuthService = \Mockery::mock(AuthServiceInterface::class);
        $mockAuthService->shouldReceive('signOut');
     
        $authController = new AuthController($mockAuthService);
        $response = $authController->signOut();

        $this->assertEquals(204, $response->status());
    }
}
