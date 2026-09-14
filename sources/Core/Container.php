<?php
namespace Aura\Core;

class Container {
    protected $bindings = [];

    public function bind($key, $value) {
        $this->bindings[$key] = $value;
    }

    public function resolve($key) {
        if (isset($this->bindings[$key])) {
            $resolver = $this->bindings[$key];
            return is_callable($resolver) ? $resolver($this) : $resolver;
        }

        // Auto-wiring via Reflection
        try {
            $reflector = new \ReflectionClass($key);
            
            if (!$reflector->isInstantiable()) {
                throw new \Exception("Class [$key] is not instantiable.");
            }

            $constructor = $reflector->getConstructor();

            if (is_null($constructor)) {
                return new $key;
            }

            $parameters = $constructor->getParameters();
            $dependencies = $this->getDependencies($parameters);

            return $reflector->newInstanceArgs($dependencies);

        } catch (\ReflectionException $e) {
            throw new \Exception("Target class [$key] does not exist.", 0, $e);
        }
    }

    protected function getDependencies($parameters) {
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType() && !$parameter->getType()->isBuiltin()
                ? $parameter->getType()->getName()
                : null;

            if ($dependency) {
                $dependencies[] = $this->resolve($dependency);
            } else {
                // Handle non-class dependencies (primitives) if needed
                // For now, we assume all constructor params are classes
                throw new \Exception("Cannot resolve primitive dependency for parameter " . $parameter->getName());
            }
        }

        return $dependencies;
    }
}
