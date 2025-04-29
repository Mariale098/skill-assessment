<?php

return [
    'cache_ttl' => 3600, // Cache time in seconds
    'rate_limit' => [
        'enabled' => true,
        'max_attempts' => 50,
        'decay_minutes' => 1,
    ],
]; 

