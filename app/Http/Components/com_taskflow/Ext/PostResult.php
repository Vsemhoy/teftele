<?php

namespace App\Http\Components\com_taskflow\Ext;
use stdClass;

class PostResult
{
    public string $status;
    public int $code;
    public int $user;
    public int $item_id;
    public string $log_section;
    public int $log_action;
    public stdClass $object;
    public $objects;
    public string $message;
    public string $method;

    public function __construct($uid){
        $this->status = "NOK";
        $this->code = 1;
        $this->user = $uid;
        $this->item_id = -1;
        $this->log_section = 'none';
        $this->log_section = 0;
        $this->object = (object) array();
        $this->objects = [];
        $this->message = "";
        $this->method = "";
    }
}
