<?php

namespace App;

use Illuminate\Notifications\Notifiable;
#use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use Notifications\ResetPasswordNotification;

class User extends Authenticatable
#class User extends Authenticatable implements MustVerifyEmail // <- update this line
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password', 'role_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // The User model
    public function role()
  	{
  		return $this->hasOne('App\Role', 'id', 'role_id');
  	}

  	public function hasRole($roles)
  	{
  		$this->have_role = $this->getUserRole();
  		// Check if the user is a root account
  		if($this->have_role->name == 'Root') {
  			return true;
  		}
  		if(is_array($roles)){
  			foreach($roles as $need_role){
  				if($this->checkIfUserHasRole($need_role)) {
  					return true;
  				}
  			}
  		} else{
  			return $this->checkIfUserHasRole($roles);
  		}
  		return false;
  	}

  	private function getUserRole()
  	{
  		return $this->role()->getResults();
  	}

  	private function checkIfUserHasRole($need_role)
  	{
  		return (strtolower($need_role)==strtolower($this->have_role->name)) ? true : false;
  	}

    /**
   * Get the articles that hasmany to the user.
   */
    public function articles()
    {
        return $this->hasMany('App\Article');
    }

    public function events()
    {
      return $this->hasMany('App\Event');
    }

    public function brand()
    {
      return $this->hasMany('App\Brand');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /*
    public function roles()
    {
      return $this->belongsToMany('App\Role')
                  ->withTimestamps(); //update created app, updated app relationship table
    }
    */
}
