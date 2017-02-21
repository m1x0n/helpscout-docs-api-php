<?php

namespace HelpScoutDocs\Models;

class RedirectedUrl extends DocsModel
{
    private $type;
    private $redirect;
    private $slug;
    private $number;
    private $anchor;

    public function __construct($data = null)
    {
        if ($data) {
            $this->type = isset($data->type) ? $data->type : null;
            $this->redirect = isset($data->redirect) ? $data->redirect : null;
            $this->slug = isset($data->slug) ? $data->slug : null;
            $this->number = isset($data->number) ? $data->number : null;
            $this->anchor = isset($data->anchor) ? $data->anchor : null;
        }
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @return mixed
     */
    public function getAnchor()
    {
        return $this->anchor;
    }

    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }
}
