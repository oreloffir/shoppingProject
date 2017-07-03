<?php
define("MAX_RANK", 5);
define("MIN_RANK", 1);
define("POSTS_SALE_TYPE", 0);
define("POSTS_COUPON_TYPE", 1);
define("INSERT", 1);
define("UPDATE", 2);

/*Tables constants*/
define("POSTS_TABLE", "posts");
define("USERS_TABLE", "users");
define("BANS_TABLE", "banlist");
define("COMMENTS_TABLE", "comments");
define("FAVORITES_TABLE", "favorites");
define("IGNORE_TABLE", "ignorelist");
define("PM_TABLE", "privatemsg");
define("RANK_TABLE", "ranking");
define("REPORT_TABLE", "reports");
define("CATEGORIES_TABLE", "categories");

define("EMAIL_TAKEN", "email is alredy taken");

/* Add/Edit post constants*/
define("EDIT_POST",1);
define("NEW_POST",0);
define("SALE_TYPE",0);
define("COUPON_TYPE",1);
define("MINIMUM_TITLE_LEN", 5);
define("MINIMUM_DESCRIPTION_LEN", 10);

define("POSTS_CHUNK", 12);
define("ORDER_POPULAR", "popular");
define("ORDER_RECENT", "recent");
define("FAVORITES_POSTS", "favorites");
define("PROFILE_POSTS", "profile");
define("SEARCH_POSTS", "search");



/* Admin constants */
define("ADMIN", "admin");
define("ADMIN_TYPE", 1);
define("REGULAR_TYPE", 0);

/* Limits constants */
define("COMMENTS_TIME_LIMIT", "- 30 seconds");
define("COMMENTS_NUM_LIMIT", 1);

define("POSTS_TIME_LIMIT", "- 3 minutes");
define("POSTS_NUM_LIMIT", 1);

define("MINIMUM_PASSWORD_LEN", 6);
define("MINIMUM_DISPLAY_NAME_LEN", 5);
define("MAXIMUM_DISPLAY_NAME_LEN", 18);




?>