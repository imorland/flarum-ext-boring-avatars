<?php

use Flarum\Database\Migration;

return Migration::addColumns('users', [
    'user_svg' => ['text', 'nullable' => true]
]);
