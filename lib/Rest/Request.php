<?php

namespace CWX\Crust\Rest;

use CWX\Crust\Request\Request as BaseRequest;

class Request extends BaseRequest {
    protected $format;

    // So we do a nasty hack to hijack into the inheritance chain
    // setPath *shouldn't* have side-effects other than *setting the path*
    // But in this case it's the only clean-ish solution to extend Request
    // behavior properly. Bad design eh?
    public function setPath($path) {
        if(empty($this->format)) {
            preg_match('#\.(?<format>[[:alnum:]]+)$#', $path, $matches);

            if(array_key_exists('format', $matches)) {
                $this->format = $matches['format'];

                $path = substr($path, 0, strlen($path) - strlen($matches[0]));
            }
        }

        return parent::setPath($path);
    }

    public function setFormat($format) {
        $this->format = $format;

        return $this;
    }

    public function getFormat($format) {
        return $this->format;
    }
}
