UPDATE restaurant_chain_supplier
SET status = 'live';

UPDATE distributor_supplier
SET status = 'live';

UPDATE farmers_market_supplier
SET status = 'live';

UPDATE manufacture_supplier
SET status = 'live';

UPDATE restaurant_supplier
SET status = 'live';

UPDATE farm_supplier
SET status = 'live';

--
-- 8/30/2010
--

UPDATE farm
SET status = 'live';

UPDATE farmers_market
SET status = 'live';

UPDATE manufacture
SET status = 'live';

UPDATE restaurant
SET status = 'live';

UPDATE distributor
SET status = 'live';

UPDATE restaurant_chain
SET status = 'live';

UPDATE farm
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE farmers_market
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE manufacture
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE restaurant
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE distributor
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE restaurant_chain
SET user_id = '1', 
track_ip = '174.143.112.149';


--
-- 9/10/2010
--
UPDATE restaurant_chain_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE distributor_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE farmers_market_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE manufacture_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE restaurant_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE farm_supplier
SET user_id = '1', 
track_ip = '174.143.112.149';

UPDATE product
SET track_ip = '174.143.112.149';


--
-- 9/19/2010
--
ALTER TABLE address ADD COLUMN claims_sustainable INT(1) NULL DEFAULT NULL  AFTER geocoded ;

UPDATE address SET claims_sustainable = 0;

