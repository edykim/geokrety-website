<?php

namespace Geokrety\Domain;

class KonkretLog {
    public $authorName;
    public $authorUrl;
    public $text;
    public $dateCreated;

    public function __construct($authorName, $authorUrl, $text, $dateCreated) {
        $this->authorName = $authorName;
        $this->authorUrl = $authorUrl;
        $this->text = $text;
        $this->dateCreated = $dateCreated;
    }
}
