<?php

namespace JsonLd\ContextTypes;

class Comment extends AbstractContext {
    /**
     * Property structure.
     *
     * @var array
     */
    protected $structure = [
        'about' => null,
        'headline' => null,
        'image' => null,
        'name' => null,
        'url' => null,
        'author' => Person::class,
        'publisher' => Organization::class,
        'keywords' => null,
        'inLanguage' => null,
        'dateCreated' => null,
        'dateModified' => null,
        'datePublished' => null,
        'sameAs' => null,
        'text' => null,
        'aggregateRating' => AggregateRating::class,
        'commentCount' => null,
        'comment' => Comment::class, // or ListItem
    ];
}
