-- Create the user and the database:
-- NB: SKAL KOERES AF BRUGER MED RIGTIGE PRIVILEGES

-- in the below, replace dbname, uname, pass and host with variables from siteInfo.php
CREATE database IF NOT EXISTS frometou_db; 
grant usage on frometou_db.* to frometou_user@localhost identified by 'frometou_pass'; 
grant all privileges on frometou_db.* to frometou_user@localhost ;

-- create KFM database and user
CREATE database IF NOT EXISTS frometou_kfm; 
grant usage on frometou_kfm.* to frometou_kfm_u@localhost identified by 'frometou_kfm_p'; 
grant all privileges on frometou_kfm.* to frometou_kfm_u@localhost ;

