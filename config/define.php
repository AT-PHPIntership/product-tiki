
<?php

return [
    'images_path_users' => '/images/avatar/',
    'page_length' => 10,
    'dir_asc' => 'ASC',
    'dir_desc' => 'DESC',
    'limit_rows' => 6,
    'product' => [
        'limit_rows' => 5,
        'upload_image_url' => 'images/upload/',
        'exceed_quantity' => 'Quantity of Products is too much'
    ],
    'post' => [
        'limit_rows' => 5,
        'sort_product_name' => 'name',
        'sort_username' => 'username',
    ],
    'category' => [
        'limit_rows' => 10,
        'sort_by_name' => 'name',
        'sort_by_products_count' => 'products_count',
    ],
    'order' => [
        'limit_rows' => 5,
        'sort_orderdetails_count' => 'orderdetails_count',
        'sort_total' => 'total'
    ],
    'dir_desc' => 'DESC',
    'dir_asc' => 'ASC',
    'homepage' => [
        'numberOfRecords' => '5',
        'time' => [
            'month' => 'month',
            'year' => 'year',
            'week' => 'week'
        ],
        'type' => [
            'user' => 'user',
            'order' => 'order'
        ],
        'request' => [
            'time' => [
                'month' => 'last month',
                'year' => 'last year',
                'week' => 'last week',
                'all' => 'all'
            ]
        ]
    ],
    'login' => [
        'unauthorised' => 'Unauthorised'
    ],
    'errors' => [
        'notfound' => 'Model not found',
    ],
    'exception' => [
        'cancel_approve_order' => 'Cannot Cancel APPROVED order',
        'change_approve_order' => 'Cannot Change APPROVED order',
    ],
    'day_coupon_money' => 15,
    'coupon_money_defaul' => [
        'discount' => 10,
        'min_total' => 20,
        'date_end' => 3,
    ],
    'coupon_percent_defaul' => [
        'discount' => 20,
        'max_total' => 200,
        'date_end' => 3,
    ],
];
