<?php
/**
	* @author Guy Chabra 
	* Storage Manager api
**/
include_once("db.class.php");
include_once("consts.php");

class StorageManager
{
	private $_db;

	public function __construct()
    {
    	$this->_db = new Db();
    }

    public function __destruct()
	{
		unset($this->_db);
	}

	/**
	* Save Post object to database.
	* To write a new Post set post->id to 0
	* To update a Post set post->id to the postId you would like to edit.
	* @param Post object to write
	* @return the new post id if succeed, otherwise false
	* @access public
	**/
	public function savePost($post)
	{
		if(!($post instanceof Post))
			return false;
		// TO DO: FIX
		if( !($this->checkUser($post->publisherId)) )
			return false;
		return $this->saveObjectWithId(POSTS_TABLE, $post);
	}

	/**
	* Delete a Post
	* @param postId The post Id
	* @param userId The user Id who published this post
	* @return bool
	* @access public
	**/
	public function deletePost($postId, $userId)
	{
		$postId = $this->_db->filter($postId);
		$result = $this->_db->simpleSelectQuery( POSTS_TABLE, array('id' => $postId) );
		if((!empty($result)) && $result[0]['publisherId'] == $userId)
		{
			$this->_db->deleteQuery(POSTS_TABLE, 	 array('id' => $postId));
			$this->_db->deleteQuery(COMMENTS_TABLE,  array('relativeId' => $postId));
			$this->_db->deleteQuery(FAVORITES_TABLE, array('relativeId' => $postId));
			$this->_db->deleteQuery(RANK_TABLE, 	 array('relativeId' => $postId));
			return true;
		}
		return false;
	}

	/**
	* Save Coupon object to database.
	* To write a new Coupon set coupon->id to 0
	* To update a Coupon set coupon->id to the postId you would like to edit.
	* @param Coupon object to write
	* @return the new Coupon id if succeed, otherwise false
	* @access public
	**/
	public function saveCoupon($coupon)
	{
		if(!($coupon instanceof Post))
			return false;
		if( !($this->checkUser($coupon->publisherId)) )
			return false;
		$coupon->postType = 1;
		return $this->saveObjectWithId(POSTS_TABLE, $coupon);
	}

	/**
	* Delete a Coupon
	* @param couponId The coupon Id
	* @param userId The user Id who published this coupon
	* @return bool
	* @access public
	**/
	public function deleteCoupon($couponId, $userId){
		return $this->deletePost($couponId, $userId);
	}

	/**
	* Save Comment object to database.
	* To write a new Comment set comment->id to 0
	* To update a Comment set comment->id to the comment id you would like to edit.
	* @param Comment object to write
	* @return the new Comment id if succeed, otherwise false
	* @access public
	**/
	public function saveComment($comment)
	{
		if( !($comment instanceof Comment) )
			return false;
		if( !($this->checkUser($comment->publisherId)) )
			return false;
		return $this->saveObjectWithId(COMMENTS_TABLE, $comment);
	}

	/**
	* Delete a Comment
	* @param commentId The comment Id
	* @param userId The user Id who published this comment
	* @return bool
	* @access public
	**/
	public function deleteComment($commentId, $userId)
	{
		$commentId = $this->_db->filter($commentId);
		$result    = $this->_db->simpleSelectQuery(COMMENTS_TABLE, array('id' => $commentId) );

		if((!empty($result)) && ($result[0]['publisherId'] == $userId)){
			return $this->_db->deleteQuery(COMMENTS_TABLE,  array('id' => $commentId));
		}
		return false;
	}

	/**
	* Save Report object to database.
	* @param report - Report object to write
	* @return the new report id if succeed, otherwise false
	* @access public
	**/
	public function addReport($report)
	{
		if(!($report instanceof Report))
			return false;
		if($this->checkTableRowById(POSTS_TABLE, $report->relativeId) && $this->checkUser($report->userId))
			return $this->saveObjectWithId(REPORT_TABLE, $report);
		
		return false;
	}

	/**
	* Add a post or a coupon to favorites of a user
	* @param userId - the user id that would like to add the post to his favorites
	* @param postId - the required post id
	* @return true if succeed, otherwise false
	* @access public
	**/
	public function addToFavorites($userId, $postId)
	{
		if($this->checkTableRowById(POSTS_TABLE, $postId))
		{
		    if($this->checkUser($userId)) {
                $favArr = array(
                    'userId' => $userId,
                    'relativeId' => $postId
                );
                $favArr = $this->_db->filter($favArr);
                $result = $this->_db->simpleSelectQuery(FAVORITES_TABLE, $favArr);
                if (empty($result))
                    return $this->_db->insertQuery(FAVORITES_TABLE, $favArr);
            }
		}
		return false;
	}

	/**
	* Remove a post or a coupon from favorites of a user
	* @param userId - the user id that would like to remove the post from his favorites
	* @param postId - the unrequired post id
	* @return true if succeed, otherwise false
	* @access public
	**/
	public function removeFromFavorites($userId, $postId)
	{
		$where = array(
			'userId' 	 => $userId,
			'relativeId' => $postId
		);
		$where = $this->_db->filter($where);
		return 	 $this->_db->deleteQuery(FAVORITES_TABLE, $where);
	}

	/**
	* Rank a post by a user
	* @param userId - the user id that would like to rank a post.
	* @param postId - the required post id
	* @param rank   - the rank [1-5]
	* @return true if succeed, otherwise false
	* @access public
	**/
	public function rankPost($userId, $postId, $rank)
	{
		if($rank > MAX_RANK || $rank < MIN_RANK)
			return false;
		if($this->checkTableRowById(POSTS_TABLE, $postId) && $this->checkUser($userId))
		{
			$where = array(
				'userId' 	 => $userId,
				'relativeId' => $postId
			);
			$where 	= $this->_db->filter($where);
			$result = $this->_db->simpleSelectQuery(RANK_TABLE, $where);
			if(empty($result))
			{
				$rateArr = $where;
				$rateArr['rank'] = $this->_db->filter($rank);
				if($this->_db->insertQuery(RANK_TABLE, $rateArr))
				    return INSERT;
			}else
			{
				$rateArr = array(
					'rank' => $this->_db->filter($rank)
				);
				if($this->_db->updateQuery(RANK_TABLE, $rateArr, $where))
                    return UPDATE;
			}
		}
		return false;
	}

	/**
	* Add a user
	* @param User user
	* @return userId, otherwise array of errors
	* @access public
	**/
	public function addUser($user)
	{
		$errors = array();
		if(!($user instanceof User))
			return false;
		$userEmail = $this->_db->filter($user->email);
		$result    = $this->_db->simpleSelectQuery(USERS_TABLE, array('email' => $userEmail));
		if(empty($result))
		{
			$user->password = openssl_digest($user->password, 'sha512');
			return $this->saveObjectWithId(USERS_TABLE, $user);
		}else
		{
			$errors[] = EMAIL_TAKEN;
		}
		return $errors;
	}

	public function getUserById($userId){
        $userId = $this->_db->filter($userId);
        $where = array(
            'id' => $userId
        );
        $user = $this->_db->simpleSelectQuery(USERS_TABLE, $where)[0];
        unset($user['password']);
        return $user;
    }

	/**
	 	* Login to the system
	 	* @param email - the mail of the user
	 	* @param pass  - the password of the user, not encrypted.
	 	* @return userId if succeed, false otherwise 
	 	* @access public
	**/
	public function login($email, $pass){
		$userLoginInfo = array(
			'email' 	=> $email,
			'password' 	=> openssl_digest($pass, 'sha512')
		);
		$result  = $this->_db->simpleSelectQuery(USERS_TABLE, $userLoginInfo);
		if(!empty($result))
			return $result[0];
		return false;
	}

	/**
	 	* Save object (insert or update if exists) with have public attribute 'id'
	 	* @param tableName - the database table to insert or update.
	 	* @param obj 	   - the object to save, must contain attribute 'id' and all colums of the table above. 
	**/
	private function saveObjectWithId($tableName, $obj)
	{
		$objMap = $this->_db->filter( (array) $obj );
		// Check if the postId is already in our database
		// In that case we just need to update
		if($this->checkTableRowById($tableName, $objMap['id']))
		{
			$where = array('id' => $objMap['id']);
			unset($objMap['id']);
			return $this->_db->updateQuery($tableName, $objMap, $where);
		}
		// This is a new post, we need to insert
		else{
			unset($objMap['id']);
			return $this->_db->insertQuery($tableName, $objMap);
		}
	}

    //------------------------------------- ADMIN METHODS ------------------------------------------//

    public function getCategories(){
	    $fields = array(
            CATEGORIES_TABLE => array("*")
        );
        $sql = new SqlSelectStatement("SELECT");
        $sql->addSelectFields($fields)
            ->addTableName(CATEGORIES_TABLE);

        return $this->_db->selectQuery($sql->getSqlStatement());
    }

    public function getReports($start, $count, $where = array(), $orders = array('reports.id' => 'DESC')){
        $fields = array(
            REPORT_TABLE => array("*"),
            USERS_TABLE  => array("displayName")
        );
        $where = $this->_db->filter($where);
        $sql = new SqlSelectStatement("SELECT");
        $sql->addSelectFields($fields)
            ->addTableName(REPORT_TABLE)
            ->addToBody("JOIN ".USERS_TABLE." ON(".REPORT_TABLE.".userId = ".USERS_TABLE.".id)")
            ->addWhere($where)
            ->addOrderBy($orders)
            ->addLimit($start, $count);
        return $this->_db->selectQuery($sql->getSqlStatement());
    }

    public function getUsers(){
        $fields = array(
            USERS_TABLE  => array("id","displayName", "email", "startTime", "lastKnownIp", "type"),
            BANS_TABLE   => array("startTime", "endTime", "reason")
        );
        $sql = new SqlSelectStatement("SELECT");
        $sql->addSelectFields($fields)
            ->addTableName(USERS_TABLE)
            ->addToBody("LEFT JOIN banlist ON ( users.id = banlist.userId )");

        return $this->_db->selectQuery($sql->getSqlStatement());
    }

    /**
     * Add a ban
     * @param userId , startTime, endTime, reason
     * @return banId, otherwise array of errors
     * @access public
     **/
    public function addBanToUser($userId, $startTime, $endTime, $reason )
    {
        $errors = array();
        $banInputs = array(
            "userId"    => $userId,
            "startTime" => $startTime,
            "endTime"   => $endTime,
            "reason"    => $reason
        );
        $banInputs = $this->_db->filter($banInputs);

        $result    = $this->_db->insertQuery(BANS_TABLE, $banInputs);

    }

    /**
     * Remove ban
     * @param userId
     * @return true if remove success, otherwise false
     * @access public
     **/
    public function removeBan($userId)
    {
        $banInputs = $this->_db->filter($userId);

        return $this->_db->deleteQuery(BANS_TABLE, array('userId' => $userId));
    }

    /**
     * Remove report
     * @param reportId
     * @return true if remove success, otherwise false
     * @access public
     **/
    public function removeReport($reportId)
    {
        $banInputs = $this->_db->filter($reportId);

        return $this->_db->deleteQuery(REPORT_TABLE, array('id' => $reportId));
    }

	//------------------------------------- POSTS METHODS ------------------------------------------//

	public function getPosts($start, $count, $where = array(), $orders = array('posts.id' => 'DESC'), $like = array())
	{
	    if($orders == null)
            $orders = array('posts.id' => 'DESC');
		$start  	= $this->_db->filter( $start );
		$count  	= $this->_db->filter( $count );
		$where  	= $this->_db->filter( $where );
		$orders  	= $this->_db->filter( $orders );
		$like       = $this->_db->filter( $like );

		$sql = new SqlSelectStatement("
			SELECT 
				posts.*, 
				AVG(ranking.rank) AS rank, 
				COUNT(ranking.relativeId) AS rankCount, 
				users.displayName,
				categories.category as categoryName");
		$sql->addTableName(POSTS_TABLE)
			->addToBody("JOIN users ON (users.id = posts.publisherId)")
			->addToBody("LEFT JOIN ranking ON (posts.id = ranking.relativeId)")
            ->addToBody("JOIN categories ON (posts.category = categories.id)")
			->addWhere($where)
            ->addLike($like)
			->addToBody("GROUP BY(case when relativeId is null then posts.id else relativeId end)")
			->addOrderBy($orders)
			->addLimit($start, $count);
		//echo "<b>".$sql->getSqlStatement()."</b><br>";
		return $this->_db->selectQuery($sql->getSqlStatement());
	}

	public function getPopularPosts($start, $count, $where = array()){
		$start  		= $this->_db->filter( $start );
		$count  		= $this->_db->filter( $count );
		$orders = array(
			'rank' 		=> "DESC",
			'rankCount' => "DESC"
		);
		return $this->getPosts($start, $count, $where, $orders);
	}

	public function getFavoritesPosts($userId, $start, $count, $orders = array('posts.id' => 'DESC')){
        $userId  	= $this->_db->filter( $userId );
        $selectedFields = array(
            FAVORITES_TABLE => array('relativeId')
        );
        $where = array(
            "userId" => $userId
        );
        $orderBy = array(
            "id" => "DESC"
        );

        $whereIn = array();
        $whereInSql = new SqlSelectStatement("SELECT");
        $whereInSql ->addSelectFields($selectedFields)
                    ->addTableName(FAVORITES_TABLE)
                    ->addWhere($where)
                    ->addOrderBy($orderBy);

        $results = $this->_db->selectQuery($whereInSql->getSqlStatement());
        foreach($results as $row)
            $whereIn[] = $row["relativeId"];
        $whereIn = array(
            "posts.id" => $whereIn
        );
        return $this->getPosts($start, $count, $whereIn, $orders);
    }

    public function getCouponPosts($start, $count, $where = array(), $orders = array('posts.id' => 'DESC'))
	{
		$where['postType'] = 1;
		$this->getPosts($start, $count, $where, $orders);
	}

	public function getSalePosts($start, $count, $where = array(), $orders = array('posts.id' => 'DESC'))
	{
		$where['postType'] = 0;
		$this->getPosts($start, $count, $where, $orders);
	}

	public function getComments($where){
	    $where = $this->_db->filter($where);
	    return $this->_db->simpleSelectQuery(COMMENTS_TABLE, $where);
    }

	public function getPostComments($postId, $start, $count)
	{
		$selectedFields = array(
			COMMENTS_TABLE 	=> array('*'),
			USERS_TABLE 	=> array('displayName')
		);

		$where = array(
			"comments.relativeId" => $postId
		);

		$orderBy = array(
		    "comments.time" => "DESC"
        );

		$sql = new SqlSelectStatement("SELECT");
		$sql->addSelectFields($selectedFields)
			->addTableName(COMMENTS_TABLE)
			->addToBody("JOIN users ON (users.id = comments.publisherId)")
			->addWhere($where)
            ->addOrderBy($orderBy)
			->addLimit($start, $count);

		return $this->_db->selectQuery($sql->getSqlStatement());
	}

	public function checkUserFavorite($userId,$postId){
	    $where = array(
	        "userId" => $userId,
            "relativeId" => $postId
        );
	    $result = $this->_db->simpleSelectQuery(FAVORITES_TABLE,$where);
	    if(!empty($result))
	        return true;
	    return false;
    }

	// --------------------------------   VALIDATION METHODS  ------------------------------------- //
	private function checkTableRowById($tableName, $objectId)
	{
		$where  	= $this->_db->filter( array( 'id' => $objectId ) );
		$tableName 	= $this->_db->filter( $tableName );
		$result 	= $this->_db->simpleSelectQuery($tableName, $where);
		if(empty($result)){
			return false;
		}
		return true;
	}

	public function checkUser($userId)
	{
		$userId = $this->_db->filter($userId);
		$result = $this->_db->selectQuery("
		SELECT 
			users.id AS userId, 
			banlist.userId AS banned
		FROM users 
		LEFT JOIN banlist ON ( users.id = banlist.userId ) 
		WHERE users.id = ".$userId);
		if(empty($result))
            return false;
		else
		{
			if($result[0]['banned'] == $userId)
				return false;
		}
		return true;
	}

	public function checkTableRecordsByTime($tableName, $userId, $time){
        $sql = "SELECT * FROM ".$tableName ." WHERE publisherId = $userId AND time > $time";
        return $this->_db->numRows($sql);
    }
}

?>