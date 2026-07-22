-- Update facilities table
UPDATE facilities 
SET description = 'The Royal Crest signature restaurant serves an exquisite array of Filipino and international cuisine. From hearty breakfast buffets to intimate candlelit dinners, our culinary team crafts every dish with passion.'
WHERE slug = 'restaurant';

UPDATE facilities 
SET description = 'Surrender to tranquility at Royal Crest Spa. Our expert therapists offer a curated menu of massages, body treatments, and facials using locally sourced, natural ingredients.'
WHERE slug = 'spa';

UPDATE facilities 
SET description = 'Create the wedding of your dreams at Royal Crest Hotel. Our stunning grand ballroom and garden venues provide the perfect backdrop for your most special day.'
WHERE slug = 'wedding-venue';

-- Update rooms table
UPDATE rooms 
SET description = REPLACE(description, 'Monarch Hotel', 'Royal Crest Hotel')
WHERE description LIKE '%Monarch Hotel%';

-- Update promotions table
UPDATE promotions 
SET description = REPLACE(description, 'Monarch Hotel', 'Royal Crest Hotel')
WHERE description LIKE '%Monarch Hotel%';

-- Update settings table
UPDATE settings SET value = 'https://facebook.com/royalcresthotel' WHERE `key` = 'facebook_url';
UPDATE settings SET value = 'https://instagram.com/royalcresthotel' WHERE `key` = 'instagram_url';
UPDATE settings SET value = 'https://twitter.com/royalcresthotel' WHERE `key` = 'twitter_url';
