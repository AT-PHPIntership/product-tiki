## Comment Api

### `GET` Comments
```
/api/posts/{post}/comments
```
Get list all product's comments
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json

#### Query Param
| Param | Type | Description |
|---|---|---|
| post | int | Get comments's post (require) |
| perpage | int | number item per page |
| page | int | paginate comments |

#### Response
```json
{
    "result": {
        "paginator": {
            "current_page": 1,
            "first_page_url": "http://product.tiki/api/posts/1/comments?page=1",
            "from": 1,
            "last_page": 2,
            "last_page_url": "http://product.tiki/api/posts/1/comments?page=2",
            "next_page_url": "http://product.tiki/api/posts/1/comments?page=2",
            "path": "http://product.tiki/api/posts/1/comments",
            "per_page": 5,
            "prev_page_url": null,
            "to": 5,
            "total": 7
        },
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "post_id": 1,
                "content": "Voluptate doloremque rerum dignissimos dolores rerum. Blanditiis et qui sit ea nobis rem. Qui ullam aut aut a fugit aut.",
                "diff_time": "1 day ago",
                "image_path": "http://product-tiki.show/images/upload/",
                "created_at": "2018-05-31 07:04:58",
                "updated_at": "2018-05-31 07:04:58",
                "deleted_at": null,
                "user": [
                    {
                        "id": 1,
                        "username": "cloud",
                        "email": "cloud@gmail.com",
                        "is_active": 1,
                        "role": 1,
                        "last_logined_at": "2018-05-31 07:04:58",
                        "created_at": "2018-05-31 07:04:58",
                        "updated_at": "2018-05-31 07:04:58",
                        "deleted_at": null,
                        "userinfo": [
                            {
                                "id": 1,
                                "user_id": 1,
                                "full_name": "Kiehn Bony",
                                "avatar": "img.jpg",
                                "gender": 1,
                                "dob": "1986-10-05",
                                "address": "4000 Fredrick Suite 861\nSchmidtton, NC 00074-0123",
                                "phone": "+1.743.999.1234",
                                "identity_card": "147111435",
                                "created_at": "2018-06-05 10:12:46",
                                "updated_at": "2018-06-05 10:12:46"
                            }
                        ]
                    }
                ]
            }
        ]
    },
    "code": 200
}
```
### `GET` Comments of logged in user
```
/api/comments
```
Get list all user's comments
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json
|Authorization| Bearer $token

#### Query Param
| Param | Type | Description |
|---|---|---|
| perpage | int | number item per page |
| page | int | paginate comments |

#### Response
* _Success_
``` json
{
    "result": {
        "paginator": {
            "current_page": 1,
            "first_page_url": "http://product.tiki/api/comments?page=1",
            "from": 1,
            "last_page": 2,
            "last_page_url": "http://product.tiki/api/comments?page=2",
            "next_page_url": "http://product.tiki/api/comments?page=2",
            "path": "http://product.tiki/api/comments",
            "per_page": 5,
            "prev_page_url": null,
            "to": 5,
            "total": 7
        },
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "post_id": 1,
                "content": "Voluptate doloremque rerum dignissimos dolores rerum. Blanditiis et qui sit ea nobis rem. Qui ullam aut aut a fugit aut.",
                "diff_time": "1 day ago",
                "image_path": "http://product-tiki.show/images/upload/",
                "created_at": "2018-05-31 07:04:58",
                "updated_at": "2018-05-31 07:04:58",
                "deleted_at": null
            }
        ]
    },
    "code": 200
}
```
* _Error_
``` json
{
    "error": "Unauthorised",
    "code": 401
}
```


