<?php

namespace HelpScoutDocs\Models;

class Article extends ArticleRef {
    const ARTICLE_STATUS_PUBLISHED = 'published';
    const ARTICLE_STATUS_NOT_PUBLISHED = 'notpublished';

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $code;

    /**
     * @var null|array
     */
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

    /**
     * @param null $categories
     */
    public function setCategories($categories)
    {
        $this->categories = $categories;
    }

    /**
     * @return null
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param null $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return null
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param null $related
     */
    public function setRelated($related)
    {
        $this->related = $related;
    }

    /**
     * @return null
     */
    public function getRelated()
    {
        return $this->related;
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