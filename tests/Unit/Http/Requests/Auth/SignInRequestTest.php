<?php

namespace Tests\Unit\Http\Requests\Auth;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Requests\Auth\SignInRequest;

class SignInRequestTest extends TestCase
{
    /**
     * Test case: Validate Request Success
     *
     * @return void
     */
    public function testSignInRequestRuleShouldSuccess()
    {
        $signInRequest = new SignInRequest();
        $currentRules = $signInRequest->rules();

        $expectedRules = [
            'email' => 'required|string|email|max:127',
            'password' => 'required|string|min:6',
        ];
        $this->assertEquals($currentRules, $expectedRules);
    }
}
