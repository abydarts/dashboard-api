<?php
/**
 * Api base controller
 * @package api
 * @version 0.0.1
 */

namespace Api;

use Api\Library\Handler;

class Controller extends \Mim\Controller
    implements \Mim\Iface\GateController
{
    public function show404(): void{
        $this->resp(404);
    }

    public function show404Action(): void{
        $this->show404();
    }

    public function show500(object $error): void{
        $data = null;
        if(is_dev())
            $data = $error;
        $this->resp(500, $data, $error->text);
    }

    public function show500Action(): void{
        $this->show500(\Mim\Library\Logger::$last_error);
    }

    public function resp(int $error=0, $data=null, string $message=null, array $meta=null): void{

        if(is_null($message) && is_string($data)){
            $message = $data;
            $data = null;
        }

        if(!$message)
            $message = Handler::messageByError($error);

        if($error == 200)
            $error = 0;

        $resFormat = $this->config->api->resFormat ?? null;
        if(!$resFormat)
            $resFormat = 'Api\\Library\\Handler';
        
        list($content, $mime) = $resFormat::resp($this, $error, $data, $message, $meta);

        $this->res->addHeader('Connection', 'close');
        $this->res->addHeader('Content-Type', $mime, false);
        $this->res->addHeader('Content-Length', strlen($content));

        // $this->res->addHeader('Access-Control-Allow-Origin', '*');
        // $this->res->addHeader('Access-Control-Allow-Methods', 'POST, GET, PUT, OPTIONS, DELETE');
        // $this->res->addHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type');
        
        $this->res->addContent($content);

        $this->res->send();
    }
}