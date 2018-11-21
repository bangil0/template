<?php
defined('BASEPATH') OR exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller {

	function __construct()
    {
        parent::__construct();
        //Minified Every HTML and JS on view
        $this->ci_minifier->enable_obfuscator();
        $this->uauth->authorization();
        
    }
    
}
