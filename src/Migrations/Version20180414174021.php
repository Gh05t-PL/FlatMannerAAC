<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180414174021 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE guild_invites DROP FOREIGN KEY guild_invites_ibfk_2');
        $this->addSql('ALTER TABLE guild_ranks DROP FOREIGN KEY guild_ranks_ibfk_1');
        $this->addSql('ALTER TABLE house_auctions DROP FOREIGN KEY house_auctions_ibfk_1');
        $this->addSql('ALTER TABLE house_data DROP FOREIGN KEY house_data_ibfk_1');
        $this->addSql('ALTER TABLE house_lists DROP FOREIGN KEY house_lists_ibfk_1');
        $this->addSql('ALTER TABLE tiles DROP FOREIGN KEY tiles_ibfk_1');
        $this->addSql('ALTER TABLE environment_killers DROP FOREIGN KEY environment_killers_ibfk_1');
        $this->addSql('ALTER TABLE player_killers DROP FOREIGN KEY player_killers_ibfk_1');
        $this->addSql('ALTER TABLE killers DROP FOREIGN KEY killers_ibfk_1');
        $this->addSql('ALTER TABLE account_viplist DROP FOREIGN KEY account_viplist_ibfk_2');
        $this->addSql('ALTER TABLE guild_invites DROP FOREIGN KEY guild_invites_ibfk_1');
        $this->addSql('ALTER TABLE house_auctions DROP FOREIGN KEY house_auctions_ibfk_2');
        $this->addSql('ALTER TABLE player_deaths DROP FOREIGN KEY player_deaths_ibfk_1');
        $this->addSql('ALTER TABLE player_depotitems DROP FOREIGN KEY player_depotitems_ibfk_1');
        $this->addSql('ALTER TABLE player_items DROP FOREIGN KEY player_items_ibfk_1');
        $this->addSql('ALTER TABLE player_killers DROP FOREIGN KEY player_killers_ibfk_2');
        $this->addSql('ALTER TABLE player_namelocks DROP FOREIGN KEY player_namelocks_ibfk_1');
        $this->addSql('ALTER TABLE player_skills DROP FOREIGN KEY player_skills_ibfk_1');
        $this->addSql('ALTER TABLE player_spells DROP FOREIGN KEY player_spells_ibfk_1');
        $this->addSql('ALTER TABLE player_storage DROP FOREIGN KEY player_storage_ibfk_1');
        $this->addSql('ALTER TABLE player_viplist DROP FOREIGN KEY player_viplist_ibfk_1');
        $this->addSql('ALTER TABLE player_viplist DROP FOREIGN KEY player_viplist_ibfk_2');
        $this->addSql('ALTER TABLE server_reports DROP FOREIGN KEY server_reports_ibfk_1');
        $this->addSql('ALTER TABLE tile_items DROP FOREIGN KEY tile_items_ibfk_1');
        $this->addSql('DROP TABLE account_viplist');
        $this->addSql('DROP TABLE bans');
        $this->addSql('DROP TABLE environment_killers');
        $this->addSql('DROP TABLE global_storage');
        $this->addSql('DROP TABLE guild_invites');
        $this->addSql('DROP TABLE guild_ranks');
        $this->addSql('DROP TABLE guilds');
        $this->addSql('DROP TABLE house_auctions');
        $this->addSql('DROP TABLE house_data');
        $this->addSql('DROP TABLE house_lists');
        $this->addSql('DROP TABLE houses');
        $this->addSql('DROP TABLE killers');
        $this->addSql('DROP TABLE player_deaths');
        $this->addSql('DROP TABLE player_depotitems');
        $this->addSql('DROP TABLE player_items');
        $this->addSql('DROP TABLE player_killers');
        $this->addSql('DROP TABLE player_namelocks');
        $this->addSql('DROP TABLE player_skills');
        $this->addSql('DROP TABLE player_spells');
        $this->addSql('DROP TABLE player_storage');
        $this->addSql('DROP TABLE player_viplist');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE server_config');
        $this->addSql('DROP TABLE server_motd');
        $this->addSql('DROP TABLE server_record');
        $this->addSql('DROP TABLE server_reports');
        $this->addSql('DROP TABLE tile_items');
        $this->addSql('DROP TABLE tiles');
        $this->addSql('DROP INDEX name ON accounts');
        $this->addSql('ALTER TABLE accounts CHANGE name name VARCHAR(32) NOT NULL, CHANGE premdays premdays INT NOT NULL, CHANGE lastday lastday INT NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE `key` `key` VARCHAR(20) NOT NULL, CHANGE blocked blocked INT NOT NULL, CHANGE warnings warnings INT NOT NULL, CHANGE group_id group_id INT NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE account_viplist (account_id INT NOT NULL, player_id INT NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX account_id_2 (account_id, player_id), INDEX account_id (account_id), INDEX player_id (player_id), INDEX world_id (world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bans (id INT UNSIGNED AUTO_INCREMENT NOT NULL, type TINYINT(1) NOT NULL COMMENT \'1 - ip banishment, 2 - namelock, 3 - account banishment, 4 - notation, 5 - deletion\', value INT UNSIGNED NOT NULL COMMENT \'ip address (integer), player guid or account number\', param INT UNSIGNED DEFAULT 4294967295 NOT NULL COMMENT \'used only for ip banishment mask (integer)\', active TINYINT(1) DEFAULT \'1\' NOT NULL, expires INT NOT NULL, added INT UNSIGNED NOT NULL, admin_id INT UNSIGNED DEFAULT 0 NOT NULL, comment TEXT NOT NULL COLLATE latin1_swedish_ci, reason INT UNSIGNED DEFAULT 0 NOT NULL, action INT UNSIGNED DEFAULT 0 NOT NULL, statement VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE latin1_swedish_ci, INDEX type (type, value), INDEX active (active), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE environment_killers (kill_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, INDEX kill_id (kill_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE global_storage (`key` INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, value VARCHAR(255) DEFAULT \'0\' NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX `key` (`key`, world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guild_invites (player_id INT DEFAULT 0 NOT NULL, guild_id INT DEFAULT 0 NOT NULL, UNIQUE INDEX player_id (player_id, guild_id), INDEX guild_id (guild_id), INDEX IDX_33C4A4F399E6F5DF (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guild_ranks (id INT AUTO_INCREMENT NOT NULL, guild_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, level INT NOT NULL COMMENT \'1 - leader, 2 - vice leader, 3 - member\', INDEX guild_id (guild_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guilds (id INT AUTO_INCREMENT NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, ownerid INT NOT NULL, creationdata INT NOT NULL, motd VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX name (name, world_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house_auctions (house_id INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, player_id INT NOT NULL, bid INT UNSIGNED DEFAULT 0 NOT NULL, `limit` INT UNSIGNED DEFAULT 0 NOT NULL, endtime BIGINT UNSIGNED DEFAULT 0 NOT NULL, UNIQUE INDEX house_id (house_id, world_id), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house_data (house_id INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, data LONGBLOB NOT NULL, UNIQUE INDEX house_id (house_id, world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE house_lists (house_id INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, listid INT NOT NULL, list TEXT NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX house_id (house_id, world_id, listid), INDEX IDX_D3C5385D6BB745158925311C (house_id, world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE houses (id INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, owner INT NOT NULL, paid INT UNSIGNED DEFAULT 0 NOT NULL, warnings INT DEFAULT 0 NOT NULL, lastwarning INT UNSIGNED DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, town INT UNSIGNED DEFAULT 0 NOT NULL, size INT UNSIGNED DEFAULT 0 NOT NULL, price INT UNSIGNED DEFAULT 0 NOT NULL, rent INT UNSIGNED DEFAULT 0 NOT NULL, doors INT UNSIGNED DEFAULT 0 NOT NULL, beds INT UNSIGNED DEFAULT 0 NOT NULL, tiles INT UNSIGNED DEFAULT 0 NOT NULL, guild TINYINT(1) DEFAULT \'0\' NOT NULL, clear TINYINT(1) DEFAULT \'0\' NOT NULL, UNIQUE INDEX id (id, world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE killers (id INT AUTO_INCREMENT NOT NULL, death_id INT NOT NULL, final_hit TINYINT(1) DEFAULT \'0\' NOT NULL, unjustified TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX death_id (death_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_deaths (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, date BIGINT UNSIGNED NOT NULL, level INT UNSIGNED NOT NULL, INDEX date (date), INDEX player_id (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_depotitems (player_id INT NOT NULL, sid INT NOT NULL COMMENT \'any given range, eg. 0-100 is reserved for depot lockers and all above 100 will be normal items inside depots\', pid INT DEFAULT 0 NOT NULL, itemtype INT NOT NULL, count INT DEFAULT 0 NOT NULL, attributes BLOB NOT NULL, UNIQUE INDEX player_id_2 (player_id, sid), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_items (player_id INT DEFAULT 0 NOT NULL, pid INT DEFAULT 0 NOT NULL, sid INT DEFAULT 0 NOT NULL, itemtype INT DEFAULT 0 NOT NULL, count INT DEFAULT 0 NOT NULL, attributes BLOB NOT NULL, UNIQUE INDEX player_id_2 (player_id, sid), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_killers (kill_id INT NOT NULL, player_id INT NOT NULL, INDEX kill_id (kill_id), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_namelocks (player_id INT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, new_name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, date BIGINT DEFAULT 0 NOT NULL, INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_skills (player_id INT DEFAULT 0 NOT NULL, skillid TINYINT(1) DEFAULT \'0\' NOT NULL, value INT UNSIGNED DEFAULT 0 NOT NULL, count INT UNSIGNED DEFAULT 0 NOT NULL, UNIQUE INDEX player_id_2 (player_id, skillid), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_spells (player_id INT NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX player_id_2 (player_id, name), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_storage (player_id INT DEFAULT 0 NOT NULL, `key` INT UNSIGNED DEFAULT 0 NOT NULL, value VARCHAR(255) DEFAULT \'0\' NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX player_id_2 (player_id, `key`), INDEX player_id (player_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_viplist (player_id INT NOT NULL, vip_id INT NOT NULL, UNIQUE INDEX player_id_2 (player_id, vip_id), INDEX player_id (player_id), INDEX vip_id (vip_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE players (id INT AUTO_INCREMENT NOT NULL, account_id INT DEFAULT 0 NOT NULL, name VARCHAR(255) NOT NULL COLLATE latin1_swedish_ci, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, group_id INT DEFAULT 1 NOT NULL, level INT DEFAULT 1 NOT NULL, vocation INT DEFAULT 0 NOT NULL, health INT DEFAULT 150 NOT NULL, healthmax INT DEFAULT 150 NOT NULL, experience BIGINT DEFAULT 0 NOT NULL, lookbody INT DEFAULT 0 NOT NULL, lookfeet INT DEFAULT 0 NOT NULL, lookhead INT DEFAULT 0 NOT NULL, looklegs INT DEFAULT 0 NOT NULL, looktype INT DEFAULT 136 NOT NULL, lookaddons INT DEFAULT 0 NOT NULL, maglevel INT DEFAULT 0 NOT NULL, mana INT DEFAULT 0 NOT NULL, manamax INT DEFAULT 0 NOT NULL, manaspent INT DEFAULT 0 NOT NULL, soul INT UNSIGNED DEFAULT 0 NOT NULL, town_id INT DEFAULT 0 NOT NULL, posx INT DEFAULT 0 NOT NULL, posy INT DEFAULT 0 NOT NULL, posz INT DEFAULT 0 NOT NULL, conditions BLOB NOT NULL, cap INT DEFAULT 0 NOT NULL, sex INT DEFAULT 0 NOT NULL, lastlogin BIGINT UNSIGNED DEFAULT 0 NOT NULL, lastip INT UNSIGNED DEFAULT 0 NOT NULL, save TINYINT(1) DEFAULT \'1\' NOT NULL, skull TINYINT(1) DEFAULT \'0\' NOT NULL, skulltime INT DEFAULT 0 NOT NULL, rank_id INT DEFAULT 0 NOT NULL, guildnick VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE latin1_swedish_ci, lastlogout BIGINT UNSIGNED DEFAULT 0 NOT NULL, blessings TINYINT(1) DEFAULT \'0\' NOT NULL, balance BIGINT DEFAULT 0 NOT NULL, stamina BIGINT DEFAULT 151200000 NOT NULL COMMENT \'stored in miliseconds\', direction INT DEFAULT 2 NOT NULL, loss_experience INT DEFAULT 100 NOT NULL, loss_mana INT DEFAULT 100 NOT NULL, loss_skills INT DEFAULT 100 NOT NULL, loss_containers INT DEFAULT 100 NOT NULL, loss_items INT DEFAULT 100 NOT NULL, premend INT DEFAULT 0 NOT NULL COMMENT \'NOT IN USE BY THE SERVER\', online TINYINT(1) DEFAULT \'0\' NOT NULL, marriage INT UNSIGNED DEFAULT 0 NOT NULL, promotion INT DEFAULT 0 NOT NULL, deleted TINYINT(1) DEFAULT \'0\' NOT NULL, description VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX name (name, deleted), INDEX account_id (account_id), INDEX group_id (group_id), INDEX online (online), INDEX deleted (deleted), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_config (config VARCHAR(35) DEFAULT \'\' NOT NULL COLLATE latin1_swedish_ci, value INT NOT NULL, UNIQUE INDEX config (config)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_motd (id INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, text TEXT NOT NULL COLLATE latin1_swedish_ci, UNIQUE INDEX id (id, world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_record (record INT NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, timestamp BIGINT NOT NULL, UNIQUE INDEX record (record, world_id, timestamp)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE server_reports (id INT AUTO_INCREMENT NOT NULL, player_id INT DEFAULT 1 NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, posx INT DEFAULT 0 NOT NULL, posy INT DEFAULT 0 NOT NULL, posz INT DEFAULT 0 NOT NULL, timestamp BIGINT DEFAULT 0 NOT NULL, report TEXT NOT NULL COLLATE latin1_swedish_ci, `reads` INT DEFAULT 0 NOT NULL, INDEX world_id (world_id), INDEX `reads` (`reads`), INDEX player_id (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tile_items (tile_id INT UNSIGNED NOT NULL, world_id TINYINT(1) DEFAULT \'0\' NOT NULL, sid INT NOT NULL, pid INT DEFAULT 0 NOT NULL, itemtype INT NOT NULL, count INT DEFAULT 0 NOT NULL, attributes BLOB NOT NULL, UNIQUE INDEX tile_id (tile_id, world_id, sid), INDEX sid (sid), INDEX IDX_68C608AF638AF48B (tile_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tiles (world_id TINYINT(1) DEFAULT \'0\' NOT NULL, house_id INT UNSIGNED NOT NULL, id INT UNSIGNED NOT NULL, x INT UNSIGNED NOT NULL, y INT UNSIGNED NOT NULL, z TINYINT(1) NOT NULL, UNIQUE INDEX id (id, world_id), INDEX x (x, y, z), INDEX house_id (house_id, world_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE account_viplist ADD CONSTRAINT account_viplist_ibfk_1 FOREIGN KEY (account_id) REFERENCES accounts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE account_viplist ADD CONSTRAINT account_viplist_ibfk_2 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE environment_killers ADD CONSTRAINT environment_killers_ibfk_1 FOREIGN KEY (kill_id) REFERENCES killers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guild_invites ADD CONSTRAINT guild_invites_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guild_invites ADD CONSTRAINT guild_invites_ibfk_2 FOREIGN KEY (guild_id) REFERENCES guilds (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE guild_ranks ADD CONSTRAINT guild_ranks_ibfk_1 FOREIGN KEY (guild_id) REFERENCES guilds (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE house_auctions ADD CONSTRAINT house_auctions_ibfk_1 FOREIGN KEY (house_id, world_id) REFERENCES houses (id, world_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE house_auctions ADD CONSTRAINT house_auctions_ibfk_2 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE house_data ADD CONSTRAINT house_data_ibfk_1 FOREIGN KEY (house_id, world_id) REFERENCES houses (id, world_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE house_lists ADD CONSTRAINT house_lists_ibfk_1 FOREIGN KEY (house_id, world_id) REFERENCES houses (id, world_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE killers ADD CONSTRAINT killers_ibfk_1 FOREIGN KEY (death_id) REFERENCES player_deaths (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_deaths ADD CONSTRAINT player_deaths_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_depotitems ADD CONSTRAINT player_depotitems_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_items ADD CONSTRAINT player_items_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_killers ADD CONSTRAINT player_killers_ibfk_1 FOREIGN KEY (kill_id) REFERENCES killers (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_killers ADD CONSTRAINT player_killers_ibfk_2 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_namelocks ADD CONSTRAINT player_namelocks_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_skills ADD CONSTRAINT player_skills_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_spells ADD CONSTRAINT player_spells_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_storage ADD CONSTRAINT player_storage_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_viplist ADD CONSTRAINT player_viplist_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE player_viplist ADD CONSTRAINT player_viplist_ibfk_2 FOREIGN KEY (vip_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT players_ibfk_1 FOREIGN KEY (account_id) REFERENCES accounts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE server_reports ADD CONSTRAINT server_reports_ibfk_1 FOREIGN KEY (player_id) REFERENCES players (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tile_items ADD CONSTRAINT tile_items_ibfk_1 FOREIGN KEY (tile_id) REFERENCES tiles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tiles ADD CONSTRAINT tiles_ibfk_1 FOREIGN KEY (house_id, world_id) REFERENCES houses (id, world_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accounts CHANGE name name VARCHAR(32) DEFAULT \'\' NOT NULL COLLATE latin1_swedish_ci, CHANGE premdays premdays INT DEFAULT 0 NOT NULL, CHANGE lastday lastday INT UNSIGNED DEFAULT 0 NOT NULL, CHANGE email email VARCHAR(255) DEFAULT \'\' NOT NULL COLLATE latin1_swedish_ci, CHANGE `key` `key` VARCHAR(20) DEFAULT \'0\' NOT NULL COLLATE latin1_swedish_ci, CHANGE blocked blocked TINYINT(1) DEFAULT \'0\' NOT NULL COMMENT \'internal usage\', CHANGE warnings warnings INT DEFAULT 0 NOT NULL, CHANGE group_id group_id INT DEFAULT 1 NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX name ON accounts (name)');
    }
}
