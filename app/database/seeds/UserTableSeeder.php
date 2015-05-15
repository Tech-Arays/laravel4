<?php

class UserTableSeeder extends DatabaseSeeder
{
	public function run(){
		$users = [
			[
				"username"	=>  "baljeet",
				"password"	=>	"123456",
				"email"		=>	"baljeet.techarays@gmail.com"
			]
		];

		foreach ($users as $user) {
			User::create($user);
		}
	}		
}