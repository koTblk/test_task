# test_task
To launch project you need to execute:

	"docker-compose up"
	
and use dump inside the project ("task.sql").

	"docker exec -i database mysql -uroot -proot test_task < task.sql"

used technology: PHP7.0, Mysql, Nginx, Docker, Yii2 framework.
if everything made correct - you will see project http://127.0.0.1 (http://prntscr.com/jy12e2 )
IP database : 127.0.0.1:3306

1.users (usr_id, usr_name, usr_active, usr_created)
	countries (cnt_id, cnt_code, cnt_title, cnt_created)
	numbers (num_id, cnt_id, num_number, num_created)
	
	send_log (log_id, usr_id, num_id, log_message, log_success (bool), log_created)

Users send every day messages to different numbers. Information regarding each message will be inserted to the log table.


This tables created by migration : https://github.com/koTblk/test_task/blob/master/app/migrations/m180621_151020_struct.php.

2. Task 1 (SQL): create new table send_log_aggregated for aggregated by day (Y-m-d) information.
Write SQL queries to insert data to the new table and then delete raw data from the table send_log.

This table was created via migration also : https://github.com/koTblk/test_task/blob/master/app/migrations/m180621_153311_send_log_aggregated.php
To fill data to new table, i've created cron command : https://github.com/koTblk/test_task/blob/master/app/commands/CronController.php

3. Task 2 (PHP): create Model Class for getting information from the new aggregated log. Function should receive parameters: 
	date_from (Y-m-d, required)
	date_to (Y-m-d, required)
	cnt_id (optional filter)
	usr_id (optional filter)
Function must return grouped by day (Y-m-d) results: amount of successfully sent messages and amount of failed messages.

I've made it via framework model and rules, so it's better for logic : https://github.com/koTblk/test_task/blob/master/app/models/SendLogAggregatedSearch.php

4. Task 3 (Front-End): create web page for displaying of the aggregated log. Page should contain form with filters (selectors): country, user and dates.

Here is list : https://github.com/koTblk/test_task/blob/master/app/views/site/index.php
here is search panel : https://github.com/koTblk/test_task/blob/master/app/views/site/partials/_search.php
