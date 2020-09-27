# FoodApp Server

build on top of

* laravel [https://laravel.com/docs]
* voyager [https://voyager-docs.devdojo.com/]



## Setup
1. get some tea and move files to your server root dir whatever
2. set host's document root to `public` sub directory
3. setup composer in server root: https://getcomposer.org/download
4. make sure subdirs *cache*, *sessions* and *views* exist in `storage/framework`
5. install composer dependencies: `./composer.phar install`
6. copy *.env* from example and set up
	- you might have to generate an app key and jwt secrets for this
7. run laravel setup
	- `php artisan migrate`
	- `php artisan db:seed`
	- `php artisan voyager:install`
8. create admin user
	- replace getUser method in `vendor/tcg/voyager/src/Commands/AdminCommand.php` with the stuff further down
	- `php artisan voyager:admin -create`
9. log into admin
10. setup missing permissions
	- go to bread controller, edit roles bread. Set controller name to: `TCG\Voyager\Http\Controllers\VoyagerRoleController` (this relates to a laravel bug)
	- edit existing breads for `fs_log` and `fs_studies`, just open and save once (no changes, this generates permission entries)
	- go to roles, edit admin role, give all permissions fos fs_log and fs_studies
	
	



---


### vendor/tcg/voyager/src/Commands/AdminCommand.php

``` php
protected function getUser($create = false)
    {
        $username = $this->argument('username');

        $model = Auth::guard(app('VoyagerGuard'))->getProvider()->getModel();
        $model = Str::start($model, '\\');

        // If we need to create a new user go ahead and create it
        if ($create) {
            $name = $this->ask('Enter the admin name');
            $username = $this->ask('Enter the login name');
            $email  = $this->ask('Enter the email');
            $password = $this->secret('Enter admin password');
            $confirmPassword = $this->secret('Confirm Password');

            // Ask for email if there wasnt set one
            if (!$email) {
                $email = $this->ask('Enter the admin email');
            }
            
            if (!$username) {
                $username = $this->ask('Enter the admin login');
            }

            // Passwords don't match
            if ($password != $confirmPassword) {
                $this->info("Passwords don't match");

                return;
            }

            $this->info('Creating admin account');

            return call_user_func($model.'::create', [
                'name'     => $name,
                'username'     => $username,
                'email'    => $email,
                'password' => Hash::make($password),
            ]);
        }

        return call_user_func($model.'::where', 'username', $username)->firstOrFail();
    }
```
