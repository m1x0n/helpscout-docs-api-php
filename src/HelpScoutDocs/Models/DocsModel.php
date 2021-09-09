<?php

declare(strict_types=1);

namespace HelpScoutDocs\Models;

class DocsModel
{
    public function toJson(): string
    {
        return json_encode($this->getModelProperties(), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->getModelProperties();
    }

    /**
     * Get access to private model properties via PHP Reflection
     *
     * @return array<string, mixed>
     */
    protected function getModelProperties(): array
    {
        $reflector = new \ReflectionClass($this);
        $properties = [...$reflector->getProperties(), ...$reflector->getParentClass()->getProperties()];

        $vars = array();

        foreach ($properties as $prop) {
            $vars[$prop->name] = $this->{"get" . ucfirst($prop->name)}();
        }

        return $vars;
    }
}
