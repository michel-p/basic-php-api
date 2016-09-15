<?php

namespace BasicPHPAPI\DAO;

use PDO;

/**
 * Class SongDAO
 */
class SongDAO extends AbstractDAO
{
    public function __construct($DB)
    {
        parent::__construct($DB);
    }

    /**
     * Retrieve basic information of a song
     * @param $id
     * @return mixed
     */
    public function findById($id){
        $song = $this->DB->query("SELECT s.* FROM song s WHERE s.id = $id")->fetch(PDO::FETCH_ASSOC);
        return $song;
    }
}