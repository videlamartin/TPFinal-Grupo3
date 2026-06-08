<?php

class MustacheRenderer {
    private $mustache;

    public function __construct($viewsFolder) {
        $this->mustache = new Mustache\Engine([
            'loader'          => new Mustache\Loader\FilesystemLoader($viewsFolder),
            'partials_loader' => new Mustache\Loader\FilesystemLoader($viewsFolder),
        ]);
    }

    public function render($viewName, $data = []) {
        $template = $this->mustache->loadTemplate($viewName);
        echo $template->render($data);
    }
}
 