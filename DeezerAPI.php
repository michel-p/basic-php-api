<?php

require_once 'AbstractAPI.php';
require_once 'dao/AbstractDAO.php';
require_once 'dao/UserDAO.php';
require_once 'dao/SongDAO.php';
require_once 'database/config.php';
require_once 'database/PDOSingleton.php';
require_once 'database/JSONResponse.php';

/**
 * Class DeezerAPI
 * Implements all the endpoints for Deezer Models
 * HTTP Methods which are not implemented return a predefined message
 */
class DeezerAPI extends AbstractAPI
{
    private $DB;
    private $jsonResponse;

    public function __construct($request)
    {
        parent::__construct($request);
    }

    /**
     * Handles all possible requests for the USER model
     * @return JSONResponse
     */
    protected function user()
    {
    }

    /**
     * Handles all requests for the Song Model
     * @return JSONResponse
     */
    protected function song()
    {

    }
}