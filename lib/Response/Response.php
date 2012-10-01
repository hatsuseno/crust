<?php

namespace CWX\Crust\Response;

use CWX\Crust\Core\Collection;

class Response {
    protected $headers;
    protected $content;

    final public function __construct() {
        $this->headers = new Collection();
        $this->init();
    }

    // Intentionally left empty for inheriting classes
    public function init() { }

    public function setContent($content) {
        $this->content = $content;

        return $this;
    }

    public function getContent() {
        return $this->content;
    }

    public function setHeader($header, $value) {
        $this->headers->set($header, $value);

        return $this;
    }

    public function execute() {
        $content = $this->getContent();

        if($this->headers->count() && headers_sent()) {
            throw new \Exception('Unable to execute response, headers already sent');
        }

        $this->headers->map(function ($content, $header) {
            header(sprintf('%s: %s', $header, $content));
        });

        print $content;
    }
}
