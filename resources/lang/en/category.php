<?php

return [
    'admin' => [
        'title' => 'Category',
        'list' => [
            'title' => 'List Categories'
        ],
        'table' => [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'action' => 'Action',
        ],
        'add' => [
            'title' => 'Add Category',
            'name' => 'Name Category',
            'parent_category' => 'Parent Category',
            'submit' => 'Submit',
            'reset' => 'Reset',
            'placeholder_name' => 'Name Category',
        ],
        'message' => [
            'add' => 'Create New Category Successfull!',
            'add_fail' => 'Can not add New Category. Please check connect database',
            'edit' => 'Update Category Successfull!',
            'del' => 'Delete Category Successfull!',
        ]
    ]
];
