<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH."/third_party/Classes/ExlReader.php";
class Reader extends ExlReader {
    public function __construct() {
        parent::__construct();
    }
}