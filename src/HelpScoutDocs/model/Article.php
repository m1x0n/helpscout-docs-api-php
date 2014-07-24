<?php

namespace HelpScoutDocs\model;

class Article extends ArticleRef {

    private $text;
    private $code;
    private $categories;
    private $related;

    function __construct($data = null) {
        if ($data) {
            parent::__construct($data);

            $this->text       = isset($data->text)       ? $data->text       : null;
            $this->code       = isset($data->code)       ? $data->code       : null;
            $this->categories = isset($data->categories) ? $data->categories : null;
            $this->related    = isset($data->related)    ? $data->related    : null;
        }
    }
}