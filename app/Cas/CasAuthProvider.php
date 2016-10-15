<?php

namespace cas;

use Auth;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\GenericUser;

class CasAuthProvider implements UserProvider {

    protected $cas_host = "ostec.uestc.edu.cn";
    protected $cas_context = "authcas";
    protected $cas_port = 443;
    protected $url = "https://ostec.uestc.edu.cn/authcas/login?service=http://202.115.16.82:8000/dologin";
    protected $attributes;

    public function __construct()
    {
      //        $cas_host = \Config::get('app.cas_host');
              $cas_host = $this->cas_host;
              //dump($cas_host);
      //        $cas_context = \Config::get('app.cas_context');
              $cas_context = $this->cas_context;
      //        $cas_port = \Config::get('app.cas_port');
              $cas_port = $this->cas_port;
              \phpCAS::setDebug();
              \phpCAS::client(CAS_VERSION_2_0, $cas_host, $cas_port, $cas_context);
              \phpCAS::setNoCasServerValidation();
              if(!\phpCAS::forceAuthentication()){
                echo "authentication failed";
              }
            //  Auth::loginUsingId($_SESSION["phpCAS"]["attributes"]["name"]);
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed  $id
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveById($id) {
        return $this->casUser();
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array  $credentials
     * @return \Illuminate\Auth\UserInterface|null
     */
    public function retrieveByCredentials(array $credentials) {
        return $this->casUser();
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  \Illuminate\Auth\UserInterface  $user
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(Authenticatable $user, array $credentials) {
        return true;
    }

    protected function casUser() {


        if (\phpCAS::isAuthenticated()) {
            $attributes = array(
              'id' => $_SESSION["phpCAS"]["attributes"]["userId"],
              'name' => $_SESSION["phpCAS"]["attributes"]["name"],
            );
            return new GenericUser($attributes);
        } else {
            //\phpCAS::setServerURL(\Config::get('app.url'));
            if(!\phpCAS::forceAuthentication()){
              echo "authentication failed";
            }
        }
        return null;
    }

    /**
     * Needed by Laravel 4.1.26 and above
     */
    public function retrieveByToken($identifier, $token) {
        return new \Exception('not implemented');
    }

    /**
     * Needed by Laravel 4.1.26 and above
     */
    public function updateRememberToken(Authenticatable $user, $token) {
        return new \Exception('not implemented');
    }

    /**
    *indentify if a user is authenticated
    */

    public function guest()
    {

              if (Auth::user()) {

                  return false;

              }
              return true;
    }

    public function check()
    {
      if (Auth::user()) {


        return true;
      }
      return false;
    }


    public function user()
    {
              if (\phpCAS::isAuthenticated()) {
                  $attributes = array(
                     'id' => \phpCAS::getAttribute('id'),
                      'name' => \phpCAS::getAttribute('name'),
                      'userType'=> \phpCAS::getAttribute('userType'),
                      'email'=> \phpCAS::getAttribute('email'),

                  );

                  return new GenericUser($attributes);

              } else {
                  \phpCAS::forceAuthentication();
              }
              return null;
    }


}

?>
