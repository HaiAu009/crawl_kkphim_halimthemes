<?php

define('API_DOMAIN', 'https://phimapi.com');
define('CRAWL_KKPHIM_OPTION_SETTINGS', 'crawl_kkphim_schedule_settings');
define('CRAWL_KKPHIM_OPTION_RUNNING', 'crawl_kkphim_schedule_running');
define('CRAWL_KKPHIM_OPTION_SECRET_KEY', 'crawl_kkphim_schedule_secret_key');

define('SCHEDULE_CRAWLER_TYPE_NOTHING', 0);
define('SCHEDULE_CRAWLER_TYPE_INSERT', 1);
define('SCHEDULE_CRAWLER_TYPE_UPDATE', 2);
define('SCHEDULE_CRAWLER_TYPE_ERROR', 3);
define('SCHEDULE_CRAWLER_TYPE_FILTER', 4);