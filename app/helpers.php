<?php

use Illuminate\Support\Facades\Log;

function getPostsWithFilter(\App\Post $root, array $args): void
{
    Log::info($args);
    // foreach ($args as $note) {
    //     $root->notes()->create($note);
    // }
}
