<?php

return [
    'management' => [
        'title' => 'Comment Management',
        'subtitle' => 'Moderate and manage all blog comments',
    ],

    'filters' => [
        'title' => 'Filtering and Search',
        'search' => 'Search',
        'search_placeholder' => 'Content, author, email...',
        'status' => 'Status',
        'post' => 'Post',
        'all_posts' => 'All posts',
        'per_page' => 'Per page',
    ],

    'status' => [
        'all' => 'All',
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'spam' => 'Spam',
    ],

    'table' => [
        'comment' => 'Comment',
        'post' => 'Post',
        'author' => 'Author',
        'status' => 'Status',
        'likes' => 'Likes',
        'reports' => 'Reports',
        'ip' => 'IP',
        'date' => 'Date',
        'actions' => 'Actions',
        'na' => 'N/A',
        'anonymous' => 'Anonymous',
        'no_comments' => 'No comments found',
        'adjust_filters' => 'Please adjust your search filters.',
    ],

    'actions' => [
        'delete_selected' => 'Delete (:count)',
        'details' => 'Details',
        'approve' => 'Approve',
        'reject' => 'Reject',
        'spam' => 'Spam',
        'delete' => 'Delete',
        'confirm_delete' => 'Yes, delete',
        'confirm_bulk_delete' => 'Yes, delete all',
        'cancel' => 'Cancel',
    ],

    'messages' => [
        'confirm_delete_title' => 'Are you sure?',
        'confirm_delete_text' => 'This action is irreversible!',
        'confirm_bulk_delete_title' => 'Delete selected comments?',
        'confirm_bulk_delete_text' => 'This action is irreversible!',
        'approved_title' => 'Approved',
        'rejected_title' => 'Rejected',
        'spam_title' => 'Spam',
        'deleted_title' => 'Deleted',
        'bulk_deleted_title' => 'Deleted',
    ],
];
