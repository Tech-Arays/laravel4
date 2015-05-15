<?php

class UsersController extends \BaseController {

	/**
	 * function to show login form
	 * @return [type] [description]
	 */
	public function getLogin(){
		return View::make('users/login');
	}

	/**
	 * function to log users in
	 * @return [type] [description]
	 */
	public function postLogin(){	
    	$validator = $this->getValidator();
    	
    	if ($validator->passes()) {
        	
        	$credentials = $this->getLoginCredentials();
        	if(Auth::attempt($credentials)){
        		return Redirect::route('users/profile');
        	} else{
        		return Redirect::back()->withError("Credentials invalid.");
        	}

      	} else {
        	echo "Validation failed!";
      		return Redirect::back()->withError('Validation Error Here!')->withInput();
  		}

	}

	/**
	 * keeping validations seprate from logic
	 * @return [type] [description]
	 */
	protected function getValidator(){
	    return Validator::make(Input::all(), [
	      "username" => "required",
	      "password" => "required"
	    ]);
	}


  	protected function getLoginCredentials()
  	{
    	return array(
	      "username" => Input::get("username"),
	      "password" => Input::get("password")
      	);
  	}

  	public function getProfile(){
  		return View::make('users/profile');
  	}

  	/*------------------------------------------*/
  	/*------------------------------------------*/
  	
  	/*starting up password reminder stuff*/
  	
  	/*request section*/
  	public function getRequest()
	{ 
	  return View::make("users/request");
	}

  	public function postRequest(){

		$response = $this->getPasswordRemindResponse();
	    
	    if ($this->isInvalidUser($response)) {
	      return Redirect::back()
	        ->withInput()
	        ->with("error", Lang::get($response));
	    }
	    
	    return Redirect::back()->with("status", Lang::get($response));
  	}

	  
	protected function getPasswordRemindResponse()
	{
	  return Password::remind(Input::only("email"));
	}
	  
	protected function isInvalidUser($response)
	{
	  return $response === Password::INVALID_USER;
	}
  	 
  	/*------------------------------------------*/
  	/*------------------------------------------*/
  	
  	/* reset section*/
  	public function getReset($token)
	{
	  return View::make("users/reset", compact("token"));
	}

  	public function postReset($token){
  		  $credentials = Input::only(
	      "email",
	      "password",
	      "password_confirmation"
	    ) + compact("token");
	 
	    $response = $this->resetPassword($credentials);
	 
	    if ($response === Password::PASSWORD_RESET) {
	      return Redirect::route("users/profile");
	    }
	 
	    return Redirect::back()
	      ->withInput()
	      ->with("error", Lang::get($response));
  	}
	 
	protected function resetPassword($credentials)
	{
	  return Password::reset($credentials, function($user, $pass) {
	    $user->password = Hash::make($pass);
	    $user->save();
	  });
	}

	public function logout()
	{
	  Auth::logout();
	  
	  return Redirect::route("users/login");
	}
}
