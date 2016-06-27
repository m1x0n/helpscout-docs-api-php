<?php

namespace HelpScoutDocs\Models;

class DocsModel {

    /**
     * Return model properties in JSON
     *
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->getModelProperties());
    }
    
    public function toArray()
    {
        return $this->getModelProperties();
    }

    /**
     * Get access to private model properties via PHP Reflection
     *
     * @return array
     */
    protected function getModelProperties()
    {
        $reflector = new \ReflectionClass($this);
        $properties = array_merge($reflector->getProperties(), $reflector->getParentClass()->getProperties());

        $vars = array();

        foreach($properties as $prop) {
            $vars[$prop->name] = $this->{"get" . ucfirst($prop->name)}();
        }

        return $vars;
    }
} 