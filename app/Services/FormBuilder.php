<?php

namespace App\Services;

class FormBuilder
{
    public function open(array $options = [])
    {
        $method = $options['method'] ?? 'POST';
        $action = $options['action'] ?? '';
        $attributes = $this->buildAttributes($options);
        
        return '<form method="' . $method . '" action="' . $action . '"' . $attributes . '>';
    }
    
    public function close()
    {
        return '</form>';
    }
    
    public function text($name, $value = null, $attributes = [])
    {
        return $this->input('text', $name, $value, $attributes);
    }
    
    public function input($type, $name, $value = null, $attributes = [])
    {
        $attributes['type'] = $type;
        $attributes['name'] = $name;
        $attributes['value'] = $value;
        
        return '<input' . $this->buildAttributes($attributes) . '>';
    }
    
    protected function buildAttributes($attributes)
    {
        return collect($attributes)
            ->map(fn($value, $key) => "{$key}=\"{$value}\"")
            ->implode(' ');
    }
} 