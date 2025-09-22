<?php

namespace Framework\Http;

class ServerBag extends ParameterBag {

    public function getHeaders(): array {
        $headers = [];
        $contentHeaders = ['CONTENT_TYPE', 'CONTENT_LENGTH', 'CONTENT_MD5'];

        foreach ($this->all() as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$header] = $value;
            } elseif (in_array($key, $contentHeaders)) {
                $header = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', $key))));
                $headers[$header] = $value;
            }
        }

        return $headers;
    }
}
