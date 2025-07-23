<?php

namespace module;

class Sanitize 
{
    public function sanitize($data) {
        if (is_array($data)){
            return array_map([$this, 'sanitize'], $data);
        } else {
            $data = htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
            $data = trim($data);
            return $data;
        }
    }
}