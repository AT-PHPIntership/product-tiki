## Send Mail Resetpassword Api

### `POST` Send Mail Resetpassword
```
/api/password/reset
```
Post email
#### Request Headers
| Key | Value | 
|---|---|
| Accept | application/json

#### Request Body
| Key | Value | Description |
|---|---|---|
| email | string | email registered in database |

#### Response

* _Success_
``` json
{
    "result": {
        "message": "We have e-mailed your password reset link!"
    },
    "code": 200
}
```

* _Error_
``` json
{
    "error": {
        "message": "We can't find a user with that e-mail address.",
        "request": {
            "email": "admin@test.com"
        }
    },
    "code": 404
}
```

* _Error Validation_
``` json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email must be a valid email address."
        ]
    },
    "code": 422,
    "request": {
        "email": "admin@"
    }
}
```

### `PUT` Resetpassword
```
/api/password/reset
```
Put password new
#### Request Headers
| Key | Value | 
|---|---|
| Accept | application/json

#### Request Body
| Key | Value | Description |
|---|---|---|
|token | string | confirm token |
|email | string | confirm email |
|password | string | password new |
|password_confirmation | string | confirm password new |

#### Response

* _Success_
``` json
{
    "result": {
        "message": "Your password has been reset!"
    },
    "code": 200
}
```

* _Error_
``` json
{
    "error": {
        "message": "We can't find a user with that e-mail address.",
        "request": {
            "email": "admin@test.com",
            "token": "5ed78c1a0d612dd7442b66ba901deb04580609ac4e606220ddb99fe3c8026257",
            "password": "123456",
            "password_confirmation": "123456"
        }
    },
    "code": 404
}
```

* _Error Validation_
``` json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": [
            "The email must be a valid email address."
        ]
    },
    "code": 422,
    "request": {
        "email": "admin@",
        "token": "8614ee870b0cad894dec2ea0f11b7edd152a210732b396f424ee604f414db51f",
        "password": "1234567",
        "password_confirmation": "1234567"
    }
}
```
