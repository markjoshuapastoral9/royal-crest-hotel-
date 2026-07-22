-- ============================================
-- ROYAL CREST HOTEL - PACKAGES SYSTEM
-- Install Script
-- ============================================

USE `monarch_hotel`;

-- Drop tables if they exist (clean install)
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS `booking_package`;
DROP TABLE IF EXISTS `package_amenity`;
DROP TABLE IF EXISTS `packages`;
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================
-- CREATE PACKAGES TABLE
-- ============================================
CREATE TABLE `packages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `original_price` decimal(10,2) DEFAULT NULL,
  `min_nights` int NOT NULL DEFAULT '1',
  `inclusions` json NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `valid_from` date DEFAULT NULL,
  `valid_until` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `packages_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- CREATE PACKAGE_AMENITY TABLE (Pivot)
-- ============================================
CREATE TABLE `package_amenity` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `package_id` bigint unsigned NOT NULL,
  `amenity_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `package_amenity_package_id_foreign` (`package_id`),
  KEY `package_amenity_amenity_id_foreign` (`amenity_id`),
  CONSTRAINT `package_amenity_package_id_foreign` 
    FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE,
  CONSTRAINT `package_amenity_amenity_id_foreign` 
    FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- CREATE BOOKING_PACKAGE TABLE (Pivot)
-- ============================================
CREATE TABLE `booking_package` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned NOT NULL,
  `package_id` bigint unsigned NOT NULL,
  `package_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `booking_package_booking_id_foreign` (`booking_id`),
  KEY `booking_package_package_id_foreign` (`package_id`),
  CONSTRAINT `booking_package_booking_id_foreign` 
    FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `booking_package_package_id_foreign` 
    FOREIGN KEY (`package_id`) REFERENCES `packages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- INSERT SAMPLE PACKAGES
-- ============================================

-- 1. Honeymoon Bliss Package
INSERT INTO `packages` VALUES (
  1,
  'Honeymoon Bliss Package',
  'honeymoon-bliss',
  'Start your journey together in paradise. Luxurious honeymoon suite, couples spa, romantic dinner, and more.',
  22999.00,
  30000.00,
  3,
  '["room","breakfast","dinner","spa","massage","welcome_drink","late_checkout","airport_transfer"]',
  'images/packages/honeymoon.jpg',
  1,
  1,
  0,
  '2026-07-21',
  '2027-07-21',
  NOW(),
  NOW()
);

-- 2. Romantic Getaway Package
INSERT INTO `packages` VALUES (
  2,
  'Romantic Getaway Package',
  'romantic-getaway',
  'Perfect for couples seeking a romantic escape. Includes accommodation, dining, and a relaxing spa experience for two.',
  15999.00,
  20000.00,
  2,
  '["room","breakfast","dinner","spa","welcome_drink","late_checkout"]',
  'images/packages/romantic-getaway.jpg',
  1,
  1,
  1,
  '2026-07-21',
  '2027-07-21',
  NOW(),
  NOW()
);

-- 3. Family Fun Package
INSERT INTO `packages` VALUES (
  3,
  'Family Fun Package',
  'family-fun',
  'Create lasting memories with your loved ones. Includes family room, meals, and access to all hotel facilities.',
  12999.00,
  16000.00,
  3,
  '["room","breakfast","lunch","wifi","welcome_drink"]',
  'images/packages/family-fun.jpg',
  1,
  1,
  2,
  '2026-07-21',
  '2027-07-21',
  NOW(),
  NOW()
);

-- 4. Wellness Retreat Package
INSERT INTO `packages` VALUES (
  4,
  'Wellness Retreat Package',
  'wellness-retreat',
  'Rejuvenate your mind, body, and soul. Includes spa treatments, healthy meals, and yoga sessions.',
  18999.00,
  24000.00,
  3,
  '["room","breakfast","lunch","dinner","spa","massage","wifi"]',
  'images/packages/wellness-retreat.jpg',
  1,
  1,
  3,
  '2026-07-21',
  '2027-07-21',
  NOW(),
  NOW()
);

-- 5. Business Traveler Package
INSERT INTO `packages` VALUES (
  5,
  'Business Traveler Package',
  'business-traveler',
  'Everything you need for a productive stay. High-speed WiFi, meeting room access, and executive breakfast.',
  8999.00,
  11000.00,
  1,
  '["room","breakfast","wifi","late_checkout"]',
  'images/packages/business-traveler.jpg',
  0,
  1,
  4,
  '2026-07-21',
  '2027-07-21',
  NOW(),
  NOW()
);

-- 6. Staycation Delight
INSERT INTO `packages` VALUES (
  6,
  'Staycation Delight',
  'staycation-delight',
  'Escape the ordinary without going far. Enjoy a relaxing staycation with full board meals and spa access.',
  10999.00,
  14000.00,
  2,
  '["room","breakfast","lunch","dinner","spa","wifi"]',
  'images/packages/staycation.jpg',
  0,
  1,
  5,
  '2026-07-21',
  '2027-07-21',
  NOW(),
  NOW()
);

-- ============================================
-- VERIFICATION
-- ============================================
SELECT '✅ Packages installed successfully!' AS status;
SELECT COUNT(*) AS total_packages FROM packages;
SELECT name, price, min_nights FROM packages ORDER BY sort_order;

-- ============================================
-- DONE! Visit http://127.0.0.1:8000/packages
-- ============================================
