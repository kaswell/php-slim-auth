<?php

namespace Core;

class Config
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * Config constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function has($key)
    {
        return array_key_exists($key, $this->config);
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        if ($this->has($key)){
            return $this->config[$key];
        }
        return null;
    }
}