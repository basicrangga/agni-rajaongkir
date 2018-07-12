<?php

namespace Tests\Feature\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $userAvailable = User::where('email','basic@rangga.biz.id')->first();
        if($userAvailable)
        {
            $userAvailable->delete();    
        }

        $user = factory(\App\User::class)->create(['email'=>'basic@rangga.biz.id']);
        $token = $user->generateToken();
        $headers = ['Authorization'=>"Bearer $token"];
        $idProvince = 2;

        $this->json('GET',"/api/search/provinces?id=$idProvince",[],$headers)
            ->assertJsonStructure([
                'data'=>[
                    'id','province_id','province'
                ]
            ]);

        $this->json('post', '/api/logout', [], $headers)->assertStatus(200);

        $user = User::find($user->id);
        $this->assertEquals(null,$user->api_token);
    }

    public function testAccessWithNullToken()
    {
        $userAvailable = User::where('email','basic@rangga.biz.id')->first();
        if($userAvailable)
        {
            $userAvailable->delete();    
        }

        $user = factory(\App\User::class)->create(['email'=>'basic@rangga.biz.id']);
        $token = $user->generateToken();
        $headers = ['Authorization'=>"Bearer $token"];

        $user->api_token = null;
        $user->save();
        
        $this->json('GET','/api/search/provinces?id=2',[],$headers)->assertStatus(401);
    }

}
