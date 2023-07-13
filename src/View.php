<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx;

class View {
    public string $title = "";
    public string $path = "";

    public function __construct(string $path) {
        $this->path = "/".$path;
    }

    // Renders the view
    public function renderView($view, $params = []) {
        // Render view before layout to load <head> content
        $viewContent = $this->renderOnlyView($view, $params);

        // Render layout
        $layoutContent = $this->layoutContent();

        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    // Render {{content}} string within file
    public function renderContent($viewContent) {
        $layoutContent = $this->layoutContent();
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    // Handles the layout file buffer
    protected function layoutContent() {
        // Sets a default layout (no controller present)
        $layout = Jinx::$jinx->layout;

        // If a layout is available from the controller, set it
        // NOTE: This allows a 404 page layout to be seen
        if (Jinx::$jinx->controller) {
            $layout = Jinx::$jinx->controller->layout;
        }

        ob_start();
        include_once Jinx::$ROOT_DIR.$this->path."views/layouts/$layout.php";
        return ob_get_clean();
    }

    // Renders the correct view based on path
    protected function renderOnlyView($view, $params = []) {
        // Iterates over the params array to locate all available key/value pairs
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Jinx::$ROOT_DIR.$this->path."views/$view.php";

        return ob_get_clean();
    }
}

?>
