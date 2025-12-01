<?php

return [
    'title' => 'Tags Management',
    'subtitle' => 'Organize and categorize your content with style',
    'new_tag' => 'New Tag',
    'more_actions' => 'More Actions',
    'export_csv' => 'Export CSV',
    'import_csv' => 'Import CSV',
    'delete_selected' => 'Delete Selection (:count)',
    
    'search_placeholder' => 'Search for a tag...',
    'sort_by_name' => 'Sort by name',
    'sort_by_date' => 'Creation date',
    'sort_by_color' => 'Color',
    'sort_by_status' => 'Status',
    'sort_order' => 'Order',
    
    'filter_all' => 'All tags',
    'filter_active' => 'Active',
    'filter_inactive' => 'Inactive',
    
    'stats' => [
        'total' => 'Total Tags',
        'active' => 'Active',
        'selected' => 'Selected',
        'colors' => 'Colors',
    ],
    
    'default_color' => 'Default color',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],
    
    'actions' => [
        'edit' => 'Edit',
        'duplicate' => 'Duplicate',
        'delete' => 'Delete',
    ],
    
    'modal' => [
        'edit_title' => 'Edit Tag',
        'edit_subtitle' => 'Update tag information',
        'create_title' => 'Create Tag',
        'create_subtitle' => 'Add a new tag to your collection',
    ],
    
    'form' => [
        'name' => 'Name',
        'name_placeholder' => 'Enter tag name...',
        'slug' => 'Slug',
        'slug_placeholder' => 'auto-slug',
        'description' => 'Description',
        'description_placeholder' => 'Describe this tag in detail...',
        'color' => 'Color',
        'color_presets' => 'Color presets',
        'status' => 'Tag status',
        'status_description' => 'Enable or disable this tag',
    ],
    
    'buttons' => [
        'cancel' => 'Cancel',
        'update' => 'Update',
        'create' => 'Create',
        'delete' => 'Delete',
        'import' => 'Import',
        'delete_all' => 'Delete All',
    ],
    
    'delete_modal' => [
        'title' => 'Confirm Deletion',
        'message' => 'Are you sure you want to delete this tag? This action is irreversible.',
    ],
    
    'import_modal' => [
        'title' => 'Import Tags',
        'file_label' => 'CSV File',
        'click_to_choose' => 'Click to choose a CSV file',
        'format' => 'Format: name, description, color, status',
    ],
    
    'bulk_delete_modal' => [
        'title' => 'Multiple Deletion',
        'message' => 'Are you sure you want to delete these tags?',
        'tags_count' => 'tags',
    ],
    
    'notifications' => [
        'color_copied' => 'Color copied!',
    ],
 
        'validation' => [
            'name_required' => 'Tag name is required.',
            'slug_required' => 'Slug is required.',
            'slug_unique' => 'This tag already exists.',
        ],
        'updated_success' => 'Tag updated successfully!',
        'created_success' => 'Tag created successfully!',
        'deleted_success' => 'Tag deleted successfully!',
        'bulk_deleted_success' => 'tags deleted successfully!',
        'status_updated' => 'Tag status updated!',
        'duplicated_success' => 'Tag duplicated successfully!',
        'copy_suffix' => 'Copy',
        'export_header' => 'Name,Slug,Description,Color,Status',
        'export_filename' => 'tags-export',
        'status_active' => 'Active',
        'status_inactive' => 'Inactive',
        'imported_success' => 'tags imported successfully!',
    ];