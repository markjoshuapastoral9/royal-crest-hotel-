USE monarch_hotel;

-- Safely add check_in_time (skip if already exists)
SET @col_exists = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'monarch_hotel'
      AND TABLE_NAME   = 'bookings'
      AND COLUMN_NAME  = 'check_in_time'
);

SET @sql = IF(@col_exists = 0,
    'ALTER TABLE `bookings` ADD COLUMN `check_in_time` VARCHAR(10) NOT NULL DEFAULT ''14:00'' AFTER `check_in`',
    'SELECT ''check_in_time already exists'''
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Safely add check_out_time (skip if already exists)
SET @col_exists2 = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'monarch_hotel'
      AND TABLE_NAME   = 'bookings'
      AND COLUMN_NAME  = 'check_out_time'
);

SET @sql2 = IF(@col_exists2 = 0,
    'ALTER TABLE `bookings` ADD COLUMN `check_out_time` VARCHAR(10) NOT NULL DEFAULT ''11:00'' AFTER `check_out`',
    'SELECT ''check_out_time already exists'''
);
PREPARE stmt2 FROM @sql2; EXECUTE stmt2; DEALLOCATE PREPARE stmt2;

-- Safely add package_id if not exists
SET @col_exists3 = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = 'monarch_hotel'
      AND TABLE_NAME   = 'bookings'
      AND COLUMN_NAME  = 'package_id'
);

SET @sql3 = IF(@col_exists3 = 0,
    'ALTER TABLE `bookings` ADD COLUMN `package_id` BIGINT UNSIGNED NULL AFTER `promotion_id`',
    'SELECT ''package_id already exists'''
);
PREPARE stmt3 FROM @sql3; EXECUTE stmt3; DEALLOCATE PREPARE stmt3;

SELECT 'Done! All columns added safely.' AS result;
