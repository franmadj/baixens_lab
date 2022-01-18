<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
	
	

	public static function isLogged()
	{
		if(Session::has('user_id'))
			return true;
		else
			return false;
	}

	public static function isAdmin()
	{
		if(Session::get('user_type') > 1)
			return true;
		else
			return false;
	}

        public function pedido(){
            return $this->hasMany('Pedido', 'idSolicitadoPor');
        }

}
