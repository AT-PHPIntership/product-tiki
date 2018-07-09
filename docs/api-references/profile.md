## Profile User Api

### `GET` Profile User
```
/api/users/profile
```
Get profile user
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json
|Authorization|Bearer $token

##### Example
| URL | Description |
|---|---|
| /api/users/profile | Get profile of user |


#### Response
``` json
{
    "result": [
        {
            "user": {
                "username": "abcde",
                "email": "abc@abc.abcde",
                "created_at": "2018-06-13 09:10:01",
                "updated_at": "2018-06-13 09:10:01",
                "id": 18,
                "image_path": "http://192.168.33.10/images/avatar/",
                "user_info": {
                    "id": 14,
                    "user_id": 18,
                    "full_name": "dsahdkjashd djaskdaskjdh",
                    "avatar": "img.jpg",
                    "gender": 1,
                    "dob": null,
                    "address": "1231 sjhdkshdaksh",
                    "phone": "1234567890",
                    "identity_card": "145789865",
                    "created_at": "2018-06-13 09:10:01",
                    "updated_at": "2018-06-13 09:10:01"
                }
            },
        }
    ],
    "code": 200
}
```

### `Put` Edit Profile User
```
/api/users/profile
```
Get profile user
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json
|Authorization|Bearer $token

#### Query Param
| Param | Type | Description |
|---|---|---|
| name | string | full name of user |
| gender | int | gender of user |
| phone | int | phone number of user |
| dob | string | date of birth of user |
| address | string | address of user |
| identity_card | int | identity card of user |
| avatar | file | file image avatar of user |

#### Response
* _Error_
``` json
{
    "message": "The given data was invalid.",
    "errors": {
        "full_name": [
            "The full name field is required."
        ]
    },
    "code": 422,
    "request": {
        "address": "1231 sjhdkshdaksh",
        "gender": "1",
        "phone": "1234567890",
        "identity_card": "145789862",
        "_method": "put",
        "avatar": {}
    }
}
```

* _Success_
``` json
{
    "result": {
        "id": 2,
        "username": "genevieve11",
        "email": "kfadel@example.com",
        "old_password": "",
        "is_active": 0,
        "role": 0,
        "last_logined_at": null,
        "created_at": "2018-06-18 06:23:42",
        "updated_at": "2018-06-18 06:23:42",
        "deleted_at": null,
        "userinfo": {
            "id": 11,
            "user_id": 2,
            "full_name": "dsahdkjashd djaskdaskjdh",
            "avatar": "1529465805-UZZAY0k9.jpg",
            "gender": 1,
            "dob": "2005-09-17",
            "address": "1231 sjhdkshdaksh",
            "phone": "1234567890",
            "identity_card": "145789861",
            "created_at": "2018-06-18 06:23:52",
            "updated_at": "2018-06-20 03:36:45"
        }
    },
    "code": 200
}
```

### `GET` Profile User Address
```
/api/users/profile/address
```
Get address of user
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json
|Authorization|Bearer $token


#### Response
``` json
{
    "result": [
        {
            "id": 5,
            "userinfo_id": 11,
            "address": "1459 Paige Rue Suite 089\nNicolasshire, ME 43281-8362",
            "created_at": "2018-07-06 02:00:24",
            "updated_at": "2018-07-06 02:00:24"
        },
        {
            "id": 19,
            "userinfo_id": 11,
            "address": "9515 Hyatt Pike Apt. 054\nOlgamouth, DC 17932-8485",
            "created_at": "2018-07-06 02:00:24",
            "updated_at": "2018-07-06 02:00:24"
        }
    ],
    "code": 200
}
```

### `PUT` Profile User Address
```
/api/users/profile/address/{address}
```
Update address of user
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json
|Authorization|Bearer $token

#### Query Param
| Param | Type | Description |
|---|---|---|
| address | int | address's id |

#### Response
``` json
{
    "result": {
        "id": 5,
        "userinfo_id": 11,
        "address": "Home",
        "created_at": "2018-07-06 02:00:24",
        "updated_at": "2018-07-06 04:06:47"
    },
    "code": 200
}
```
