<?php
namespace App\Utils\Strategy\Guilds;

interface IGuildsStrategy {
    
    public function getGuildsList();

    public function getGuildById($id);

    public function getGuildBy($criteria);

    public function getGuildMembers($id);

    public function getGuildInvites($id);

    public function getGuildRanks($gId);

    public function getAccountGuildRank($aId, $members);

    //public function getPlayerGuildRank($pId, $members);

    /**
     * @param $data [ASSOCIATIVE ARRAY] ['name' => string(guild_name), 'leader' => int(player_id)]
     */
    public function createGuild($data);

    public function deleteGuild($id);

    /**
     * @param $data [ASSOCIATIVE ARRAY] ['guildId' => int(guild_id), 'rankId' => int(rank_id), 'playerId' => int(player_id)]
     */
    public function acceptInvite($data);

    public function leaveGuild($pId);
    
    public function isMember($pId);
}