Hi {{!is_null($user->employee)?$user->employee->givenName:''}},
This is your Login Account for GX Employee App.

Account : {{$user->email}}
Password : {{$firstPassword}}

Please make sure to change your password after you have successfully logged in to the application for your security.