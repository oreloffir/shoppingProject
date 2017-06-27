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

/*Add/Edit post constants*/
define("EDIT_POST",1);
define("NEW_POST",0);
define("SALE_TYPE",0);
define("COUPON_TYPE",1);

define("POSTS_CHUNK", 12);
define("ORDER_POPULAR", "popular");
define("ORDER_RECENT", "recent");

define("ADMIN", "admin");
define("ADMIN_TYPE", 1);
?>