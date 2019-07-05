
<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Ci_rapi {
    //set mode, default is object
    private $_modeArray = FALSE;

    private $_rajaApiToken     = "";
    private $_rajaApiBaseUrl   = "";
    private $_rajaApiTokenUrl  = "https://x.rajaapi.com/poe";
    private $_provinsiUrlPath  = "wilayah/provinsi";
    private $_kabupatenUrlPath = "wilayah/kabupaten";
    private $_kecamatanUrlPath = "wilayah/kecamatan";
    private $_kelurahanUrlPath = "wilayah/kelurahan";

    //private var for setup
    private $_url  = '';
    private $_args = '';


    public function __construct(){

        $rajaApi = $this->check();
        if(! $rajaApi->success)
            throw new Exception("Raja Api tidak Berfungsi", 1);
        
        $this->_rajaApiToken = $rajaApi->token;
        $this->_rajaApiBaseUrl = "https://x.rajaapi.com/MeP7c5ne".$this->_rajaApiToken."/m/";
    }

    /**
     * getProvinsi
     *
     * @return data
     */
    public function getProvinsi(){
        $this->setUrl($this->_provinsiUrlPath);
        return $this->fetch();
    }

    /**
     * getKabupaten
     *
     * @param  int $id
     *
     * @return data
     */
    public function getKabupaten($id){
        $this->setArgs('idpropinsi',$id);
        $this->setUrl($this->_kabupatenUrlPath);
        return $this->fetch();
    }

    /**
     * getKecamatan
     *
     * @param  int $id
     *
     * @return data
     */
    public function getKecamatan($id){
        $this->setArgs('idkabupaten',$id);
        $this->setUrl($this->_kecamatanUrlPath);
        return $this->fetch();
    }

    /**
     * getKelurahan
     *
     * @param  int $id
     *
     * @return data
     */
    public function getKelurahan($id){
        $this->setArgs('idkecamatan',$id);
        $this->setUrl($this->_kelurahanUrlPath);
        return $this->fetch();
    }

    /**
     * setArgs
     *
     * @param  string $param
     * @param  int $value
     *
     * @return string
     */
    public function setArgs($param, $value){
        $this->_args = '?'.$param.'='.$value;
        return $this->_args;
    }

    /**
     * setUrl
     *
     * @param  string $activeUrl
     *
     * @return string 
     */
    public function setUrl($activeUrl){
        $this->_url = $activeUrl;
        return $this->_url;
    }

    /**
     * fetch
     *
     * @param  string $setUrl
     *
     * @return data
     */
    public function fetch($setUrl = ''){
        //using curl
        if($setUrl == '')
            $url = $this->_rajaApiBaseUrl.$this->_url.$this->_args;
        else
            $url = $setUrl;

        // Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will return a beauty json :3
        return json_decode($result,$this->_modeArray);
    }

    /**
     * isActive
     *
     * @return boolean
     */
    public function isActive(){
        $rajaApi = $this->fetch($this->_rajaApiTokenUrl);
        if($this->_modeArray)
            return $rajaApi['success'];
        else
            return $rajaApi->success;

    }

    /**
     * check
     *
     * @return boolean
     */
    private function check(){
        // Initiate curl
        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $this->_rajaApiTokenUrl);
        // Execute
        $result = curl_exec($ch);
        // Closing
        curl_close($ch);

        // Will return a beauty json :3
        return json_decode($result);
    }
}
