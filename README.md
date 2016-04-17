# l2p

(Make sure you already have composer installed)

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
localhost/(your-directory)/l2p/public/rest/auth/requestUserCode
```

This will request L2P server for device code, user code and all other necessary things and after successfull execution, this will redirect you to verification url.

You can use this url to check whether user verify the app or not.

```
http://localhost/(your-directory)/l2p/public/rest/auth/verifyRequest
```

If user verified the app then you will get the access token as a result of this request.

After then if you request this url, it will give you the course list
```
http://localhost/(your-directory)/l2p/public/rest/course
```
