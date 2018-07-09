## Product Api

### `GET` Products
```
/api/products
```
Get list product
#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json

#### Query Param
| Key | Value | Description |
|---|---|---|
| limit | number | Top Product |
| category | int | Get Products belong to Category |
| sortBy | string | Top New Product, Top Rating Product, Top selling Product 'quantity_sold = order_detail.quantity(Sum(quantity))' of product |
| order | string | Sort Product (ASC, DESC) |
| perpage | int | paginate for page Product |
| price | int | fillter for Product belong to price |
| rating | int | fillter for Product belong to rating|

##### Example
| URL | Description |
|---|---|
| /api/products?sortBy=created_at&limit=9 | Get Top 9 New Products |
| /api/products?sortBy=avg_rating&limit=9 | Get Top 9 Rating Products |
| /api/products?sortBy=selling&limit=4 | Get Top 4 Selling Products |
| /api/products?category=1 | Get Products belong to Category  |
| /api/products?category=1&sortBy=name&order=DESC&perpage=1 | Get Products belong to Category and sort for page |

#### Response
```json
{
    "result": {
        "paginator": {
            "current_page": 1,
            "first_page_url": "http://192.168.21.12/api/products?sortBy=selling&page=1",
            "from": 1,
            "last_page": 2,
            "last_page_url": "http://192.168.21.12/api/products?sortBy=selling&page=2",
            "next_page_url": "http://192.168.21.12/api/products?sortBy=selling&page=2",
            "path": "http://192.168.21.12/api/products",
            "per_page": 5,
            "prev_page_url": null,
            "to": 5,
            "total": 10
        },
        "data": [
            {
                "id": 1,
                "category_id": 11,
                "name": "Alfreda Purdy Jr.",
                "description": "Ipsum sit quod ut. Ea quia architecto rerum consequatur. Hic delectus consequuntur eligendi. Repudiandae consectetur assumenda corrupti sunt nisi. Quidem numquam consequatur dignissimos velit ut quis nemo. Fugiat Chip delectus voluptas in. Magni aperiam Camera Camera ut a. Debitis sunt quod ut minus recusandae rem et. Officiis consequatur error officiis animi consequuntur qui architecto. Voluptas a expedita voluptatibus quam dolores inventore quidem modi.",
                "total_rate": 11,
                "rate_count": 3,
                "avg_rating": 3.7,
                "price": 5462485,
                "quantity": 34,
                "status": 1,
                "created_at": "2018-05-30 07:37:35",
                "updated_at": "2018-06-05 09:42:43",
                "deleted_at": "2018-06-05 09:42:43",
                "price_formated": "6,321,000",
                "quantity_sold": "6",
                "image_path": "http://product-tiki.show/images/upload/",
                "category": {
                    "id": 11,
                    "parent_id": 3,
                    "name": "Dr. Citlalli Berge I",
                    "level": 1,
                    "created_at": "2018-05-30 07:37:34",
                    "updated_at": "2018-05-30 07:37:34",
                    "deleted_at": null
                },
                "images": [
                    {
                        "id": 41,
                        "product_id": 1,
                        "img_url": "img.jpg",
                        "created_at": "2018-05-30 07:37:36",
                        "updated_at": "2018-05-30 07:37:36"
                    }
                ]
            }
        ]
    },
    "code": 200
}
```

### `GET` Products Comparision
```
/api/products/{productBase}/compare/{productCompare}
```
Get product comparision

#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json

#### Query Param
| Key | Value | Description |
|---|---|---|
| productBase | int | Base Product to compare |
| productCompare | int | Product to compare |

##### Example
| URL | Description |
|---|---|
| /api/products/1/compare/4 | Compare product with Id 1 with product with Id 4 |

#### Response
```json
{
    "result": {
        "metaBase": {
            "SD support": "test",
            "Camera": "test",
            "Ram": "test",
            "Chip": "test",
            "Screen": null,
            "Battery": null
        },
        "metaCompare": {
            "Chip": "compare",
            "Screen": "compare",
            "Battery": "compare",
            "Ram": "compare",
            "SD support": null,
            "Camera": null
        },
        "metaKey": {
            "0": "SD support",
            "1": "Camera",
            "2": "Ram",
            "3": "Chip",
            "5": "Screen",
            "6": "Battery"
        }
    },
    "code": 200
}
```
### `GET` Recommend Products
```
/api/products/recommend
```
Get list recommend products

#### Request Headers
| Key | Value |
|---|---|
|Accept|application/json

#### Query Param
| Key | Value | Description |
|---|---|---|
| product_id | int | Get list recommend Products (require) |
| category_id | int | id of category |
| price | int | price recommend product |

##### Example
| URL | Description |
|---|---|
| /api/products/recommend?product_id=1 | Get list recommend Products with product id 1 |
| /api/products/recommend?price=1000&category_id=1 | Get list recommend Products in price >= 1000 with Id 1 |

#### Response
```json
{
    "result": [
        {
            "id": 2,
            "category_id": 24,
            "name": "Liliana Bruen V",
            "preview": "Repudiandae qui et ea rerum itaque. Eum quia dolores repellendus. Sed voluptatem voluptatem soluta in doloremque ad amet.",
            "description": "Repudiandae qui et ea rerum itaque. Eum quia dolores repellendus. Sed voluptatem voluptatem soluta in doloremque ad amet. Hic officia commodi nobis ipsam cupiditate ex. Dolores qui iusto tempore et. Harum maxime pariatur magni. Voluptate adipisci quia fugiat eius alias. Aut temporibus autem aut facilis dolor dolores officia voluptatem. Enim animi error voluptas excepturi fugit. Omnis saepe illo velit consequatur totam et rerum. Esse eius placeat dolores quis odio odit accusantium.",
            "total_rate": 5,
            "rate_count": 2,
            "avg_rating": 2.5,
            "price": 7474311,
            "quantity": 46,
            "status": 1,
            "created_at": "2018-06-08 08:45:48",
            "updated_at": "2018-06-08 08:45:48",
            "deleted_at": null,
            "price_formated": "7,474,311",
            "image_path": "http://192.168.33.10/images/upload/",
            "order_details_count": 12,
            "category": [
                {
                "id": 24,
                "parent_id": 5,
                "name": "Dr. Jared Hand Sr.",
                "level": 1,
                "created_at": "2018-06-08 08:45:48",
                "updated_at": "2018-06-08 08:45:48",
                "deleted_at": null,
                }
            ],
            "images": [
                {
                "id": 6,
                "product_id": 2,
                "img_url": "img.jpg",
                "created_at": "2018-06-08 08:45:50",
                "updated_at": "2018-06-08 08:45:50",
                },
                {
                "id": 31,
                "product_id": 2,
                "img_url": "img.jpg",
                "created_at": "2018-06-08 08:45:50",
                "updated_at": "2018-06-08 08:45:50",
                }
            ],
        },
        {
            "id": 3,
            "category_id": 11,
            "name": "Alfreda Purdy Jr.",
            "preview": "Ipsum sit quod ut. Ea quia architecto rerum consequatur. Hic delectus consequuntur eligendi. Repudiandae consectetur assumenda corrupti sunt nisi.", 
            "description": "Ipsum sit quod ut. Ea quia architecto rerum consequatur. Hic delectus consequuntur eligendi. Repudiandae consectetur assumenda corrupti sunt nisi. Quidem numquam consequatur dignissimos velit ut quis nemo. Fugiat Chip delectus voluptas in. Magni aperiam Camera Camera ut a. Debitis sunt quod ut minus recusandae rem et. Officiis consequatur error officiis animi consequuntur qui architecto. Voluptas a expedita voluptatibus quam dolores inventore quidem modi.",
            "total_rate": 11,
            "rate_count": 3,
            "avg_rating": 3.7,
            "price": 5462485,
            "quantity": 34,
            "status": 1,
            "created_at": "2018-05-30 07:37:35",
            "updated_at": "2018-06-05 09:42:43",
            "deleted_at": null,
            "price_formated": "7,474,311",
            "image_path": "http://192.168.33.10/images/upload/",
            "order_details_count": 12,
            "category": {
                "id": 11,
                "parent_id": 3,
                "name": "Dr. Citlalli Berge I",
                "level": 1,
                "created_at": "2018-05-30 07:37:34",
                "updated_at": "2018-05-30 07:37:34",
                "deleted_at": null
            },
            "images": [
                {
                    "id": 41,
                    "product_id": 3,
                    "img_url": "img.jpg",
                    "created_at": "2018-05-30 07:37:36",
                    "updated_at": "2018-05-30 07:37:36"
                }
            ]
        }
    ],
    "code": 200
}
```
