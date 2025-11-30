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
    ],
    'analytics' => [
        'title' => 'Agrospace Analytics Dashboard',
        'description' => 'In-depth blog performance analysis',
        'refresh' => 'Refresh',
        'export_csv' => 'Export CSV',
        'filters' => [
            'title' => 'Period & Content Filters',
            'date_from' => 'From',
            'date_to' => 'To',
            'selected_period' => 'Selected period: from :from to :to',
            'filter_by_post' => 'Filter by Post',
            'filter_by_author' => 'Filter by Author',
            'comment_status' => 'Comment Status',
            'all_posts' => 'All posts',
            'all_authors' => 'All authors',
            'all_comments' => 'All comments',
            'approved' => 'Approved',
            'pending' => 'Pending',
            'rejected' => 'Rejected',
            'spam' => 'Spam',
        ],
        'stats' => [
            'published_posts' => 'Published posts',
            'filtered_coverage' => 'Covered by filters',
            'total_views' => 'Total views',
            'period' => 'During the period',
            'comments' => 'Comments',
            'pending' => 'pending',
            'total_likes' => 'Total Likes',
            'total_engagement' => 'Total engagement',
            'total_shares' => 'Total Shares',
            'external_visibility' => 'External visibility',
        ],
        'charts' => [
            'traffic_trend' => 'Traffic Trend (Views and Comments)',
            'reaction_breakdown' => 'Reactions Breakdown',
            'shares_by_platform' => 'Shares by Platform',
            'top_posts' => 'Top 5 Posts by Comments',
            'no_articles' => 'No articles found according to filters.',
        ],
    ],

    'list' => [
        'hero' => [
            'title' => 'News & Innovations from the agropastoral world',
            'highlight' => 'Innovations',
            'description' => 'Discover trends, tips, and inspiring stories from the Agrospace community.',
            'explore_articles' => 'Explore articles',
            'stats' => [
                'published_articles' => 'Published articles',
                'expert_contributors' => 'Expert contributors',
                'engaged_readers' => 'Engaged readers',
            ],
        ],
        'featured' => [
            'title' => 'Featured',
            'featured_badge' => '⭐ Featured article',
            'read_full' => 'Read full article',
        ],
        'filters' => [
            'search_placeholder' => 'Search for an article or topic...',
            'all_categories' => '📚 All',
            'popular_tags' => 'Popular tags:',
            'sort_by' => 'Sort by:',
            'most_recent' => 'Most recent',
            'most_popular' => 'Most popular',
            'most_liked' => 'Most liked',
            'clear_filters' => 'Clear filters',
            'loading' => 'Loading articles...',
        ],
        'articles' => [
            'no_results' => [
                'title' => 'No articles found',
                'description' => 'No articles match your search criteria.',
                'reset_filters' => 'Reset filters',
            ],
            'read' => 'Read',
            'stats' => [
                'views' => 'views',
                'likes' => 'likes',
                'comments' => 'comments',
            ],
        ],
        'impact' => [
            'title' => 'The Impact of <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-green-700">AgroSpace</span>',
            'description' => 'A dynamic community that shares, learns, and grows together',
            'stats' => [
                'published_articles' => 'Published Articles',
                'this_month' => 'this month',
                'total_views' => 'Total Views',
                'today' => 'Today',
                'comments' => 'Comments',
                'approved' => 'approved',
                'reactions' => 'Reactions',
                'liked_articles' => 'Liked articles',
                'shares' => 'Shares',
                'tags' => 'Tags',
                'categories' => 'Categories',
                'authors' => 'Authors',
            ],
        ],
        'cta' => [
            'title' => 'Agrospace is more than a platform',
            'description' => 'It\'s an agricultural community moving together towards a sustainable and prosperous future.',
            'join_community' => 'Join the community',
            'signup_info' => 'Sign up for free and connect with producers and consumers near you.',
        ],
    ],

    'manager' => [
        'title' => 'Blog Management',
        'description' => 'Create, edit and manage your articles with style',
        'actions' => [
            'new_article' => 'New Article',
            'comments_manager' => 'Comments Manager',
            'analytics' => 'Analytics',
        ],
        'stats' => [
            'total_posts' => 'Total Posts',
            'published' => 'Published',
            'drafts' => 'Drafts',
            'total_views' => 'Total Views',
        ],
        'filters' => [
            'search' => [
                'label' => 'Search',
                'placeholder' => 'Title, content, author...',
            ],
            'category' => [
                'label' => 'Category',
                'all' => 'All categories',
            ],
            'status' => [
                'label' => 'Status',
                'all' => 'All statuses',
                'published' => 'Published',
                'draft' => 'Drafts',
                'scheduled' => 'Scheduled',
            ],
            'author' => [
                'label' => 'Author',
                'all' => 'All authors',
            ],
            'quick_filters' => [
                'all_posts' => 'All posts',
                'published' => 'Published',
                'drafts' => 'Drafts',
                'oldest' => 'Oldest',
                'newest' => 'Newest',
            ],
        ],
        'articles' => [
            'status' => [
                'published' => 'Published',
                'draft' => 'Draft',
            ],
            'actions' => [
                'preview' => 'Preview',
                'edit' => 'Edit',
                'publish' => 'Publish',
                'unpublish' => 'Unpublish',
                'feature' => 'Feature',
                'unfeature' => 'Unfeature',
                'delete' => 'Delete',
            ],
            'meta' => [
                'author' => 'Author',
                'publish_date' => 'Publish date',
                'not_published' => 'Not published',
            ],
            'no_results' => [
                'title' => 'No articles found',
                'description' => 'Start your blogging adventure by creating your first beautiful article.',
                'create_first' => 'Create my first article',
            ],
        ],
        'modals' => [
            'create' => [
                'title' => '✨ Create New Article',
                'description' => 'Share your knowledge and inspire the AgroSpace community',
            ],
            'edit' => [
                'title' => '✏️ Edit Article',
                'description' => 'Update your article information to keep your community informed',
            ],
            'sections' => [
                'main_info' => [
                    'title' => 'Main Information',
                    'description' => 'The essential details of your article',
                    'fields' => [
                        'title' => 'Article Title',
                        'slug' => 'URL (Slug)',
                        'slug_info' => 'Automatically generated from title',
                    ],
                ],
                'classification' => [
                    'title' => 'Classification',
                    'description' => 'Category and tags to organize your content',
                    'fields' => [
                        'category' => 'Category',
                        'tags' => 'Tags',
                        'tags_info' => 'Hold Ctrl (Cmd on Mac) to select multiple tags',
                    ],
                ],
                'featured_image' => [
                    'title' => 'Featured Image',
                    'description' => 'Choose an attractive image for your article',
                    'upload' => [
                        'click_to_upload' => 'Click to upload or drag and drop',
                        'formats' => 'PNG, JPG, GIF up to 2MB',
                    ],
                ],
                'excerpt' => [
                    'title' => 'Excerpt',
                    'description' => 'A concise overview of your article',
                    'fields' => [
                        'excerpt' => 'Short Description',
                        'excerpt_info' => 'Will be automatically generated from content if left empty',
                    ],
                ],
                'content' => [
                    'title' => 'Article Content',
                    'description' => 'Write the body of your article',
                    'fields' => [
                        'content' => 'Main Text',
                        'markdown_support' => 'Markdown supported',
                    ],
                ],
                'publishing' => [
                    'title' => 'Publishing Options',
                    'description' => 'Schedule your article publication',
                    'fields' => [
                        'publish_now' => 'Publish now',
                        'publish_now_info' => 'Article will be immediately visible',
                        'publish_date' => 'Publication Date and Time',
                        'publish_date_info' => 'Leave empty for immediate publication',
                    ],
                ],
                'seo' => [
                    'title' => 'SEO Optimization',
                    'description' => 'Improve your visibility on search engines',
                    'fields' => [
                        'meta_title' => 'Meta Title',
                        'meta_title_info' => 'Ideally between 50-60 characters',
                        'meta_description' => 'Meta Description',
                        'meta_description_info' => 'Optimal between 150-160 characters for full display',
                    ],
                ],
            ],
            'actions' => [
                'cancel' => 'Cancel',
                'save' => 'Save',
                'create' => '✨ Create Article',
                'update' => '💾 Update',
                'saving' => 'Saving...',
                'auto_save' => 'Auto save',
                'auto_save_info' => 'Your changes are being saved',
            ],
        ],
        'delete_modal' => [
            'title' => 'Confirm deletion',
            'description' => 'Are you sure you want to delete this article? This action is irreversible.',
            'cancel' => 'Cancel',
            'confirm' => 'Delete',
        ],
        'preview_modal' => [
            'title' => '✨ Preview',
            'description' => 'Preview your article before publication',
            'desktop_view' => 'Desktop View',
            'mobile_view' => 'Mobile View',
            'fullscreen' => 'Fullscreen',
            'share' => [
                'title' => 'Share this article',
                'description' => 'Share this content with your community',
            ],
            'cta' => [
                'title' => 'Ready to publish your article?',
                'description' => 'Share your knowledge with the AgroSpace community',
                'back_to_edit' => 'Back to editing',
            ],
        ],
    ],

    'breadcrumb' => [
        'blog' => 'Blog',
    ],

    'meta' => [
        'reading_time' => 'min read',
        'views' => 'views',
        'min' => 'min',
    ],

    'actions' => [
        'share' => 'Share',
    ],

    'navigation' => [
        'previous' => 'Previous article',
        'next' => 'Next article',
    ],

    'related_posts' => [
        'title' => 'Related articles',
    ],

    'comments' => [
        'title' => 'Comments (:count)',
        'see_all' => 'See all comments',
        'see_less' => 'See less',
        'see_remaining' => 'See remaining :count comments',
        'replying_to' => 'Replying to a comment',
        'placeholder' => 'Share your opinion or ask a question...',
        'reply' => 'Reply',
        'publish' => 'Publish',
        'publishing' => 'publishing...',
        'cancel' => 'Cancel',
        'characters' => 'characters',
        'login_to_comment' => 'Login to comment',
        'login_description' => 'Share your experience with the AgroSpace community',
        'login' => 'Login',
        'no_comments' => 'No comments yet. Be the first to comment!',
        'replies' => ':count reply|:count replies',
    ],

    'author_modal' => [
        'title' => 'About the author',
        'default_role' => 'Producer',
        'verified' => 'Verified account',
        'default_bio' => 'Passionate about agriculture and knowledge sharing.',
        'published_posts' => 'Published articles',
        'subscribers' => 'Subscribers',
    ],

    'share_modal' => [
        'title' => 'Share article',
        'description' => 'Share this article with your community',
        'link_copied' => 'Link copied!',
    ],
];
