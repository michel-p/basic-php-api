<?php

namespace BasicPHPAPI\API;

use BasicPHPAPI\Database\PDOSingleton;
use BasicPHPAPI\Json\JSONResponse;
use BasicPHPAPI\DAO\UserDAO;
use BasicPHPAPI\DAO\SongDAO;
use Exception;

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
        $this->DB = new PDOSingleton(_PDO_DSN_, _DB_USER_, _DB_PASSWORD_);
        $this->jsonResponse = new JSONResponse();
    }

    /**
     * Handles all possible requests for the USER model
     * @return JSONResponse
     */
    protected function users()
    {
        if(empty($this->args)) {
            $this->jsonResponse->setStatusFailure();
            $this->jsonResponse->setDataCallIncomplete();
        }
        else{
            $userDAO = new UserDAO($this->DB);
            /**
             * FAVORITE SONGS OF USER
             */
            if ($this->endPointAction === 'favorites') {
                switch ($this->method) {
                    case 'DELETE':
                        /**
                         * delete a song in the favorite playlist
                         */
                        if(count($this->args) == 2){
                            $deletion = $userDAO->deleteSongFromFavorites($this->args[0], $this->args[1]);
                            $this->jsonResponse->setStatusSuccess();
                            $this->jsonResponse->data = array('deletion' => $deletion);
                        }
                        else{
                            $this->jsonResponse->setStatusFailure();
                            $this->jsonResponse->setDataCallIncomplete();
                        }
                        break;
                    case 'POST':
                        /**
                         * add an existing song to the favorite list
                         */
                        if(count($this->args) == 2){
                            $addition = $userDAO->addExistingSongToFavorites($this->args[0], $this->args[1]);
                            $this->jsonResponse->setStatusSuccess();
                            $this->jsonResponse->data = array('addition' => $addition);
                        }
                        else{
                            $this->jsonResponse->setStatusFailure();
                            $this->jsonResponse->setDataCallIncomplete();
                        }
                        break;
                    case 'GET':
                        /**
                         * return all favorite songs
                         */
                        try{
                            $favoritesSongsCollection = $userDAO->getFavoriteSongs($this->args[0]);
                            $this->jsonResponse->setStatusSuccess();
                            $this->jsonResponse->data = array('favorite_songs' => $favoritesSongsCollection);
                        } catch (Exception $e){
                            $this->jsonResponse->setStatusFailure();
                            $this->jsonResponse->data = array( $e->getCode() => $e->getMessage());
                        }
                        break;
                    case 'PUT':
                        $this->jsonResponse->setStatusFailure();
                        $this->jsonResponse->setDataMethodNotImplemented();
                        break;
                }
            } else {
                /**
                 * BASIC CRUD FOR USER
                 */
                switch ($this->method) {
                    case 'DELETE':
                        $this->jsonResponse->setStatusFailure();
                        $this->jsonResponse->setDataMethodNotImplemented();
                        break;
                    case 'POST':
                        $this->jsonResponse->setStatusFailure();
                        $this->jsonResponse->setDataMethodNotImplemented();
                        break;
                    case 'GET':
                        /**
                         * retrieve user basic informations
                         */
                        try{
                            $user = $userDAO->findById($this->args[0]);
                            $this->jsonResponse->setStatusSuccess();
                            $this->jsonResponse->data = array('user' => $user);
                        } catch (Exception $e){
                            $this->jsonResponse->setStatusFailure();
                            $this->jsonResponse->data = array( $e->getCode() => $e->getMessage());
                        }
                        break;
                    case 'PUT':
                        $this->jsonResponse->setStatusFailure();
                        $this->jsonResponse->setDataMethodNotImplemented();
                        break;
                }
            }
        }
        return $this->jsonResponse;
    }

    /**
     * Handles all requests for the Song Model
     * @return JSONResponse
     */
    protected function songs()
    {
        if(empty($this->args)) {
            $this->jsonResponse->setStatusFailure();
            $this->jsonResponse->setDataCallIncomplete();
        }
        else {
            $songDAO = new SongDAO($this->DB);
            switch ($this->method) {
                case 'DELETE':
                    $this->jsonResponse->setStatusFailure();
                    $this->jsonResponse->setDataMethodNotImplemented();
                    break;
                case 'POST':
                    $this->jsonResponse->setStatusFailure();
                    $this->jsonResponse->setDataMethodNotImplemented();
                    break;
                case 'GET':
                    try {
                        $song = $songDAO->findById($this->args[0]);
                        $this->jsonResponse->setStatusSuccess();
                        $this->jsonResponse->data = array('song' => $song);
                    } catch (Exception $e) {
                        $this->jsonResponse->setStatusFailure();
                        $this->jsonResponse->data = array($e->getCode() => $e->getMessage());
                    }
                    break;
                case 'PUT':
                    $this->jsonResponse->setStatusFailure();
                    $this->jsonResponse->setDataMethodNotImplemented();
                    break;
            }
        }
        return $this->jsonResponse;
    }
}