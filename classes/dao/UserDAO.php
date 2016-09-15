<?php

namespace BasicPHPAPI\DAO;

use PDO;

/**
 * Class UserDAO
 * Handles all function which retrieve or store data in the Database
 */
class UserDAO extends AbstractDAO
{

    public function __construct($DB)
    {
        parent::__construct($DB);
    }

    /**
     * fetch user basic informations in an associative array
     * @param $id
     * @return mixed
     */
    public function findById($id){
        $user = $this->DB->query("SELECT u.* FROM user u WHERE u.id = $id")->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    /**
     * Get the list of favorite songs of the user
     * @param $userId
     * @return mixed
     */
    public function getFavoriteSongs($userId){
        return $this->DB->queryFetchAllAssoc("SELECT s.* FROM user u, song s, favorite_songs fs WHERE fs.user_id = u.id AND fs.song_id = s.id AND u.id = $userId");
    }

    /**
     * Add a pre-existing song in the favorite song list of the user
     * @param $userId
     * @param $songId
     * @return mixed
     */
    public function addExistingSongToFavorites($userId, $songId){
        return $this->DB->exec("INSERT INTO favorite_songs VALUES (null, $userId, $songId)");
    }

    /**
     * Delete a song from the favorite playlist of a user
     * @param $userId
     * @param $songId
     * @return mixed
     */
    public function deleteSongFromFavorites($userId, $songId){
        return $this->DB->exec("DELETE FROM favorite_songs WHERE user_id = $userId AND song_id = $songId");
    }

}