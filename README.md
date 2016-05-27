# l2p

-(Make sure you already have composer installed and make sure you don't commit your client id)

First, Add your client id in :

```
l2p/config/l2pconfig.php
```

Then go to your project root directory(l2p) and type:
```
composer update
```

and then type again:

```
php artisan migrate
```
It will create necessary tables in database


Then you need to execute this url:

```
localhost/(your-directory)/l2p/public/request_user_code
```

This will request L2P server for device code, user code and all other necessary things and after successfull execution, this will redirect you to verification url.

If user verified the app then you will get the access token as a result of this request.

We are saving user device code in cookie and related access token in database in order to identify user later in our system.

After then if you request this url, it will give you the course list
```
http://localhost/(your-directory)/courses
```
Every time our application starts, it should send get request to ```/authenticate``` url to check if user has authorized app.
It will return ```true``` or ```false``` depending on the result.

if it returns ```true``` we should proceed application further and show ```logout``` button. Else we should show user ```login``` button.
Upon ```login``` button click, we should send request to /request_user_code url.

For Mac and Windows:

First run this command in terminal to generate a key
```
php artisan key:generate
```
Then use this command to run server

```
php artisan serve
```

