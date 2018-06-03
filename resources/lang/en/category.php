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
            'child_category' => 'Child Category',
        ],
        'add' => [
            'title' => 'Add Category',
            'name' => 'Name Category',
            'parent_category' => 'Parent Category',
            'submit' => 'Submit',
            'reset' => 'Reset',
            'back' => 'Back',
            'cancel' => 'Cancel',
            'placeholder_name' => 'Category Name',
        ],
        'edit' => [
            'title' => 'Edit Category',
        ],
        'message' => [
            'add' => 'Create New Category Successfull!',
            'add_fail' => 'Can not add New Category. Please check connect database!',
            'edit' => 'Update Category Successfull!',
            'edit_fail' => 'Can not edit Category. Please check connect database!',
            'del' => 'Delete Category Successfull!',
            'del_fail' => 'Can not Delete Category. Please check connect database!',
            'msg_del' => 'Do you want to delete this Category?',
        ]
    
    ]
];
