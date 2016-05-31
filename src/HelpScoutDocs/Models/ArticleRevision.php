<?php

namespace HelpScoutDocs\Models;

class ArticleRevision extends ArticleRevisionRef {

    private $text;

    function __construct($data = null) {
        if ($data) {
            parent::__construct($data);
            $this->text = isset($data->text) ? $data->text : null;
        }
    }

    /**
     * @param null $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return null
     */
    public function getText()
    {
        return $this->text;
    }
}