-- ==========================================================
-- TRADE MEDS - Complete MySQL Database Export
-- Generated for Remote MySQL Deployment
-- Target Database: if0_43520184_trademeds
-- ==========================================================

SET FOREIGN_KEY_CHECKS = 0;
SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET NAMES utf8mb4;

-- --------------------------------------------------------
-- Table structure for `users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) UNIQUE NULL,
  `phone` VARCHAR(50) NULL,
  `password` VARCHAR(255) NULL,
  `is_verified` TINYINT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `created_at`) VALUES
(1, 'Dr. Arun Kumar', 'doctor@trademeds.com', '+91 98765 43210', '$2y$10$4feDxXwCVLdfznMb4Dp4vOrqN8gCfJBsVq3rTxVCDITnozFP73n.S', '2026-11-18 05:40:52'),
(2, 'Dr. 9500685317', '9500685317@trademeds-customer.in', '9500685317', '$2y$10$OB8nYQDrSd4SE6Bs/wF/pOkB57fDRqmP6V/7GcJsBRy76U9WZnp3S', '2026-11-18 05:50:39'),
(3, 'Dr. Anita Rao', 'doctor.test@apollo.org', '+91 98401 23456', '$2y$10$wYVr7R0rZEyZVkcHKXWOW.b2NP/VnJVWpSkcd9UuxJ3TYZBEmQjy.', '2026-11-23 10:05:13'),
(4, 'Dr. Aravind Swaminathan', 'doctor@hospital.com', '+91 98765 43210', '$2y$10$/SbRkZM67kN6AByGhtI2ZO/f9E8f/oY90ZeH1EWHUzN1ij1QBCGO.', '2026-11-23 12:11:33');

-- --------------------------------------------------------
-- Table structure for `email_otps`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `email_otps` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `otp_code` VARCHAR(20) NOT NULL,
  `type` VARCHAR(50) DEFAULT 'login',
  `expires_at` DATETIME NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `email_otps`
INSERT INTO `email_otps` (`id`, `email`, `otp_code`, `type`, `expires_at`, `created_at`) VALUES
(1, 'dr.shankar@apollohospitals.org', '257330', 'register', '2026-11-18 08:22:15', '2026-11-18 07:07:15'),
(3, 'customer@test.com', '269476', 'login', '2026-11-18 12:27:34', '2026-11-18 11:12:34'),
(5, 'ragavan9094@gmail.com', '732792', 'register', '2026-11-18 13:09:59', '2026-11-18 11:54:59'),
(6, 'dr.test@hospital.com', '867560', 'login', '2026-11-18 13:38:21', '2026-11-18 12:23:21');

-- --------------------------------------------------------
-- Table structure for `admin_users`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) UNIQUE NOT NULL,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(50) DEFAULT 'admin',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `admin_users`
INSERT INTO `admin_users` (`id`, `username`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@trademeds.com', '$2y$10$/qoBIQ/uTnfQrad2khlU3ON/.nmAGAeSEh/lJ8eB4OKOpYH8Xr/te', 'Super Admin', '2026-11-18 05:58:10');

-- --------------------------------------------------------
-- Table structure for `products`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `products` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `category` VARCHAR(100) NOT NULL,
  `collection` VARCHAR(100) NOT NULL,
  `gender` VARCHAR(50) DEFAULT 'Unisex',
  `price` DECIMAL(10,2) NOT NULL,
  `original_price` DECIMAL(10,2) NOT NULL,
  `discount` VARCHAR(50) NULL,
  `stock` INT DEFAULT 50,
  `rating` DECIMAL(3,1) DEFAULT 4.8,
  `reviews_count` INT DEFAULT 120,
  `badge` VARCHAR(100) NULL,
  `color_name` VARCHAR(100) NULL,
  `color_hex` VARCHAR(20) NULL,
  `color_family` VARCHAR(100) NULL,
  `primary_image` TEXT NOT NULL,
  `hover_image` TEXT NOT NULL,
  `images_json` LONGTEXT NULL,
  `sizes_json` LONGTEXT NULL,
  `swatches_json` LONGTEXT NULL,
  `description` LONGTEXT NULL,
  `fabric` VARCHAR(255) NULL,
  `pockets` VARCHAR(255) NULL,
  `sku` VARCHAR(100) DEFAULT '',
  `subcategory` VARCHAR(100) DEFAULT '',
  `brand` VARCHAR(100) DEFAULT 'TRADE MEDS',
  `sale_price` DECIMAL(10,2) DEFAULT 0,
  `status` VARCHAR(50) DEFAULT 'active',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `products`
INSERT INTO `products` (`id`, `title`, `slug`, `category`, `collection`, `gender`, `price`, `original_price`, `discount`, `stock`, `rating`, `reviews_count`, `badge`, `color_name`, `color_hex`, `color_family`, `primary_image`, `hover_image`, `images_json`, `sizes_json`, `swatches_json`, `description`, `fabric`, `pockets`, `status`, `created_at`, `updated_at`, `sku`, `subcategory`, `brand`, `sale_price`) VALUES
(1, 'Classic Women\'s V-Neck (Navy) Scrub', 'classic-womens-v-neck-navy-scrub', 'Classic Scrubs', 'classic', 'Women', 1099, 1599, '31% OFF', 106, 4.8, 1248, 'Bestseller', 'Navy Blue', '#1c2447', 'All Blues', 'https://knyamed.com/cdn/shop/files/1_36_f708815d-e636-4d70-af59-b4c8dbdc1e7d.jpg?v=1739900782&width=832', 'https://knyamed.com/cdn/shop/files/2_33_05f9980a-a152-4614-a5fc-4d13d5774039.jpg?v=1773817347&width=832', '[\"https://knyamed.com/cdn/shop/files/1_36_f708815d-e636-4d70-af59-b4c8dbdc1e7d.jpg?v=1739900782&width=832\",\"https://knyamed.com/cdn/shop/files/2_33_05f9980a-a152-4614-a5fc-4d13d5774039.jpg?v=1773817347&width=832\",\"https://knyamed.com/cdn/shop/files/5_31_c2087482-d2ac-4e5f-9fb8-c541f172ed34.jpg?v=1773817347&width=832\",\"https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_NavyW_33e2f772-9afa-45ce-b26f-792dfa493b03.png?v=1779693531&width=832\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Heather Grey\",\"hex\":\"#7a8288\"},{\"name\":\"Forest Green\",\"hex\":\"#1e3d30\"}]', 'Designed for all-day comfort and resilience. Tailored specifically for healthcare professionals with breathable poly-viscose blend, anti-fade dyes, and triple-reinforced stitching.', '65% Polyester, 35% Viscose. Lightweight, wrinkle-resistant and easy care.', '3 functional pockets (1 chest pocket with pen slot, 2 deep front pockets).', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(2, 'Classic Men\'s V-Neck (Navy) Scrub', 'classic-mens-v-neck-navy-scrub', 'Classic Scrubs', 'classic', 'Men', 1099, 1599, '31% OFF', 59, 4.8, 984, 'Bestseller', 'Navy Blue', '#1c2447', 'All Blues', 'https://knyamed.com/cdn/shop/files/11TH_MAY_KNYA-1595_2.jpg?v=1739900798&width=832', 'https://knyamed.com/cdn/shop/files/EmptyName_69.jpg?v=1739900798&width=832', '[\"https://knyamed.com/cdn/shop/files/11TH_MAY_KNYA-1595_2.jpg?v=1739900798&width=832\",\"https://knyamed.com/cdn/shop/files/EmptyName_69.jpg?v=1739900798&width=832\",\"https://knyamed.com/cdn/shop/files/EmptyName_68_2.jpg?v=1739900798&width=832\",\"https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_NavyM.png?v=1779449658&width=832\"]', '[\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\"]', '[{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Forest Green\",\"hex\":\"#1e3d30\"},{\"name\":\"Heather Grey\",\"hex\":\"#7a8288\"}]', 'Ergonomically engineered for doctors and surgeons. Features enhanced mobility at the shoulders, a modern athletic cut, and durable reinforced seam construction.', 'Premium Poly-Viscose blend. Breathable, quick-dry, wrinkle-free.', '1 chest pocket with pen slot, 2 side patch pockets.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(3, 'Classic Women\'s V-Neck (Wine) Scrub', 'classic-womens-v-neck-wine-scrub', 'Classic Scrubs', 'classic', 'Women', 1099, 1599, '31% OFF', 90, 4.9, 1412, 'Top Rated', 'Wine', '#631d38', 'All Reds', 'https://knyamed.com/cdn/shop/files/1a3O1A8835.jpg?v=1739900851&width=832', 'https://knyamed.com/cdn/shop/files/3a3O1A8844copy.jpg?v=1739900851&width=832', '[\"https://knyamed.com/cdn/shop/files/1a3O1A8835.jpg?v=1739900851&width=832\",\"https://knyamed.com/cdn/shop/files/3a3O1A8844copy.jpg?v=1739900851&width=832\",\"https://knyamed.com/cdn/shop/files/5a3O1A8846copy.jpg?v=1739900851&width=832\",\"https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_WineW_b18f4677-d474-4230-892b-7e5abdfb6d8b.png?v=1779693298&width=832\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Pastel Lilac\",\"hex\":\"#b5a3cc\"}]', 'Rich burgundy wine shade that resists hospital laundering. Features side slits for easy movement, a flattering silhouette, and badge loop on the shoulder.', 'High-grade medical weave. Soft finish, sweat-wicking.', '3 pockets with dedicated smartphone slot.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(4, 'Classic Men\'s V-Neck (Wine) Scrub', 'classic-mens-v-neck-wine-scrub', 'Classic Scrubs', 'classic', 'Men', 1299, 1799, '28% OFF', 100, 4.8, 642, 'Bestseller', 'Wine', '#631d38', 'All Reds', 'https://knyamed.com/cdn/shop/files/1_50.jpg?v=1739900724&width=832', 'https://knyamed.com/cdn/shop/files/2_43.jpg?v=1739900724&width=832', '[\"https://knyamed.com/cdn/shop/files/1_50.jpg?v=1739900724&width=832\",\"https://knyamed.com/cdn/shop/files/2_43.jpg?v=1739900724&width=832\",\"https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_WineM.png?v=1779449375&width=832\"]', '[\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\"]', '[{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"}]', 'Sophisticated wine shade designed for surgical & clinical routines. Enhanced breathability with ergonomic comfort cut.', 'Poly-viscose blend with anti-static treatment.', '3 reinforced utility pockets.', 'active', '2026-11-18 05:58:10', '2026-11-23 09:59:11', '', '', 'TRADE MEDS', 0),
(5, 'Classic Women\'s V-Neck (Black) Scrub', 'classic-womens-v-neck-black-scrub', 'Classic Scrubs', 'classic', 'Women', 1099, 1599, '31% OFF', 69, 4.8, 820, 'Bestseller', 'Jet Black', '#1a1a1a', 'All Blacks', 'https://knyamed.com/cdn/shop/files/1_70.jpg?v=1739900854&width=832', 'https://knyamed.com/cdn/shop/files/1_67.jpg?v=1739900771&width=832', '[\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/1_70.jpg?v=1739900854&width=832\",\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/1_67.jpg?v=1739900771&width=832\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Heather Grey\",\"hex\":\"#7a8288\"}]', 'Sleek and authoritative jet black tone. Does not fade over rigorous industrial wash cycles.', 'Breathable poly-viscose blend.', '3 deep utility pockets.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(6, 'Classic Men\'s V-Neck (Black) Scrub', 'classic-mens-v-neck-black-scrub', 'Classic Scrubs', 'classic', 'Men', 1099, 1599, '31% OFF', 100, 4.8, 512, 'Bestseller', 'Jet Black', '#1a1a1a', 'All Blacks', 'https://knyamed.com/cdn/shop/files/1_51.jpg?v=1739900769&width=832', 'https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_BlackM.png?v=1779449495&width=832', '[\"https://knyamed.com/cdn/shop/files/1_51.jpg?v=1739900769&width=832\",\"https://knyamed.com/cdn/shop/files/Fabricdetailsclassic_BlackM.png?v=1779449495&width=832\"]', '[\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\"]', '[{\"name\":\"Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"}]', 'Minimalist jet black scrub top designed for intensive shift wear. Anti-static and lint-resistant.', 'Premium durable medical fabric.', '3 pockets with reinforced pen holder.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(7, 'ecoflex™ Women\'s V-Neck (Navy) Scrub', 'ecoflex-womens-v-neck-navy-scrub', 'ecoflex™ Scrubs', 'ecoflex', 'Women', 2499, 3499, '29% OFF', 83, 4.9, 2180, '4-Way Stretch', 'Navy Blue', '#1c2447', 'All Blues', 'https://knyamed.com/cdn/shop/files/21st_Oct_Kanya-3116.jpg?v=1739900753&width=832', 'https://knyamed.com/cdn/shop/files/2_32.jpg?v=1773830081&width=832', '[\"https://knyamed.com/cdn/shop/files/21st_Oct_Kanya-3116.jpg?v=1739900753&width=832\",\"https://knyamed.com/cdn/shop/files/2_32.jpg?v=1773830081&width=832\",\"https://knyamed.com/cdn/shop/files/ecoflexfabriccompositionandtech_NavyBlue.png?v=1776248509&width=832\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Steel Grey\",\"hex\":\"#5a636d\"},{\"name\":\"Mauve\",\"hex\":\"#946f7f\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"}]', 'Engineered with proprietary 4-way stretch technology made from recycled PET bottles. Silky-soft touch, moisture-wicking, anti-microbial, and zero restriction during critical procedures.', '72% Recycled Polyester, 21% Rayon, 7% Spandex. 4-way dynamic stretch.', '4 functional pockets including hidden zippered security pocket.', 'active', '2026-11-18 05:58:10', '2026-11-23 09:59:22', '', '', 'TRADE MEDS', 0),
(8, 'ecoflex™ Men\'s V-Neck (Navy) Scrub', 'ecoflex-mens-v-neck-navy-scrub', 'ecoflex™ Scrubs', 'ecoflex', 'Men', 2499, 3499, '29% OFF', 53, 4.9, 1890, '4-Way Stretch', 'Navy Blue', '#1c2447', 'All Blues', 'https://knyamed.com/cdn/shop/files/11-12392-Recovereda.jpg?v=1739900756&width=832', 'https://knyamed.com/cdn/shop/files/21-12407aa.jpg?v=1773830083&width=832', '[\"https://knyamed.com/cdn/shop/files/11-12392-Recovereda.jpg?v=1739900756&width=832\",\"https://knyamed.com/cdn/shop/files/21-12407aa.jpg?v=1773830083&width=832\",\"https://knyamed.com/cdn/shop/files/ecoflexfabriccompositionandtech_NavyBlue.png?v=1776248509&width=832\"]', '[\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\"]', '[{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Steel Grey\",\"hex\":\"#5a636d\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"}]', 'Ultra-stretch modern athletic fit. Gives you freedom of motion during 16-hour hospital shifts while looking impeccably sharp.', 'Eco-conscious 4-way stretch fabric with anti-odour tech.', '4 ergonomic pockets.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(9, 'ecoflex™ Men\'s V-Neck (Wine) Scrub', 'ecoflex-mens-v-neck-wine-scrub', 'ecoflex™ Scrubs', 'ecoflex', 'Men', 2499, 3499, '29% OFF', 85, 4.8, 730, '4-Way Stretch', 'Wine', '#631d38', 'All Reds', 'https://knyamed.com/cdn/shop/files/122THDECKANYA-1177a.jpg?v=1739900705&width=832', 'https://knyamed.com/cdn/shop/files/222THDECKANYA-1186_1_a.jpg?v=1773831009&width=832', '[\"https://knyamed.com/cdn/shop/files/122THDECKANYA-1177a.jpg?v=1739900705&width=832\",\"https://knyamed.com/cdn/shop/files/222THDECKANYA-1186_1_a.jpg?v=1773831009&width=832\",\"https://knyamed.com/cdn/shop/files/ecoflex_fabric_composition_and_tech_Wine.png?v=1773831010&width=832\"]', '[\"S\",\"M\",\"L\",\"XL\",\"2XL\",\"3XL\"]', '[{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Steel Grey\",\"hex\":\"#5a636d\"}]', 'Deep wine colorway in high-performance stretch fabric. Breathable airflow mesh lining at shoulder points.', 'High performance eco-yarn.', '4 pockets with hidden card/key holder.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(10, 'ecoflex™ Women\'s V-Neck (Wine) Scrub', 'ecoflex-womens-v-neck-wine-scrub', 'ecoflex™ Scrubs', 'ecoflex', 'Women', 2499, 3499, '29% OFF', 114, 4.9, 1105, '4-Way Stretch', 'Wine', '#631d38', 'All Reds', 'https://knyamed.com/cdn/shop/files/117THDECKANYA2022-37757a_c245c457-288a-415d-8677-6c690810c22b.jpg?v=1739900710&width=832', 'https://knyamed.com/cdn/shop/files/217THDECKANYA2022-37812a_5de086c5-a11e-4756-94aa-398677a344d7.jpg?v=1773831010&width=832', '[\"https://knyamed.com/cdn/shop/files/117THDECKANYA2022-37757a_c245c457-288a-415d-8677-6c690810c22b.jpg?v=1739900710&width=832\",\"https://knyamed.com/cdn/shop/files/217THDECKANYA2022-37812a_5de086c5-a11e-4756-94aa-398677a344d7.jpg?v=1773831010&width=832\",\"https://knyamed.com/cdn/shop/files/ecoflex_fabric_composition_and_tech_Wine.png?v=1773831010&width=832\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Wine\",\"hex\":\"#631d38\"},{\"name\":\"Steel Grey\",\"hex\":\"#5a636d\"},{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"}]', 'Luxurious wine stretch scrubs that elevate medical fashion. Repels fluids and resists wrinkles completely.', 'Eco-friendly 4-way stretch blend.', '4 functional pockets with scissor holder.', 'active', '2026-11-18 05:58:10', '2026-11-23 09:58:39', '', '', 'TRADE MEDS', 0),
(11, 'Chief Labcoat (Long Sleeves)', 'chief-labcoat-long-sleeves', 'Lab Coats', 'labcoats', 'Unisex', 1899, 2499, '24% OFF', 74, 4.9, 840, 'Bestseller', 'Optic White', '#f8f9fa', 'All Pastels', 'https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_a3e923c1-fb7c-4288-bf4e-b2faa2e66ef7.png?v=1784716095&width=800', 'https://knyamed.com/cdn/shop/files/Labcoat_eb046422-0767-4374-a73d-97c252f84110.png?v=1769579738', '[\"https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_a3e923c1-fb7c-4288-bf4e-b2faa2e66ef7.png?v=1784716095&width=800\",\"https://knyamed.com/cdn/shop/files/Labcoat_eb046422-0767-4374-a73d-97c252f84110.png?v=1769579738\"]', '[\"36\",\"38\",\"40\",\"42\",\"44\",\"46\"]', '[{\"name\":\"Optic White\",\"hex\":\"#f8f9fa\"}]', 'The gold standard for consultants and senior doctors. Notch lapel collar, fluid-barrier coating, and iPad/tablet-sized lower patch pockets.', 'High-density stain-resistant poly-cotton blend.', '3 deep pockets + internal chest pocket for fountain pens & ID.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(12, 'Focus Labcoat (Long Sleeves)', 'focus-labcoat-long-sleeves', 'Lab Coats', 'labcoats', 'Unisex', 1699, 2199, '23% OFF', 71, 4.8, 620, 'Hospital Approved', 'Optic White', '#f8f9fa', 'All Pastels', 'https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_cce00cd9-d297-44f4-afa4-2372a831f785.png?v=1784715729&width=800', 'https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_a3e923c1-fb7c-4288-bf4e-b2faa2e66ef7.png?v=1784716095&width=800', '[\"https://knyamed.com/cdn/shop/files/Lab_Coats_-_Aprons_cce00cd9-d297-44f4-afa4-2372a831f785.png?v=1784715729&width=800\"]', '[\"36\",\"38\",\"40\",\"42\",\"44\",\"46\"]', '[{\"name\":\"Optic White\",\"hex\":\"#f8f9fa\"}]', 'Streamlined contemporary labcoat built for busy ward rounds and lab diagnostics. Stain release finish.', 'Durable medical twill.', 'Side access slits for under-trouser pockets.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(13, '6sense (Black), All Black Finish Stethoscope', '6sense-all-black-finish-stethoscope', 'Stethoscope', 'stethoscopes', 'Unisex', 2599, 3999, '35% OFF', 82, 4.9, 1420, '30-Day Free Trial', 'Matte Black', '#1a1a1a', 'All Blacks', 'https://knyamed.com/cdn/shop/files/1_986b919b-9e67-4d3b-9c61-194170fabb2a.png?v=1778146597&width=832', 'https://knyamed.com/cdn/shop/files/2_447810e4-5896-408b-be4f-2f80e10a3f6e.png?v=1778146598&width=832', '[\"https://knyamed.com/cdn/shop/files/1_986b919b-9e67-4d3b-9c61-194170fabb2a.png?v=1778146597&width=832\",\"https://knyamed.com/cdn/shop/files/2_447810e4-5896-408b-be4f-2f80e10a3f6e.png?v=1778146598&width=832\",\"https://knyamed.com/cdn/shop/files/3_066b0636-30f0-4395-be4d-c5f947b4a8e2.png?v=1780659912&width=832\",\"https://knyamed.com/cdn/shop/files/4_7e18e936-410e-4dbd-9f57-f2613cb15e06.png?v=1778146598&width=832\"]', '[\"Standard Adult 28 inch\"]', '[{\"name\":\"Matte Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Steel Navy\",\"hex\":\"#1c2447\"},{\"name\":\"Rose Gold Maroon\",\"hex\":\"#8a3324\"}]', 'Brilliant acoustics with dual-frequency tunable diaphragm. Aerospace-grade aluminum chestpiece in stunning all-black electroplated finish. Delivers crisp heart murmurs and faint respiratory sounds.', 'Latex-free dual lumen tubing. Soft-sealing ergonomic eartips.', 'Comes with hard travel case and extra soft eartip pairs.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(14, '6sense lite - High Acoustic Stethoscope', '6sense-lite-stethoscope', 'Stethoscope', 'stethoscopes', 'Unisex', 1899, 2899, '34% OFF', 25, 4.8, 950, 'Ultra-Lightweight', 'Steel Black', '#2b2b2b', 'All Blacks', 'https://knyamed.com/cdn/shop/files/1_8d8a9e66-cb99-4b6f-be14-739e815ddebe.png?v=1780654325&width=832', 'https://knyamed.com/cdn/shop/files/2_babba0b2-ba54-4594-8901-8c357b0850c8.png?v=1780654325&width=832', '[\"https://knyamed.com/cdn/shop/files/1_8d8a9e66-cb99-4b6f-be14-739e815ddebe.png?v=1780654325&width=832\",\"https://knyamed.com/cdn/shop/files/2_babba0b2-ba54-4594-8901-8c357b0850c8.png?v=1780654325&width=832\",\"https://knyamed.com/cdn/shop/files/3_a8272721-d20c-4f4c-8090-e3bc7eb44813.png?v=1780659285&width=832\"]', '[\"Standard 28 inch\"]', '[{\"name\":\"Steel Black\",\"hex\":\"#2b2b2b\"},{\"name\":\"Steel Navy\",\"hex\":\"#1c2447\"}]', 'Light in weight, heavy on clarity. Engineered specifically for medical students and nursing staff who wear stethoscopes all day without neck fatigue.', 'Non-chill rim & bell. High-density PVC tubing.', 'Includes spare diaphragm & identity tag.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(15, '6sense Paeds (Rose Gold Maroon) Pediatric Stethoscope', '6sense-paeds-stethoscope', 'Stethoscope', 'stethoscopes', 'Unisex', 2599, 3999, '35% OFF', 117, 4.9, 780, 'Pediatric Edition', 'Rose Gold Maroon', '#8a3324', 'All Reds', 'https://knyamed.com/cdn/shop/files/1_701862ab-2972-4a0c-a685-eb651779d3c4.png?v=1778146687&width=832', 'https://knyamed.com/cdn/shop/files/2_027b772a-d723-44e5-aee1-49e0c41b83cf.png?v=1778146686&width=832', '[\"https://knyamed.com/cdn/shop/files/1_701862ab-2972-4a0c-a685-eb651779d3c4.png?v=1778146687&width=832\",\"https://knyamed.com/cdn/shop/files/2_027b772a-d723-44e5-aee1-49e0c41b83cf.png?v=1778146686&width=832\"]', '[\"Pediatric 28 inch\"]', '[{\"name\":\"Rose Gold Maroon\",\"hex\":\"#8a3324\"}]', 'Specially calibrated chestpiece with reduced diameter for pediatric and neonatal auscultation. Non-chill rim ensures calm, comfortable examinations.', 'Hypoallergenic tubing with rose-gold titanium plating.', 'Protective case included.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(16, 'TRADE MEDS Pro Comfort Medical Clogs', 'trade-meds-pro-comfort-clogs', 'Footwear', 'footwear', 'Unisex', 1999, 2799, '28% OFF', 90, 4.9, 830, 'New Launch', 'Midnight Navy', '#1c2447', 'All Blues', 'https://knyamed.com/cdn/shop/files/Category_Image_1c081ffd-41d9-4779-8f98-721cd95e9913.png?v=1792663079', 'https://knyamed.com/cdn/shop/files/Clogs_Website_Asset_Desktop_Banner.png?v=1792665264&width=1500', '[\"https://knyamed.com/cdn/shop/files/Category_Image_1c081ffd-41d9-4779-8f98-721cd95e9913.png?v=1792663079\"]', '[\"UK 5\",\"UK 6\",\"UK 7\",\"UK 8\",\"UK 9\",\"UK 10\",\"UK 11\"]', '[{\"name\":\"Midnight Navy\",\"hex\":\"#1c2447\"},{\"name\":\"Pure White\",\"hex\":\"#ffffff\"},{\"name\":\"Matte Black\",\"hex\":\"#1a1a1a\"}]', 'Engineered for 12+ hour standing shifts in operating rooms and ICUs. Shock-absorbing EVA midsole, orthotic arch support, and anti-slip SRC rubber tread.', 'Closed-cell waterproof and autoclavable antimicrobial foam.', 'Removable contoured insole.', 'active', '2026-11-18 05:58:10', '2026-11-23 09:58:16', '', '', 'TRADE MEDS', 0),
(17, 'TRADE MEDS DRIFT Medical Warm-Up Jacket', 'trade-meds-drift-jacket', 'Accessories', 'jackets', 'Unisex', 1799, 2499, '28% OFF', 65, 4.8, 490, 'Hospital Favorite', 'Navy Blue', '#1c2447', 'All Blues', 'https://knyamed.com/cdn/shop/files/PDP_APP_Assests_Mega_menu_containe.png?v=1792664652&width=800', 'https://knyamed.com/cdn/shop/files/Everyday_Comfort_0a0f2a36-5daa-466a-abc0-4a53fba204ab.png?v=1782455818&width=800', '[\"https://knyamed.com/cdn/shop/files/PDP_APP_Assests_Mega_menu_containe.png?v=1792664652&width=800\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Navy Blue\",\"hex\":\"#1c2447\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"},{\"name\":\"Steel Grey\",\"hex\":\"#5a636d\"}]', 'Keeps you warm in freezing air-conditioned operating rooms without bulk. Features ribbed collar, zip front, and stretchy wrist cuffs that push up easily for scrubbing in.', 'Breathable thermal tech fleece with moisture repellent outer.', '2 zip hand pockets, 2 interior stash pockets.', 'active', '2026-11-18 05:58:10', '2026-11-18 05:58:10', '', '', 'TRADE MEDS', 0),
(18, 'Supersoft Pima Cotton Long-Sleeve Underscrub', 'supersoft-pima-underscrub', 'Underscrubs', 'underscrubs', 'Women', 899, 1299, '30% OFF', 85, 4.9, 910, 'Essential', 'Heather Grey', '#7a8288', 'All Greys', 'https://knyamed.com/cdn/shop/files/Underscrubs_69e49385-d903-4a7d-9312-b788edec3399.png?v=1769579815', 'https://knyamed.com/cdn/shop/files/Everyday_Comfort_0a0f2a36-5daa-466a-abc0-4a53fba204ab.png?v=1782455818&width=800', '[\"https://knyamed.com/cdn/shop/files/Underscrubs_69e49385-d903-4a7d-9312-b788edec3399.png?v=1769579815\"]', '[\"XS\",\"S\",\"M\",\"L\",\"XL\",\"2XL\"]', '[{\"name\":\"Heather Grey\",\"hex\":\"#7a8288\"},{\"name\":\"Pure White\",\"hex\":\"#f8f9fa\"},{\"name\":\"Black\",\"hex\":\"#1a1a1a\"}]', 'Layer perfectly beneath scrub tops for added coverage, modesty, and temperature control during cold night shifts. Breathable and pill-resistant.', '95% Pima Cotton, 5% Spandex.', 'None.', 'active', '2026-11-18 05:58:10', '2026-11-19 04:51:51', '', '', 'TRADE MEDS', 0);

-- --------------------------------------------------------
-- Table structure for `categories`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `categories` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `image` TEXT NULL,
  `description` TEXT NULL,
  `display_order` INT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `categories`
INSERT INTO `categories` (`id`, `name`, `slug`, `image`, `description`, `display_order`, `created_at`) VALUES
(1, 'Classic Scrubs', 'classic-scrubs', 'https://knyamed.com/cdn/shop/files/Women_s_Classic_Mandarin_collar_Scrub_Top_Dark_Green_-_1_-_Copy_11e25e83-7d7d-41a6-8e5e-63f5b7218698.jpg', 'Timeless clinical cuts, poly-viscose breathability, stain & fluid resistant.', 1, '2026-11-18 06:46:04'),
(2, 'ecoflex™ Scrubs', 'ecoflex-scrubs', 'https://knyamed.com/cdn/shop/files/1_2521c811-0428-44fe-8f0a-7b56557cb09b.jpg', 'Ultra 4-way stretch, moisture wicking, antimicrobial odor control for long shifts.', 2, '2026-11-18 06:46:04'),
(3, 'Lab Coats & Aprons', 'lab-coats', 'https://knyamed.com/cdn/shop/files/Lab_Coat_Men_Front.jpg', 'Consultant & Resident physician lab coats with tablet pockets and notch lapels.', 3, '2026-11-18 06:46:04'),
(4, '6sense Stethoscopes', 'stethoscopes', 'https://knyamed.com/cdn/shop/files/Black_Finish_1.jpg', 'High acoustic precision dual-head stethoscopes with stainless steel chestpiece.', 4, '2026-11-18 06:46:04'),
(5, 'Medical Footwear & Clogs', 'footwear', 'https://knyamed.com/cdn/shop/files/1_a0ea7d0c-f376-4903-8868-dc1d9f485db4.jpg', 'Anti-slip orthopedic clinical footwear designed for 12+ hour surgical rounds.', 5, '2026-11-18 06:46:04'),
(6, 'Scrub Jackets', 'jackets', 'https://knyamed.com/cdn/shop/files/1_abdaee06-d08b-4a55-bfa7-ff39c71987d3.jpg', 'Fleece-lined temperature regulation jackets for cold surgical theatres.', 6, '2026-11-18 06:46:04');

-- --------------------------------------------------------
-- Table structure for `cart_items`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `session_token` VARCHAR(100) NOT NULL,
  `user_id` INT NULL,
  `product_id` INT NOT NULL,
  `product_title` VARCHAR(255) NOT NULL,
  `product_price` DECIMAL(10,2) NOT NULL,
  `product_image` TEXT NOT NULL,
  `size` VARCHAR(50) NOT NULL,
  `color` VARCHAR(100) NOT NULL,
  `color_hex` VARCHAR(20) NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `embroidery` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `cart_items`
INSERT INTO `cart_items` (`id`, `session_token`, `user_id`, `product_id`, `product_title`, `product_price`, `product_image`, `size`, `color`, `color_hex`, `quantity`, `embroidery`, `created_at`, `updated_at`) VALUES
(4, '3363480e8ac3decb5129273b9966179f', NULL, 15, '6sense Paeds (Rose Gold Maroon) Pediatric Stethoscope', 2599, 'https://knyamed.com/cdn/shop/files/1_701862ab-2972-4a0c-a685-eb651779d3c4.png?v=1778146687&width=832', 'Pediatric 28 inch', 'Navy Blue', '#1c2447', 1, NULL, '2026-11-19 06:30:47', '2026-11-19 06:30:47');

-- --------------------------------------------------------
-- Table structure for `wishlist`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wishlist` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `session_token` VARCHAR(100) NOT NULL,
  `user_id` INT NULL,
  `product_id` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `uniq_session_prod` (`session_token`, `product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `orders`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `orders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `order_number` VARCHAR(100) UNIQUE NOT NULL,
  `user_id` INT NULL,
  `session_token` VARCHAR(100) NOT NULL,
  `customer_name` VARCHAR(255) NOT NULL,
  `customer_email` VARCHAR(255) NOT NULL,
  `customer_phone` VARCHAR(50) NOT NULL,
  `shipping_address` TEXT NOT NULL,
  `items_json` LONGTEXT NOT NULL,
  `subtotal` DECIMAL(10,2) NOT NULL,
  `discount` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `shipping_fee` DECIMAL(10,2) NOT NULL DEFAULT 0,
  `total` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(50) DEFAULT 'COD',
  `status` VARCHAR(50) DEFAULT 'Processing',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `orders`
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `session_token`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `items_json`, `subtotal`, `discount`, `shipping_fee`, `total`, `payment_method`, `status`, `created_at`) VALUES
(1, 'TM-2026-8910', NULL, 'demo-session-1', 'Dr. Riya Sen', 'riya.sen@apollo.com', '+91 98401 23456', 'Apollo Speciality Hospitals, Greams Road, Thousand Lights, Chennai - 600006', '[{\"product_title\":\"Classic Women\'s V-Neck (Navy) Scrub\",\"product_price\":1099,\"quantity\":2,\"size\":\"M\",\"color\":\"Navy Blue\",\"embroidery\":\"Dr. Riya Sen (Anesthesiology)\"}]', 2198, 263.76, 0, 1934.24, 'UPI', 'Delivered', '2026-11-16 05:58:10'),
(2, 'TM-2026-9432', NULL, 'demo-session-2', 'Dr. Karthik Ramanathan', 'karthik.ortho@aiims.edu', '+91 99402 87654', 'Resident Quarters, AIIMS Hospital, New Delhi - 110029', '[{\"product_title\":\"6sense (Black), All Black Finish Stethoscope\",\"product_price\":2599,\"quantity\":1,\"size\":\"Standard Adult\",\"color\":\"Matte Black\"},{\"product_title\":\"TRADE MEDS Pro Comfort Medical Clogs\",\"product_price\":1999,\"quantity\":1,\"size\":\"UK 8\",\"color\":\"Midnight Navy\"}]', 4598, 551.76, 0, 4046.24, 'COD', 'Processing', '2026-11-18 02:58:10'),
(3, 'TM-2026-2B8E-727', 2, '6aa62fdc0d9ff9ca2f4fb75a2734e385', 'Dr. 9500685317', '9500685317@trademeds-customer.in', '9500685317', 'Apollo Speciality Hospitals, Greams Road, Chennai - 600006', '[{\"id\":1,\"session_token\":\"6aa62fdc0d9ff9ca2f4fb75a2734e385\",\"user_id\":2,\"product_id\":2,\"product_title\":\"Classic Men\'s V-Neck (Navy) Scrub\",\"product_price\":1099,\"product_image\":\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/11TH_MAY_KNYA-1595_2.jpg?v=1739900798&width=832\",\"size\":\"M\",\"color\":\"Navy Blue\",\"color_hex\":\"#1c2447\",\"quantity\":1,\"embroidery\":null,\"created_at\":\"2026-11-18 07:20:09\",\"updated_at\":\"2026-11-18 07:20:09\"}]', 1099, 0, 99, 1198, 'COD', 'Confirmed', '2026-11-18 07:20:14'),
(4, 'TM-2026-E7D9-129', NULL, '3363480e8ac3decb5129273b9966179f', 'Dr. Customer', 'doctor@hospital.in', '+91 98765 43210', 'Apollo Speciality Hospitals, Greams Road, Chennai - 600006', '[{\"id\":2,\"session_token\":\"3363480e8ac3decb5129273b9966179f\",\"user_id\":null,\"product_id\":2,\"product_title\":\"Classic Men\'s V-Neck (Navy) Scrub\",\"product_price\":1099,\"product_image\":\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/11TH_MAY_KNYA-1595_2.jpg?v=1739900798&width=832\",\"size\":\"L\",\"color\":\"Navy Blue\",\"color_hex\":\"#1c2447\",\"quantity\":1,\"embroidery\":null,\"created_at\":\"2026-11-19 04:53:29\",\"updated_at\":\"2026-11-19 04:53:29\"}]', 1099, 0, 99, 1198, 'COD', 'Confirmed', '2026-11-19 04:53:33'),
(5, 'TM-2026-7503-663', NULL, '3363480e8ac3decb5129273b9966179f', 'Dr. Customer', 'doctor@hospital.in', '+91 98765 43210', 'Apollo Speciality Hospitals, Greams Road, Chennai - 600006', '[{\"id\":3,\"session_token\":\"3363480e8ac3decb5129273b9966179f\",\"user_id\":null,\"product_id\":3,\"product_title\":\"Classic Women\'s V-Neck (Wine) Scrub\",\"product_price\":1099,\"product_image\":\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/1a3O1A8835.jpg?v=1739900851&width=832\",\"size\":\"XS\",\"color\":\"Wine\",\"color_hex\":\"#631d38\",\"quantity\":1,\"embroidery\":null,\"created_at\":\"2026-11-19 04:53:49\",\"updated_at\":\"2026-11-19 04:53:49\"}]', 1099, 0, 99, 1198, 'COD', 'Confirmed', '2026-11-19 04:53:51'),
(6, 'TM-2026-3628-445', NULL, 'eed55ff46cea59a7ccd2e538532da8ef', 'RAGAVAN', 'ragavan9094@gmail.com', '9500685317', 'TIRUPUR, NO 36, PNP ROAD, VINAYAGA GARMENTS, TIRUPUR, Tamil Nadu - 641607', '[{\"id\":5,\"session_token\":\"eed55ff46cea59a7ccd2e538532da8ef\",\"user_id\":null,\"product_id\":10,\"product_title\":\"ecoflex\\u2122 Women\'s V-Neck (Wine) Scrub\",\"product_price\":2499,\"product_image\":\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/117THDECKANYA2022-37757a_c245c457-288a-415d-8677-6c690810c22b.jpg?v=1739900710&width=832\",\"size\":\"XS\",\"color\":\"Wine\",\"color_hex\":\"#631d38\",\"quantity\":1,\"embroidery\":null,\"created_at\":\"2026-11-23 07:38:20\",\"updated_at\":\"2026-11-23 07:38:20\"},{\"id\":6,\"session_token\":\"eed55ff46cea59a7ccd2e538532da8ef\",\"user_id\":null,\"product_id\":7,\"product_title\":\"ecoflex\\u2122 Women\'s V-Neck (Navy) Scrub\",\"product_price\":2499,\"product_image\":\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/21st_Oct_Kanya-3116.jpg?v=1739900753&width=832\",\"size\":\"M\",\"color\":\"Navy Blue\",\"color_hex\":\"#1c2447\",\"quantity\":1,\"embroidery\":null,\"created_at\":\"2026-11-23 10:53:44\",\"updated_at\":\"2026-11-23 10:53:44\"},{\"id\":7,\"session_token\":\"eed55ff46cea59a7ccd2e538532da8ef\",\"user_id\":null,\"product_id\":7,\"product_title\":\"ecoflex\\u2122 Women\'s V-Neck (Navy) Scrub\",\"product_price\":2499,\"product_image\":\"https:\\/\\/knyamed.com\\/cdn\\/shop\\/files\\/21st_Oct_Kanya-3116.jpg?v=1739900753&width=832\",\"size\":\"XS\",\"color\":\"Navy Blue\",\"color_hex\":\"#1c2447\",\"quantity\":1,\"embroidery\":null,\"created_at\":\"2026-11-23 10:53:59\",\"updated_at\":\"2026-11-23 10:53:59\"}]', 7497, 0, 0, 7497, 'COD', 'Shipped', '2026-11-23 10:55:38');

-- --------------------------------------------------------
-- Table structure for `newsletter`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `newsletter` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) UNIQUE NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `stock_history`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `stock_history` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `product_id` INT NOT NULL,
  `product_title` VARCHAR(255) NULL,
  `change_type` VARCHAR(50) NULL,
  `quantity_changed` INT NULL,
  `stock_before` INT NULL,
  `stock_after` INT NULL,
  `notes` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `stock_history`
INSERT INTO `stock_history` (`id`, `product_id`, `product_title`, `change_type`, `quantity_changed`, `stock_before`, `stock_after`, `notes`, `created_at`) VALUES
(1, 2, 'Classic Men\'s V-Neck (Navy) Scrub', 'order_reduction', -1, 61, 60, 'Order #TM-2026-2B8E-727 checkout', '2026-11-18 07:20:14'),
(2, 2, 'Classic Men\'s V-Neck (Navy) Scrub', 'order_reduction', -1, 60, 59, 'Order #TM-2026-E7D9-129 checkout', '2026-11-19 04:53:33'),
(3, 3, 'Classic Women\'s V-Neck (Wine) Scrub', 'order_reduction', -1, 91, 90, 'Order #TM-2026-7503-663 checkout', '2026-11-19 04:53:51'),
(4, 10, 'ecoflex™ Women\'s V-Neck (Wine) Scrub', 'order_reduction', -1, 115, 114, 'Order #TM-2026-3628-445 checkout', '2026-11-23 10:55:38'),
(5, 7, 'ecoflex™ Women\'s V-Neck (Navy) Scrub', 'order_reduction', -1, 85, 84, 'Order #TM-2026-3628-445 checkout', '2026-11-23 10:55:38'),
(6, 7, 'ecoflex™ Women\'s V-Neck (Navy) Scrub', 'order_reduction', -1, 84, 83, 'Order #TM-2026-3628-445 checkout', '2026-11-23 10:55:38');

-- --------------------------------------------------------
-- Table structure for `customer_addresses`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `customer_addresses` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(50) NOT NULL,
  `address_line` TEXT NOT NULL,
  `city` VARCHAR(100) NULL,
  `state` VARCHAR(100) NULL,
  `postal_code` VARCHAR(20) NULL,
  `is_default` TINYINT DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------
-- Table structure for `navigation_menus`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `navigation_menus` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NOT NULL DEFAULT '#',
  `parent_id` INT DEFAULT 0,
  `menu_location` VARCHAR(50) DEFAULT 'header',
  `badge` VARCHAR(50) DEFAULT '',
  `target` VARCHAR(20) DEFAULT '_self',
  `display_order` INT DEFAULT 0,
  `is_active` TINYINT DEFAULT 1,
  `icon_svg` TEXT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `navigation_menus`
INSERT INTO `navigation_menus` (`id`, `title`, `url`, `parent_id`, `menu_location`, `badge`, `target`, `display_order`, `is_active`, `icon_svg`, `created_at`) VALUES
(1, 'Women', 'category.php?gender=Women', 0, 'header', 'POPULAR', '_self', 1, 1, '', '2026-11-19 04:39:44'),
(2, 'Men', 'category.php?gender=Men', 0, 'header', '', '_self', 2, 1, '', '2026-11-19 04:39:44'),
(3, 'ecoflex™', 'category.php?cat=ecoflex%E2%84%A2+Scrubs', 0, 'header', 'STRETCH', '_self', 3, 1, '', '2026-11-19 04:39:44'),
(4, '6sense', 'category.php?cat=Stethoscope', 0, 'header', 'NEW', '_self', 4, 1, '', '2026-11-19 04:39:44'),
(5, 'Footwear', 'category.php?cat=Footwear', 0, 'header', '', '_self', 5, 1, '', '2026-11-19 04:39:44'),
(6, 'Lab Coats', 'category.php?cat=Lab+Coats', 0, 'header', 'ESSENTIAL', '_self', 6, 1, '', '2026-11-19 04:39:44'),
(7, 'Bulk Order', '#bulk-banner', 0, 'header', 'SAVE 25%', '_self', 7, 1, '', '2026-11-19 04:39:44'),
(8, 'Track Order', 'javascript:void(0)\" onclick=\"window.TM.promptTrackOrder()', 0, 'header', '', '_self', 8, 1, '', '2026-11-19 04:39:44'),
(9, 'Our Story', '#about-us', 0, 'footer_company', '', '_self', 1, 1, '', '2026-11-19 04:39:44'),
(10, 'Custom Doctor Embroidery', '#bulk-banner', 0, 'footer_company', 'HOT', '_self', 2, 1, '', '2026-11-19 04:39:44'),
(11, 'Hospital Group Orders', '#bulk-banner', 0, 'footer_company', '', '_self', 3, 1, '', '2026-11-19 04:39:44'),
(12, 'Size & Fit Guide', 'javascript:void(0)\" onclick=\"window.TM.openSizeChart()', 0, 'footer_quick_links', '', '_self', 1, 1, '', '2026-11-19 04:39:44'),
(13, 'Returns & Exchanges', '#policy', 0, 'footer_quick_links', '', '_self', 2, 1, '', '2026-11-19 04:39:44'),
(14, 'Wash & Autoclave Care', '#care', 0, 'footer_quick_links', '', '_self', 3, 1, '', '2026-11-19 04:39:44');

-- --------------------------------------------------------
-- Table structure for `coupons`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `coupons` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `code` VARCHAR(100) UNIQUE NOT NULL,
  `discount_type` VARCHAR(50) DEFAULT 'percentage',
  `discount_value` DECIMAL(10,2) NOT NULL,
  `min_order_amount` DECIMAL(10,2) DEFAULT 0,
  `max_discount_amount` DECIMAL(10,2) DEFAULT 0,
  `usage_limit` INT DEFAULT 0,
  `times_used` INT DEFAULT 0,
  `expires_at` DATETIME NULL,
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `coupons`
INSERT INTO `coupons` (`id`, `code`, `discount_type`, `discount_value`, `min_order_amount`, `max_discount_amount`, `usage_limit`, `times_used`, `expires_at`, `is_active`, `created_at`) VALUES
(1, 'DOCTOR10', 'percentage', 10, 1499, 500, 1000, 34, NULL, 1, '2026-11-19 04:39:44'),
(2, 'WELCOME200', 'fixed', 200, 1999, 0, 500, 89, NULL, 1, '2026-11-19 04:39:44'),
(3, 'SURGEON15', 'percentage', 15, 2999, 800, 250, 12, NULL, 1, '2026-11-19 04:39:44'),
(4, 'FREESHIP', 'fixed', 99, 999, 0, 0, 145, NULL, 1, '2026-11-19 04:39:44');

-- --------------------------------------------------------
-- Table structure for `doctor_reviews`
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `doctor_reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `doctor_name` VARCHAR(255) NOT NULL,
  `doctor_title` VARCHAR(255) NOT NULL,
  `hospital_name` VARCHAR(255) NOT NULL,
  `avatar_url` TEXT NOT NULL,
  `rating` INT DEFAULT 5,
  `product_worn` VARCHAR(255) DEFAULT '',
  `review_text` TEXT NOT NULL,
  `badge_text` VARCHAR(100) DEFAULT 'Verified Buyer',
  `highlight_tag` VARCHAR(100) DEFAULT 'Verified Review',
  `display_order` INT DEFAULT 0,
  `is_active` TINYINT DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table `doctor_reviews`
INSERT INTO `doctor_reviews` (`id`, `doctor_name`, `doctor_title`, `hospital_name`, `avatar_url`, `rating`, `product_worn`, `review_text`, `badge_text`, `highlight_tag`, `display_order`, `is_active`, `created_at`) VALUES
(1, 'Dr. Mili Dogra', 'Anesthesiology Resident', 'AIIMS Hospital, New Delhi', 'https://knyamed.com/cdn/shop/files/456x500px-Dr-Mili-Dogra-Anesthesiology-Resident_ab4edce0-1b04-431e-b09f-678b766e87c7.jpg?v=1683281588&width=380', 5, 'Wears: ecoflex™ Scrub Suit (Navy Blue)', 'The ecoflex™ scrubs are a game changer for 14-hour orthopedic surgery shifts. Zero tightness at the shoulders, and the fabric doesn\'t absorb hospital smells or fluids even after marathon OT sessions.', 'Verified Buyer', '4-Way Stretch Tech', 1, 1, '2026-11-19 04:39:44'),
(2, 'Dr. Prateek Makwana', 'Fertility & Embryology Specialist', 'Vasundhara IVF, Mumbai', 'https://knyamed.com/cdn/shop/files/250x250px-Dr-Prateek-Makwana-Fertility-Specialist_a197c02e-7b83-4940-9671-8086c30a1ba4.jpg?v=1683282037&width=200', 5, 'Uses: 6sense Precision Stethoscope (Matte Black)', 'I ordered the 6sense Stethoscope in All-Black finish. The acoustic amplification is astonishingly sharp, easily on par with international brands costing three times more. A true clinical masterpiece.', 'Verified Buyer', 'Acoustic Clarity', 2, 1, '2026-11-19 04:39:44'),
(3, 'Dr. Shivani Agarwal', 'OBGYN Resident', 'Apollo Speciality Hospitals, Kolkata', 'https://knyamed.com/cdn/shop/files/250x250px-Dr-Shivani-Agarwal-OBGYN-Resident_b2b80249-328c-4def-8586-69e27aea3814.jpg?v=1683282037&width=200', 5, 'Wears: Classic Women\'s Scrub Suit (Wine Red) + Embroidery', 'Our entire OBGYN department ordered matching wine-red scrubs with custom doctor embroidery. The fabric withstands commercial autoclave washing without fading or shrinking. Five stars!', 'Verified Buyer', 'Autoclave-Safe', 3, 1, '2026-11-19 04:39:44');

SET FOREIGN_KEY_CHECKS = 1;
