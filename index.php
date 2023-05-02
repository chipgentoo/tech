<?php

/**
 * Main application class.
 */
final class Index {

    const DEFAULT_PAGE = 'welcome';
    const PAGE_DIR = './section/';
    const LAYOUT_DIR = './layout/';

    /**
     * System config.
     */
    public function init() {
        // error reporting - all errors for development (ensure you have display_errors = On in your php.ini file)
        error_reporting(E_ALL | E_STRICT);
        mb_internal_encoding('UTF-8');
        set_exception_handler(array($this, 'handleException'));
        spl_autoload_register(array($this, 'loadClass'));
        // session
        session_start();
    }

    /**
     * Run the application!
     */
    public function run() {
        $this->runPage($this->getPage());
    }

    /**
     * Exception handler.
     */
    public function handleException(Exception $ex) {
        $extra = array('message' => $ex->getMessage());
        if ($ex instanceof NotFoundException) {
            header('HTTP/1.0 404 Not Found');
            $this->runPage('404', $extra);
        } else {
            // TODO log exception
            header('HTTP/1.1 500 Internal Server Error');
            $this->runPage('500', $extra);
        }
    }

    /**
     * Class loader.
     */
    public function loadClass($name) {
        $classes = array(
            'Config' => './config/Config.class.php',
            'Error' => './class/Error.class.php',
            'NotFoundException' => './class/NotFoundException.class.php',
            'Utils' => './class/Utils.class.php',
            'TechDB' => './class/TechDB.class.php',
        );
        if (!array_key_exists($name, $classes)) {
            die('Class "' . $name . '" not found.');
        }
        require_once $classes[$name];
    }

    /**
     * @return mixed
     * @throws NotFoundException
     */
    private function getPage() {
        $page = self::DEFAULT_PAGE;
        if (array_key_exists('page', $_GET)) {
            $page = filter_input(INPUT_GET, 'page');
        }
        return $this->checkPage($page);
    }

    /**
     * @param string $page
     * @return string
     * @throws NotFoundException
     */
    private function checkPage($page) {
        if (!preg_match('/^[a-z0-9-]+$/i', $page)) {
            // TODO log attempt, redirect attacker, ...
            throw new NotFoundException('Unsafe page "' . $page . '" requested');
        }
        if (!$this->hasScript($page) && !$this->hasTemplate($page)) {
            // TODO log attempt, redirect attacker, ...
            throw new NotFoundException('Page "' . $page . '" not found');
        }
        return $page;
    }

    /**
     * @param $page
     * @param array $extra
     */
    private function runPage($page) {
        $run = false;
        if ($this->hasScript($page)) {
            $run = true;
            require $this->getScript($page);
        }
        if ($this->hasTemplate($page)) {
            $run = true;
            // data for main template
            $template = $this->getTemplate($page);
            // main template (layout)
            require self::LAYOUT_DIR . 'index.phtml';
        }
        if (!$run) {
            die('Page "' . $page . '" has neither script nor template!');
        }
    }

    /**
     * @return null|string
     */
    /*
      private function getAction() {
      $action = null;
      if (isset($_GET['action'])) {
      $action = '_' . filter_input(INPUT_GET, 'action');
      }
      return $action;
      }
     *
     */

    /**
     * @param string $page
     * @return string
     */
    private function getScript($page) {
        //return self::PAGE_DIR . $page . '/' . $page . $this->getAction() . '.php';
        return self::PAGE_DIR . $page . '/' . $page . '.php';
    }

    /**
     * @param string $page
     * @return string
     */
    private function getTemplate($page) {
        //return self::PAGE_DIR . $page . '/' . $page . $this->getAction() . '.phtml';
        return self::PAGE_DIR . $page . '/' . $page . '.phtml';
    }

    /**
     * @param string $page
     * @return bool
     */
    private function hasScript($page) {
        return file_exists($this->getScript($page));
    }

    /**
     * @param string $page
     * @return bool
     */
    private function hasTemplate($page) {
        return file_exists($this->getTemplate($page));
    }

}

$index = new Index();
$index->init();

global $TechDB;
$TechDB = new TechDB;

// run application!
$index->run();
