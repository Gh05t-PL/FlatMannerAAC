<?php
namespace App\Utils\Strategy\Accounts;

interface IAccountsStrategy {

    /**
     * @return [Account Entity] from version folder
     */
    public function getAccountById($id);

    /**
     * @return [Player Entity Array] from version folder
     */
    public function getAccountChars($id);

    /**
     * @param [Associative Array] of criteria eg. ['name' => 'test'] $criteria
     * 
     * @return Account Entity from version folder
     */
    public function getAccountBy($criteria);

    /**
     * @return boolean
     */
    public function isPlayerName($name);

    /**
     * @param array $formData | Data from sent form
     * @param int $accId
     * @param array $cfg | Config from Utils/Configs.php
     */
    public function createCharacter($formData, $accId, $cfg);

    /**
     * @param int $accId
     */
    public function getNoGuildPlayers($accId);

    /**
     * @param int $accId
     * @param [Associative Array] $changes
     */
    public function changeAccountDetails($accId, $changes);
  
}