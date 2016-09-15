<?php

namespace BasicPHPAPI\Json;
/**
 * a JSON class that represents what the API will always return
 */
class JSONResponse
{
    const _STATUS_SUCCESS_ = "success";
    const _STATUS_FAIL_ = "fail";
    const _STATUS_ERROR_ = "error";

    const _DATA_FAIL_CALL_INCOMPLETE_ = array("invalid call" => "The API call is invalid or incomplete. Please check documentation");
    const _DATA_FAIL_NOT_IMPLEMENTED_ = array("not implemented yet" => "The API call is valid but response is not implemented yet");

    public $status;
    public $data;
    public $message;

    /**
     * JSONResponse constructor.
     */
    public function __construct()
    {
    }

    public function setStatusSuccess()
    {
        $this->status = self::_STATUS_SUCCESS_;
    }

    public function setStatusFailure()
    {
        $this->status = self::_STATUS_FAIL_;
    }

    public function setStatusError()
    {
        $this->status = self::_STATUS_ERROR_;
    }

    public function setDataCallIncomplete()
    {
        $this->data = self::_DATA_FAIL_CALL_INCOMPLETE_;
    }

    public function setDataMethodNotImplemented()
    {
        $this->data = self::_DATA_FAIL_NOT_IMPLEMENTED_;
    }

}