<?php

namespace App\Db;

class Mysql 
{
    private $db_name;
    private $db_user;
    private $db_password;
    private $db_host;
    private $db_port;
    private $pdo = null;
    private static $_instance = null;

    private function __construct()
    {
        $conf = require_once _ROOTPATH_.'/db_config.php';

        if (isset($conf['db_name'])) {
            $this->db_name = $conf['db_name'];
        }
        if (isset($conf['db_user'])) {
            $this->db_user = $conf['db_user'];
        }
        if (isset($conf['db_password'])) {
            $this->db_password = $conf['db_password'];
        }
        if (isset($conf['db_host'])) {
            $this->db_host = $conf['db_host'];
        }
        if (isset($conf['db_port'])) {
            $this->db_port = $conf['db_port'];
        }

    }

    public static function getInstance():self
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Mysql();
            // self::$_instance->createTables();
            // self::$_instance->insertData();
        }
        return self::$_instance;
    }

    public function getPDO():\PDO
    {
        if (is_null($this->pdo)) {
            $this->pdo = new \PDO('mysql:dbname=' . $this->db_name . ';charset=utf8;host=' . $this->db_host.':'.$this->db_port, $this->db_user, $this->db_password);        }
        return $this->pdo;
    }

    public function createTables()
    {
        $createProductTable = "
            DROP TABLE IF EXISTS `article`;
            CREATE TABLE IF NOT EXISTS `article` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            DROP TABLE IF EXISTS `comment`;
            CREATE TABLE IF NOT EXISTS `comment` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
            `user_id` int(11) UNSIGNED NOT NULL,
            `article_id` int(11) UNSIGNED NOT NULL,
            PRIMARY KEY (`id`),
            KEY `article_id` (`article_id`),
            KEY `user_id` (`user_id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

            DROP TABLE IF EXISTS `user`;
            CREATE TABLE IF NOT EXISTS `user` (
            `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `first_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `last_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
        $this->getPDO()->exec($createProductTable);
    }

    public function insertData()
    {
        $insertProductData = "
            INSERT INTO `article` (`id`, `title`, `description`) VALUES
            (1, 'Microsoft’s Copilot Rises From the Ashes of Bob and Clippy', 'I was at Microsoft Ignite last week for the AI and Copilot rollout on Azure and Windows.\r\n\r\nAs I watched the presentation, I was taken back in time to the 1990s launch of Microsoft Bob and that first attempt at creating a digital assistant called Clippy, neither of which met expectations back then. But now, Copilot will do far more than those two earlier offerings could even conceive of, and the power of the result, both inside and outside of Microsoft, is incredible.\r\n\r\nBefore the event, I met with a company called Reply, which specializes in getting companies ready for Copilot and setting up metrics so that they can confirm the benefits of the technology. Reply raved about how much more productive they and their clients were.'),
            (2, 'Electronic Frontier Foundation Calls for FTC Action on Poisoned Set-Top Boxes', 'TV set-top boxes infected with malware are being sold online at Amazon and other resellers, and the Electronic Frontier Foundation wants the Federal Trade Commission to put a stop to it.\r\n\r\n“Recent reports have revealed various models of Android TV set-top boxes and mobile devices that are being sold by resellers Amazon, AliExpress, and other smaller vendors to include malware before the point of sale,” the EFF wrote Tuesday in a letter to the FTC.\r\n\r\n“These include malware included in devices by Chinese manufacturers AllWinner and RockChip,” the letter continued. “We call on the FTC to use its power…to sanction resellers of devices widely known to include harmful malware.”');

            INSERT INTO `comment` (`id`, `comment`, `user_id`, `article_id`) VALUES
            (1, 'test new comment', 1, 1);

            INSERT INTO `user` (`id`, `first_name`, `last_name`, `email`, `password`) VALUES
            (4, 'test', 'test', 'test123@test.com', '$2y$10$2p6HpPTLNlbQ62kGFj92duKr3xyKD6vafc7ShlHe0j9TqyzH4PbsG');

            ALTER TABLE `comment`
                ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
                ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
            COMMIT;
        ";

        $this->getPDO()->exec($insertProductData);
    }

}