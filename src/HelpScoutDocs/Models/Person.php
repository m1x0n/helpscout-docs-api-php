<?php

namespace HelpScoutDocs\Models;

class Person extends DocsModel {

    private $id;
    private $firstName;
    private $lastName;

    function __construct($data = null) {
        if ($data) {
            $this->id        = isset($data->id)        ? $data->id        : null;
            $this->firstName = isset($data->firstName) ? $data->firstName : null;
            $this->lastName  = isset($data->lastName)  ? $data->lastName  : null;
        }
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
}