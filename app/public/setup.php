<?php
require_once "_includes/Database.php";
require_once "_includes/functions.php";

try {
  $config = require_once "config.php";
  $db = new Database($config["database"], $config["database"]["user"], $config["database"]["passw"]);
  // Users
  $sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL UNIQUE,
    `email` varchar(50) NOT NULL UNIQUE,
    `password` varchar(75) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

  $db->query($sql);

  // Gym
  $sql = "CREATE TABLE IF NOT EXISTS `gyms` (
    `id` int(11) NOT NULL AUTO_INCREMENT, 
    `name` varchar(50) NOT NULL UNIQUE,
    `address` varchar(75) NOT NULL,
    `lat` varchar(50) NOT NULL,
    `lon` varchar(50) NOT NULL,
    `description` varchar(200) NULL,
    `user_id` int NOT NULL,
    CONSTRAINT `fk_user_gym` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

  $db->query($sql);

  // Sessions and styles
    $sql = "CREATE TABLE IF NOT EXISTS `styles` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(50) NOT NULL UNIQUE,
      `aliases` varchar(50) NOT NULL,
      `description` varchar(200) NULL,
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
      
  $db->query($sql);
      
    $sql = "DROP TABLE sessions; CREATE TABLE IF NOT EXISTS `sessions` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `gym_id` int(11) NOT NULL,
      `type` varchar(50) NULL,
      `day` varchar(20) NOT NULL,
      `style_id` int(11) NOT NULL,
      `start_time` time NOT NULL, 
      `end_time` time NOT NULL,
      `is_free_for_all` tinyint(1) NOT NULL,
      `user_id` int(11) NOT NULL,
      CONSTRAINT `fk_gym_session` FOREIGN KEY (`gym_id`) REFERENCES `gyms`(`id`),
      CONSTRAINT `fk_style_session` FOREIGN KEY (`style_id`) REFERENCES `styles`(`id`),
      CONSTRAINT `fk_user_session` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`),
      PRIMARY KEY (`id`)
      ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";

  $db->query($sql);

  // Check if there are any users
  $sql = "SELECT * FROM `users`";
  $statement = $db->query($sql);
  $users = $db->fetchAll($statement);
  if (count($users) == 0) {
    // If there are no users, create them
    $sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?,?,?)";
    $db->query($sql, ["admin", "admin@test.com", password_hash("1234", PASSWORD_DEFAULT)]);
    $db->query($sql, ["user1", "user1@test.com", password_hash("1234", PASSWORD_DEFAULT)]);
    $db->query($sql, ["user2", "user2@test.com", password_hash("1234", PASSWORD_DEFAULT)]);
    $db->query($sql, ["user3", "user3@test.com", password_hash("1234", PASSWORD_DEFAULT)]);
  }

  // // Check if there are any gyms
  $sql = "SELECT * FROM `gyms`";
  $statement = $db->query($sql);
  $gyms = $db->fetchAll($statement);
  if (count($gyms) == 0) {
    // If there are no gyms, create them
    add_gym("Art of Roll", "Dalhemsgatan 5, 212 24 Malmö", "Gym 1 beskrivning", 1);
    // wait one second
    sleep(1);
    add_gym("Limitless Malmö", "Betaniaplan 4, 211 55 Malmö", "Gym 1 beskrivning", 1);
    sleep(1);

    add_gym("Redline Training Center", "Redline Training Center", "Gym 1 beskrivning", 2);
    sleep(1);

    add_gym("Grappling Resistance", "Snapperupsgatan 9, 211 35 Malmö", "Gym 1 beskrivning", 2);
    sleep(1);

    add_gym("Bangkok Fight Lab", "137 Sukhumvit 50, Khlong Toei, Bangkok 10110, Thailand", "Gym 1 beskrivning", 3);
    sleep(1);

    add_gym("MMA-Alliance", "Rolfsgatan 7B, 214 34 Malmö", "Gym 1 beskrivning", 3);
    sleep(1);
    add_gym("Nacka Dojo", "Skuru skolväg 2B, 131 47 Nacka", "Gym 1 beskrivning", 4);
  }


  // Adding Styles
  // Check if there are any styles
  $sql = "SELECT * FROM `styles`";
  $statement = $db->query($sql);
  $styles = $db->fetchAll($statement);
  if (count($styles) == 0) {
    // If there are no styles, create them
    $sql = "INSERT INTO `styles` (`name`, `aliases`, `description`) VALUES (?,?,?)";
    $db->query($sql, ["Brazilian Ju Jitsu", "BJJ", "Judo but it continues on the ground for a while longer"]);
    $db->query($sql, ["Submission Wrestling", "NoGi,BJJ-Nogi,Grappling", "Like BJJ but without the Gi"]);
    $db->query($sql, ["Mixed Martial Arts", "MMA,Mixed Martial Arts", "Most strikes and grappling is allowed"]);
    $db->query($sql, ["Muay Thai", "Thai Boxing", "Like kickboxing with elbows and knees as well"]);
  }

  // Adding Sessions
  // Check if there are any sessions
  $sql = "SELECT * FROM `sessions`";
  $statement = $db->query($sql);
  $sessions = $db->fetchAll($statement);
  if (count($sessions) == 0) {
    // If there are no sessions, create them
    $sql = "INSERT INTO `sessions` (`gym_id`, `type`, `style_id`, `day`, `start_time`, `end_time`, `is_free_for_all`, `user_id`) VALUES (?,?,?,?,?,?,?,?)";
    $db->query($sql, [1, null, 1, "monday", "09:00:00", "10:00:00", 0, 1]);
    $db->query($sql, [1, null, 2, "tuesday", "10:00:00", "11:00:00", 0, 1]);
    $db->query($sql, [1, "Drilling", 3, "wednesday", "11:00:00", "12:00:00", 0, 1]);
    $db->query($sql, [1, "Drilling", 4, "thursday", "12:00:00", "13:00:00", 0, 1]);
    $db->query($sql, [2, "Drilling", 1, "friday", "09:00:00", "10:00:00", 0, 1]);
    $db->query($sql, [2, "Open Mat", 2, "saturday", "10:00:00", "11:00:00", 0, 1]);
    $db->query($sql, [2, null, 3, "monday", "11:00:00", "12:00:00", 0, 1]);
    $db->query($sql, [2, null, 4, "monday", "12:00:00", "13:00:00", 0, 1]);
    $db->query($sql, [3, null, 1, "tuesday", "09:00:00", "10:00:00", 0, 1]);
    $db->query($sql, [3, null, 2, "tuesday", "10:00:00", "11:00:00", 0, 1]);
    $db->query($sql, [3, null, 3, "thursday", "11:00:00", "12:00:00", 0, 1]);
    $db->query($sql, [3, null, 4, "thursday", "12:00:00", "13:00:00", 0, 1]);
    $db->query($sql, [4, "Drilling", 1, "friday", "09:00:00", "10:00:00", 0, 1]);
    $db->query($sql, [4, "Open Mat", 2, "saturday", "10:00:00", "11:00:00", 0, 1]);
    $db->query($sql, [4, "Drilling", 3, "monday", "11:00:00", "12:00:00", 0, 1]);
    $db->query($sql, [4, "Open Mat", 4, "saturday", "12:00:00", "13:00:00", 0, 1]);
    $db->query($sql, [5, "Drilling", 1, "sunday", "09:00:00", "10:00:00", 0, 1]);
    $db->query($sql, [5, "Drilling", 2, "wednesday", "10:00:00", "11:00:00", 0, 1]);
    $db->query($sql, [5, null, 3, "monday", "11:00:00", "12:00:00", 0, 1]);
  }
  echo "Database setup complete <br>";
} catch (PDOException $e) {
  echo "Database setup exception $e";
}
