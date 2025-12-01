<?php

return [
    '403' => [
        'title' => 'Access Denied',
        'message' => 'Restricted Area',
        'description' => 'Sorry, this area of the operation is reserved for authorized personnel. You don’t have the hangar keys.',
    ],
    '404' => [
        'title' => 'Plot Not Found',
        'message' => 'Oops! This plot does not exist.',
        'description' => 'It seems you’ve plowed too far. The page you’re looking for may have been harvested or moved.',
    ],
    '419' => [
        'title' => 'Session Expired',
        'message' => 'Break Time Over',
        'description' => 'Your session has expired due to inactivity. Please reload the page to resume your work.',
        'refresh' => 'Refresh the page',
    ],
    '429' => [
        'title' => 'Too Many Requests',
        'message' => 'Easy on the pedal!',
        'description' => 'You’re sending too many requests to the server. Give nature a little time to breathe.',
    ],
    '500' => [
        'title' => 'Technical Error',
        'message' => 'Engine Failure',
        'description' => 'Our digital irrigation system has encountered an unexpected issue. Our technicians are already in the field to fix it.',
    ],
    '503' => [
        'title' => 'Maintenance in Progress',
        'message' => 'We’re Growing New Features',
        'description' => 'AgroSpace is currently under maintenance to improve your experience. We’ll be back after the harvest (a few minutes).',
        'checking' => 'Automatically checking status...',
        'console' => 'Still under maintenance...',
    ],
    'back_to_fields' => 'Back to the fields',
];
