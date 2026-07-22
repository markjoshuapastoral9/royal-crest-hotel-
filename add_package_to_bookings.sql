USE monarch_hotel;

-- Add package_id column to bookings if not exists
ALTER TABLE `bookings` 
ADD COLUMN IF NOT EXISTS `package_id` bigint unsigned NULL AFTER `promotion_id`;

-- Add foreign key (ignore error if already exists)
ALTER TABLE `bookings`
ADD CONSTRAINT `bookings_package_id_foreign` 
FOREIGN KEY (`package_id`) REFERENCES `packages`(`id`) ON DELETE SET NULL;
