<?php

namespace CWX\Crust\Response;

class NotFoundResponse extends Response {
    public function init() {
        $this->setHeader('Status', '404 Not Found');
        $this->setContent(<<<EOH
<!DOCTYPE html>
<html>
    <head>
        <title>404 - Not Found</title>
    </head>
    
    <body>
        <h1>404 - Not Found</h1>
        <p>Terribly sorry to have to tell you this, but the requested page could not be found!</p>
    </body>
</html>
EOH
        );
    }
}
