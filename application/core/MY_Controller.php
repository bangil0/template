<?php
defined('BASEPATH') or exit('No direct script access allowed');

abstract class MY_Controller extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->uauth->authorization();
    }
}
