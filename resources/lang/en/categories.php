<?php

return [
    'title' => 'Categories Management',
    'subtitle' => 'Manage your agricultural product categories',
    'new_category' => 'New Category',

    'search_placeholder' => 'Search for a category...',
    'filter_all_types' => 'All types',
    'type_offer' => 'Offer',
    'type_demand' => 'Demand',
    'type_post' => 'Post',
    'sort_by_name' => 'Name',
    'sort_by_date' => 'Creation date',
    'sort_by_status' => 'Status',

    'modal' => [
        'edit_title' => 'Edit Category',
        'create_title' => 'New Category',
    ],

    'form' => [
        'name' => 'Name',
        'slug' => 'Slug',
        'type' => 'Type',
        'icon' => 'Icon',
        'icon_placeholder' => 'Click to choose an emoji',
        'icon_help' => 'Click to select an emoji',
        'color' => 'Color',
        'description' => 'Description',
        'active_category' => 'Active category',
    ],

    'buttons' => [
        'cancel' => 'Cancel',
        'update' => 'Update',
        'create' => 'Create',
        'delete' => 'Delete',
    ],

    'delete_modal' => [
        'title' => 'Confirm Deletion',
        'message' => 'Are you sure you want to delete this category? This action is irreversible.',
    ],

    'notifications' => [
        'color_copied' => 'Color copied!',
    ],

    'validation' => [
        'name_required' => 'Category name is required.',
        'slug_required' => 'Slug is required.',
        'slug_unique' => 'This slug is already in use.',
        'color_required' => 'Color is required.',
    ],
    'updated_success' => 'Category updated successfully.',
    'created_success' => 'Category created successfully.',
    'deleted_success' => 'Category deleted successfully.',
    'status_updated' => 'Category status updated.',
];
