<?php
/**
 * Created by PhpStorm.
 * User: Guy
 * Date: 6/30/2017
 * Time: 1:54 PM
 */
function lang($phrase){
    static $_L = array(
        // GENERALS
        'NEED_LOGIN' => 'You need to login',
        'INVALID_POST_ID' => 'Invalid post id',

        // LOGIN
        'INVALID_LOGIN'   => 'Incorrect email or password',
        // COMMENTS
        'INVALID_COMMENT' => 'Invalid comment',
        // POSTS
        'POST_SAVE_SUCCESS'             => 'Post saved successfully',
        'ERROR_SAVE_POST'               => 'Error while saving post',
        'INVALID_POST_TITLE'            => 'Please enter post title (min 5 chars)',
        'INVALID_POST_DESCRIPTION'      => 'Please enter post description (min 10 chars)',
        'INVALID_POST_URL'              => 'Please enter a link to the product web page',
        'INVALID_POST_CATEGORY'         => 'Please select a category',
        'INVALID_POST_PRICE'            => 'Please enter a price',
        'PUBLISHER_ID_NOT_MATCH'        => 'You are unauthorized to edit',
        'INVALID_EMAIL_FORMAT'          => 'Invalid email format',

        // RANK
        'ERROR_SAVE_RANK'               => 'Error while saving rank',
        'INVALID_RANK'                  => 'Invalid rank',

        //REPORTS
        'NO_REASON_FOR_REPORT'          => 'Please enter a reason for your report',
        'ERROR_SAVE_REPORT'             => 'Error while saving report',

        // files
        'INVALID_FILE'          => 'Invalid file',
        'INVALID_FILE_FORMAT'   => 'Invalid file format',
        'FILE_TOO_LARGE'        => 'File too large',
        'ERROR_UPLOAD_IMAGE'    => 'Error while uploading image',

        // HEADER VIEW
        'HEADER_HOME'               => 'Home',
        'HEADER_CATEGORIES'         => 'Categories',
        'HEADER_FAVORITES'          => 'Favorites',
        'HEADER_ADD_POST'           => 'Add Post',
        'HEADER_ADMIN'              => 'Admin',
        'HEADER_ADMIN_EDIT_POST'    => 'Edit Post',
        'HEADER_ADMIN_USERS'        => 'Users',
        'HEADER_ADMIN_REPORTS'      => 'Reports',
        'HEADER_LOGIN'              => 'Login',
        'HEADER_LOGOUT'             => 'Logout',
        'HEADER_SIGN_UP'            => 'Sign up',
        'HEADER_EMAIL'              => 'Email',
        'HEADER_PASSWORD'           => 'Password',

        // FAVORITES
        'MY_FAVORITES'              => 'My Favorites',

        //HOME PAGE
        'ALL_CATEGORIES'            => 'All Categories',
        'SORT_BY'                   => 'Sort By',
        'SORT_BY_MOST_RECENT'       => 'Most Recent',
        'SORT_BY_MOST_POPULAR'      => 'Most Popular',

        // POST DIALOG
        'POST_DIALOG_COMMENTS'      => 'Comments',
        'POST_DIALOG_BASED_ON'      => 'Based On',
        'POST_DIALOG_USERS'         => 'users',
        'POST_DIALOG_CLOSE'         => 'Close',
        'POST_DIALOG_BUY'           => 'Buy!',
        'POST_DIALOG_ADD_COMMENT'   => 'Add Comment',

        // ADD POST / EDIT POST VIEW
        'ADD_POST_TITLE'    => 'Add Post',
        'EDIT_POST_TITLE'   => 'Edit Post',
        'TITLE'             => 'Title',
        'ENTER_TITLE'       => 'Please enter title',
        'DESCRIPTION'       => 'Description',
        'ENTER_DESCRIPTION' => 'Please enter description',
        'PRICE'             => 'Price',
        'CURRENCY'          => '$',
        'SALE_URL'          => 'Sale URL',
        'ENTER_SALE_URL'    => 'Please enter a link to sale page',
        'UPLOAD_IMAGE'      => 'Upload Image',
        'CATEGORY'          => 'Category',
        'COUPON'            => 'Coupon',
        'COUPON_CODE'       => 'Coupon code',
        'SUBMIT_ADD'        => 'Add Post',
        'SUBMIT_EDIT'       => 'Update Post',


        // Time Ago
        'WEEK'          => 'week',
        'WEEKS'         => 'weeks',
        'DAY'           => 'day',
        'DAYS'          => 'days',
        'HOUR'          => 'hour',
        'HOURS'         => 'hours',
        'MINUTE'        => 'minute',
        'MINUTES'       => 'minutes',
        'YESTERDAY_AT'  => 'yesterday at',
        'AGO'           => 'ago',
        'LESS_THEN_MIN' => 'less then a minute',

        // Limit Errors
        'COMMENTS_LIMIT_ERROR' => "you can comment every 30 sec",
        'POSTS_LIMIT_ERROR' => "you can add post every 30 minutes",
        'INVALID_USER_EMAIL' => "Invalid email format",
        'INVALID_USER_PASSWORD' => "Invalid password format",
        'INVALID_USER_DISPLAY_NAME' => "Invalid display name format",
        'INVALID_USER_PASSWORD_LEN' => 'Please enter password (min 6 chars)',
        'INVALID_USER_DISPLAY_NAME_LEN' => 'Please enter display name (min 2 chars , max 18 chars)'

    );
    return (!array_key_exists($phrase,$_L)) ? $phrase : $_L[$phrase];
}