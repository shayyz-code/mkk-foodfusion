-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 15, 2025 at 02:23 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foodfusion`
--

-- --------------------------------------------------------

--
-- Table structure for table `cooking_tips`
--

CREATE TABLE `cooking_tips` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tip_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `event_date` date NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `description`, `event_date`, `image_path`, `created_at`) VALUES
(1, 'Italian Cooking Workshop', 'Learn to make authentic Italian pasta from scratch with Chef Mario.', '2025-12-15', 'assets/images/events/italian_workshop.jpg', '2025-10-15 07:45:49'),
(2, 'Vegan Baking Masterclass', 'Discover the secrets of delicious vegan desserts with our expert pastry chef.', '2025-12-20', 'assets/images/events/vegan_baking.jpg', '2025-10-15 07:45:49'),
(3, 'Asian Fusion Cooking', 'Explore the exciting flavors of Asian fusion cuisine in this hands-on cooking class.', '2026-01-10', 'assets/images/events/asian_fusion.jpg', '2025-10-15 07:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `content`, `image_path`, `created_at`) VALUES
(1, 'Seasonal Ingredients for Fall', 'Discover the best ingredients to use this fall season and how to incorporate them into your cooking.', 'assets/images/news/fall_ingredients.jpg', '2025-10-15 07:45:49'),
(2, 'Cooking Techniques: Sous Vide', 'Learn about the sous vide cooking technique and how it can elevate your home cooking.', 'assets/images/news/sous_vide.jpg', '2025-10-15 07:45:49'),
(3, 'Healthy Meal Prep Ideas', 'Get inspired with these healthy and delicious meal prep ideas for busy weekdays.', 'assets/images/news/meal_prep.jpg', '2025-10-15 07:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(100) NOT NULL,
  `is_community` tinyint(1) NOT NULL DEFAULT 1,
  `description` text NOT NULL,
  `ingredients` text NOT NULL,
  `instructions` text NOT NULL,
  `cuisine_type` varchar(50) NOT NULL,
  `dietary_pref` varchar(50) NOT NULL,
  `difficulty` varchar(20) NOT NULL,
  `prep_time` int(11) NOT NULL,
  `cook_time` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `user_id`, `title`, `is_community`, `description`, `ingredients`, `instructions`, `cuisine_type`, `dietary_pref`, `difficulty`, `prep_time`, `cook_time`, `image_path`, `created_at`) VALUES
(1, NULL, 'Classic Margherita Pizza', 1, 'A simple yet delicious Italian classic with fresh basil and mozzarella.', 'Pizza dough, San Marzano tomatoes, Fresh mozzarella, Fresh basil, Olive oil, Salt', '1. Preheat oven to 500°F. 2. Roll out dough. 3. Add toppings. 4. Bake for 10-12 minutes.', 'Italian', 'Vegetarian', 'Easy', 20, 12, 'assets/images/recipes/margherita.jpg', '2025-10-15 07:45:49'),
(2, NULL, 'Vegetable Curry', 1, 'A flavorful and spicy vegetable curry that\'s perfect for weeknight dinners.', 'Mixed vegetables, Coconut milk, Curry paste, Garlic, Ginger, Onion, Vegetable broth', '1. Sauté onions, garlic, and ginger. 2. Add curry paste. 3. Add vegetables and liquids. 4. Simmer until vegetables are tender.', 'Indian', 'Vegan', 'Medium', 15, 30, 'assets/images/recipes/veg_curry.jpg', '2025-10-15 07:45:49'),
(3, NULL, 'Chocolate Lava Cake', 1, 'Decadent chocolate cake with a molten center, perfect for dessert lovers.', 'Dark chocolate, Butter, Eggs, Sugar, Flour, Vanilla extract', '1. Melt chocolate and butter. 2. Mix in other ingredients. 3. Pour into ramekins. 4. Bake at 425°F for 12-14 minutes.', 'French', 'Vegetarian', 'Medium', 15, 14, 'assets/images/recipes/lava_cake.jpg', '2025-10-15 07:45:49');

-- --------------------------------------------------------

--
-- Table structure for table `recipe_ratings`
--

CREATE TABLE `recipe_ratings` (
  `id` int(11) NOT NULL,
  `recipe_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(1, 'mkk', 'mkk', 'mkk@gmail.com', '$2y$10$kR3lug4CYz0M/YaHK5ADo./MbdwsodkusXIoWTaaJJVB6aFbFB7h2', '2025-10-15 08:39:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cooking_tips`
--
ALTER TABLE `cooking_tips`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `recipe_ratings`
--
ALTER TABLE `recipe_ratings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_recipe` (`recipe_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cooking_tips`
--
ALTER TABLE `cooking_tips`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=902;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=901;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=902;

--
-- AUTO_INCREMENT for table `recipe_ratings`
--
ALTER TABLE `recipe_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cooking_tips`
--
ALTER TABLE `cooking_tips`
  ADD CONSTRAINT `cooking_tips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `recipes`
--
ALTER TABLE `recipes`
  ADD CONSTRAINT `recipes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `recipe_ratings`
--
ALTER TABLE `recipe_ratings`
  ADD CONSTRAINT `recipe_ratings_ibfk_1` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recipe_ratings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
