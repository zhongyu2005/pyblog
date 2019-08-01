<?php

namespace common\components;

class Redis extends \Redis
{
    public $host;
    public $port;
    public $password;
    public $database;
    public $pconnect = 0;
    public $isCon = false;
    public $timeout = 3;


    public function init()
    {

        if ($this->isCon === false) {
            if ($this->pconnect) {
                parent::pconnect($this->host, $this->port, $this->timeout);
            } else {
                parent::connect($this->host, $this->port, $this->timeout);
            }
            if ($this->password) {
                parent::auth($this->password);
            }
            if ($this->database) {
                parent::select($this->database);
            } else {
                parent::select(0);

            }
            $this->isCon = true;
        }
    }
}