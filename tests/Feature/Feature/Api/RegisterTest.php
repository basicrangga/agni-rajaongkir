<?php

namespace Tests\Feature\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegisterSuccess()
    {
    	$data = [
    		'name'=>'Basic Rangga',
    		'email'=>'basic@rangga.biz.id',
    		'password'=>'basicrangga',
    		'password_confirmation'=>'basicrangga'
    	];

    	$this->json('POST','/api/register',$data)
    		->assertJsonStructure([
    			'data'=>[
    				'id','name','email','created_at','updated_at','api_token'
    			]
    		]);

    }

    public function testRequireData()
    {
    	$data = [
    		'name'=>'Basic Rangga',
    		'email'=>'basic@rangga.biz.id'
    	];

    	$this->json('POST','/api/register',$data)
    		->assertJson([
    			'password'=>['The password field is required.']
    		]);    	
    }
}
