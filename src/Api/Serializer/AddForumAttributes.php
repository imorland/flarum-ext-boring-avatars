<?php

namespace IanM\BoringAvatars\Api\Serializer;

use Flarum\Api\Serializer\ForumSerializer;

class AddForumAttributes
{
    public function __invoke(ForumSerializer $serializer, $model, $attributes): array
    {
        return $attributes;
    }
}
