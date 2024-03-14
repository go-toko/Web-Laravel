### Login using Google account API

https://console.cloud.google.com/apis/dashboard

Add this variable to the .env

http://go-toko.id/

```
GOOGLE_CLIENT_ID=342322140295-a87chkbaipbkomgln5be5d4k1itbdi83.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT=http://127.0.0.1:8000/login/google/callback
```

https://gotoko.radityafirmansyaputra.com

```
GOOGLE_CLIENT_ID=826082524204-i3ro0n5afaguala5oj2amcjkhc4sc0or.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=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
GOOGLE_REDIRECT=https://gotoko.radityafirmansyaputra.com/login/google/callback
```

new user will redirect to owner account, if u want to login as superadmin u can change value of role_id in users table
at database to 1.

-   1 is Admin
-   2 is Owner
-   3 is Cashier

#### Middleware

I was setting the middleware too at this branch, you can look at the RoleMiddleware, use `command+p` and type that
thing.

I just setting if the user not login, they can't just write down the url and entering the app. They will return to login
page.

### Notes

To saving file, please enable gd extension on Apache PHP
