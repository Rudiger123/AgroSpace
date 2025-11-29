<?php

return [
    // General error and success messages
    'errors' => [
        'auth_required' => 'You must be logged in to perform this action.',
        'comment_not_found' => 'Comment not found.',
        'spam_detected' => 'Your comment appears to be spam. Please try again.',
        'reaction_error' => 'Error updating reaction.',
        'share_error' => 'Error sharing.',
        'comment_error' => 'An error occurred while adding the comment.',
        'operation_error' => 'Error during operation.',
        'delete_error' => 'Error during deletion.',
        'save_error' => 'Error during save.',
        'no_selection' => 'No items selected.'
    ],
    
    'success' => [
        'comment_added' => 'Comment added successfully!',
        'liked' => 'Article liked!',
        'unliked' => 'Like removed.',
        'shared' => 'Thank you for sharing this article!',
        'saved' => 'Saved successfully!',
        'deleted' => 'Deleted successfully!',
        'approved' => 'Approved successfully!',
        'rejected' => 'Rejected successfully!',
        'marked_spam' => 'Marked as spam!',
        'published' => 'Article published!',
        'unpublished' => 'Article unpublished!',
        'featured' => 'Article featured!',
        'unfeatured' => 'Article unfeatured!'
    ],
    
    // Validation
    'validation' => [
        'comment_required' => 'Please enter a comment.',
        'comment_min' => 'Comment must be at least 3 characters.',
        'comment_max' => 'Comment cannot exceed 1000 characters.',
        'title_required' => 'Title is required.',
        'title_min' => 'Title must be at least 3 characters.',
        'slug_required' => 'Slug is required.',
        'slug_unique' => 'This slug is already used.',
        'content_required' => 'Content is required.',
        'content_min' => 'Content must be at least 10 characters.',
        'image_invalid' => 'Image must be a valid image file.',
        'image_max' => 'Image must not exceed 2MB.'
    ],
    
    // Buttons and actions
    'actions' => [
        'like' => 'Like',
        'unlike' => 'Unlike',
        'comment' => 'Comment',
        'reply' => 'Reply',
        'cancel_reply' => 'Cancel reply',
        'share' => 'Share',
        'read_more' => 'Read more',
        'view_all' => 'View all',
        'show_more' => 'Show more',
        'show_less' => 'Show less',
        'apply_filters' => 'Apply filters',
        'reset_filters' => 'Reset filters',
        'create' => 'Create',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'preview' => 'Preview',
        'publish' => 'Publish',
        'unpublish' => 'Unpublish',
        'approve' => 'Approve',
        'reject' => 'Reject',
        'mark_spam' => 'Mark as spam',
        'export' => 'Export',
        'refresh' => 'Refresh',
        'feature' => 'Feature',
        'unfeature' => 'Unfeature'
    ],
    
    // Statuses
    'status' => [
        'published' => 'Published',
        'draft' => 'Draft',
        'scheduled' => 'Scheduled',
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'spam' => 'Spam',
        'all' => 'All'
    ],
    
    // Filters and sorting
    'filters' => [
        'search' => 'Search...',
        'category' => 'Category',
        'tag' => 'Tag',
        'author' => 'Author',
        'status' => 'Status',
        'sort_by' => 'Sort by',
        'date_from' => 'Start date',
        'date_to' => 'End date',
        'all_categories' => 'All categories',
        'all_authors' => 'All authors'
    ],
    
    'sort_options' => [
        'recent' => 'Most recent',
        'popular' => 'Most popular',
        'likes' => 'Most liked',
        'views' => 'Most viewed',
        'comments' => 'Most commented',
        'title' => 'Title',
        'published_at' => 'Publication date',
        'created_at' => 'Creation date'
    ],
    
    // Metrics and statistics
    'metrics' => [
        'views' => 'Views',
        'likes' => 'Likes',
        'comments' => 'Comments',
        'shares' => 'Shares',
        'reading_time' => 'Reading time',
        'progress' => 'Progress',
        'engagement' => 'Engagement',
        'total_posts' => 'Total posts',
        'posts_this_month' => 'Posts this month',
        'total_views' => 'Total views',
        'views_today' => 'Views today',
        'total_comments' => 'Total comments',
        'approved_comments' => 'Approved comments',
        'total_likes' => 'Total likes',
        'total_shares' => 'Total shares',
        'tags_count' => 'Tags',
        'categories_count' => 'Categories',
        'active_authors' => 'Active authors'
    ],
    
    // User interface
    'ui' => [
        'no_posts' => 'No posts found.',
        'no_comments' => 'No comments.',
        'no_results' => 'No results found.',
        'loading' => 'Loading...',
        'confirm_delete' => 'Are you sure you want to delete this item?',
        'confirm_bulk_delete' => 'Are you sure you want to delete the selected items?',
        'select_all' => 'Select all',
        'selected_count' => ':count items selected',
        'reading_progress' => 'Reading progress',
        'time_spent' => 'Time spent',
        'related_posts' => 'Related posts',
        'previous_post' => 'Previous post',
        'next_post' => 'Next post',
        'featured_post' => 'Featured post',
        'recent_posts' => 'Recent posts',
        'popular_tags' => 'Popular tags',
        'communication_channels' => 'Communication channels'
    ],
    
    // Forms
    'forms' => [
        'title' => 'Title',
        'slug' => 'Slug',
        'excerpt' => 'Excerpt',
        'content' => 'Content',
        'category' => 'Category',
        'tags' => 'Tags',
        'featured_image' => 'Featured image',
        'meta_title' => 'SEO Title',
        'meta_description' => 'SEO Description',
        'published' => 'Published',
        'published_at' => 'Publication date',
        'choose_category' => 'Choose a category...',
        'choose_tags' => 'Choose tags...',
        'generate_slug' => 'Generate slug',
        'upload_image' => 'Upload image'
    ],
    
    // Sharing
    'share' => [
        'title' => 'Share this article',
        'platforms' => [
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'linkedin' => 'LinkedIn',
            'whatsapp' => 'WhatsApp',
            'email' => 'Email'
        ]
    ],
    
    // Analytics
    'analytics' => [
        'title' => 'Blog Analytics',
        'period' => 'Period',
        'posts' => 'Posts',
        'reactions' => 'Reactions',
        'platforms' => 'Platforms',
        'top_posts' => 'Top posts',
        'reaction_breakdown' => 'Reaction breakdown',
        'shares_by_platform' => 'Shares by platform',
        'export_csv' => 'Export to CSV'
    ],
    
    // Comment management
    'comments' => [
        'management' => 'Comment management',
        'content' => 'Comment content',
        'author' => 'Author',
        'post' => 'Post',
        'date' => 'Date',
        'actions' => 'Actions',
        'bulk_actions' => 'Bulk actions',
        'details' => 'Comment details',
        'ip_address' => 'IP Address',
        'user_agent' => 'User Agent'
    ],
    
    // Post management
    'posts' => [
        'management' => 'Post management',
        'create' => 'Create post',
        'edit' => 'Edit post',
        'preview' => 'Post preview',
        'list' => 'Posts list',
        'bulk_actions' => 'Bulk actions',
        'author' => 'Author',
        'published_date' => 'Publication date',
        'status' => 'Status',
        'featured' => 'Featured'
    ]
];