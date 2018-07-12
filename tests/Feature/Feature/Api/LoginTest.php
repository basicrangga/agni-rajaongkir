<?php

namespace Tests\Feature\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{

    public function testNoCredential()
    {
    	$this->json('POST','api/login')
    		->assertJson([
                'email'=>['The email field is required.'],
                'password'=>['The password field is required.']
            ]);
    }

    public function testValidUser()
    {
        $user = factory(\App\User::class)->create([
            'email' => 'basic@rangga.biz.id',
            'password' => bcrypt('basicrangga'),
        ]);

        $created = \App\User::where('email','basic@rangga.biz.id')->first();

    	$data = ['email' => 'basic@rangga.biz.id', 'password' => 'basicrangga'];

    	$this->json('POST','api/login',$data)
    		->assertJsonStructure([
    			'data'=>[
                    'id','name','email','created_at','updated_at','api_token'
                ]
    		]);
    }

}
