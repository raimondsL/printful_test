<?php

class CacheService implements CacheInterface
{

    private $filepath;

    public function __construct()
    {
        $this->filepath = getcwd() . "\\cache\\";
    }
    
    /**
     * Store a mixed type value in cache for a certain amount of seconds.
     * Supported values should be scalar types and arrays.
     *
     * @param string $key
     * @param mixed $value
     * @param int $duration Duration in seconds
     * @return mixed
     */
    public function set(string $key, $value, int $duration)
    {
        $data = json_encode(
            [
                "timeout" => time() + $duration,
                "data" => $value
            ]
        );

        return @file_put_contents($this->filepath . $key, $data);
    }
    
    /**
     * Retrieve stored item.
     * Returns the same type as it was stored in.
     * Returns null if entry has expired.
     *
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        $data = @file_get_contents($this->filepath . $key);

        if ($data) {
            $json = json_decode($data);
            if ($json->timeout > time()) {
                return $json->data;
            }
        }

        return null;
    }
}