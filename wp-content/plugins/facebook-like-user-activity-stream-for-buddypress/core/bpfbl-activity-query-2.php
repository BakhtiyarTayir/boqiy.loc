<?php
// Do not allow direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}
/**
 * Query filter for activity.
 *
 * @package    fb-like-activity-stream
 * @copyright  Copyright (c) 2018, Brajesh Singh
 * @license    https://www.gnu.org/licenses/gpl.html GNU Public License
 * @author     Brajesh Singh
 * @since      1.2.0
 */
class BPFBLike_Activity_Query2 {

	/**
	 * Are we doing FB Like activity stream.
	 *
	 * @var bool
	 */
	private $doing = false;

	/**
	 * Is it activity ids based fetch.
	 *
	 * @var bool
	 */
	private $is_specific_fetch = false;

	/**
	 * Name for the value of scope.
	 *
	 * @var string
	 */
	private $scope_name = 'fblstream';

	/**
	 * Where conditions of the activity.
	 *
	 * @var array
	 */
	private $where_conditions = array();

	/**
	 * Activity query args.
	 *
	 * @var array
	 */
	private $args;

	/**
	 * Select sql.
	 *
	 * @var string
	 */
	private $select_sql;

	/**
	 * From sql caluse.
	 *
	 * @var string
	 */
	private $from_sql;

	/**
	 * Join Clause
	 *
	 * @var string
	 */
	private $join_sql;

	/**
	 * Sort.
	 *
	 * @var string
	 */
	private $sort;

	/**
	 * Order by.
	 *
	 * @var string
	 */
	private $order_by;
	/**
	 * Reset state.
	 */
	public function reset() {
		$this->doing             = false;
		$this->is_specific_fetch = false;
		$this->where_conditions  = array();
		$this->args              = array();
		$this->select_sql        = '';
		$this->from_sql          = '';
		$this->join_sql          = '';
		$this->sort              = '';
		$this->order_by          = '';
	}

	/**
	 * Setup hooks.
	 */
	public function setup() {

		add_filter( 'bp_after_has_activities_parse_args', array( $this, 'parse_has_activities' ) );
		add_filter( 'bp_after_activity_get_specific_parse_args', array( $this, 'parse_specific_activities_fetch' ) );
		add_filter( 'bp_activity_get_where_conditions', array( $this, 'save_where_clause' ), 10001, 5 );
		add_filter( 'bp_activity_get_join_sql', array( $this, 'save_join_clause' ), 10001 );
		add_filter( 'bp_activity_paged_activities_sql', array( $this, 'filter_paged_sql_ids' ), 10001, 2 );
	}

	/**
	 * Parse has_Activities args and add our marker.
	 *
	 * @param array $args activity args.
	 *
	 * @return array
	 */
	public function parse_has_activities( $args ) {
		// reset scope.
		$this->reset();

		if ( isset( $args['scope'] ) && bpfblike_get_user_stream_slug() === $args['scope'] ) {
			$args['scope'] = $this->scope_name;
			$this->doing   = true;

			return $args;
		}

		if ( ! empty( $args['scope'] ) ) {
			return $args;
		}

		// scope is not set and we are on directory.
		if ( bpfblike_is_enabled_for( 'dir' ) && bp_is_activity_directory() ) {
			$args['scope'] = $this->scope_name;
			$this->doing   = true;
		}

		return $args;
	}

	/**
	 * Parse specific ids based query and set the flag.
	 *
	 * @param array $args args.
	 *
	 * @return array
	 */
	public function parse_specific_activities_fetch( $args ) {
		$this->reset();
		$this->doing             = false;
		$this->is_specific_fetch = true;

		return $args;
	}


	/**
	 * Filtering where_conditions clause.
	 *
	 * @param array  $where_conditions conditions sql.
	 * @param array  $r args.
	 * @param string $select_sql select sql.
	 * @param string $from_sql from sql.
	 * @param string $join_sql join sql.
	 *
	 * @return array
	 */
	public function save_where_clause( $where_conditions, $r, $select_sql, $from_sql, $join_sql ) {

		// only if our scope.
		if ( $this->is_specific_fetch || ! $this->is_our_scope( $r ) ) {
			return $where_conditions;
		}

		$this->doing = true;
		/**
		 * Save details.
		 */
		$this->where_conditions = $where_conditions;
		$this->args             = $r;
		$this->select_sql       = $select_sql;
		$this->from_sql         = $from_sql;
		$this->join_sql         = $join_sql;

		// update sorting details.
		$sort = $r['sort'];
		if ( $sort != 'ASC' && $sort != 'DESC' ) {
			$sort = 'DESC';
		}

		$this->sort = $sort;

		$this->order_by = 'a.' . $r['order_by'];

		return $where_conditions;
	}

	/**
	 * Filter and update join sql.
	 *
	 * @param string $join_sql join sql.
	 *
	 * @return string
	 */
	public function save_join_clause( $join_sql ) {
		if ( $this->doing ) {
			$this->join_sql = $join_sql;
		}

		return $join_sql;
	}

	/**
	 * Filter paged sql and replace with ours.
	 *
	 * @param string $paged_sql paged sql.
	 *
	 * @return string
	 */
	public function filter_paged_sql_ids( $paged_sql, $args ) {

		if ( ! $this->doing || $this->is_specific_fetch ) {
			return $paged_sql;
		}

		$r = $this->args;

		// Sanitize page and per_page parameters.
		$page     = absint( $r['page'] );
		$per_page = absint( $r['per_page'] );

		$user_id = get_current_user_id();

		$user_ids = $this->get_all_relavant_user_ids( $user_id );
		global $wpdb;
		$query_group_activities = '';

		if ( bp_is_active( 'groups' ) ) {
			$group_ids = groups_get_user_groups( $user_id );
			$group_ids = $group_ids['groups'];
			if ( $group_ids ) {
				$group_list             = '(' . join( ',', $group_ids ) . ')';
				$query_group_activities = $wpdb->prepare( "( component = %s AND item_id IN $group_list )", 'groups' );
			}
		}
		$where_conditions = $this->where_conditions;
		unset( $where_conditions['filter_sql'] );
		$filter_query = '';
		if ( ! empty( $args['filter'] ) ) {
			$filter = $args['filter'];
			unset( $filter['user_id'] );
			$filter_query = BP_Activity_Activity::get_filter_sql( $filter );
		}

		// overwrite scope sql.
		$user_ids_list = '(' . join( ',', $user_ids ) . ')';

		$where_conditions['scope_query_sql'] = $wpdb->prepare( "user_id IN {$user_ids_list} AND hide_sitewide = %d", 0 );
		$where_clause = '(' . join( ' AND ', $where_conditions ) . ')';

		if ( $query_group_activities ) {
			$where_clause = '(' . $where_clause . ' OR ' . $query_group_activities . ')';
		}

		if ( $filter_query ) {
			$where_clause = '(' . $filter_query . ') AND ' . $where_clause;
		}

		$where_sql = 'WHERE ' . $where_clause;

		// Query first for activity IDs.
		$activity_ids_sql = "{$this->select_sql} {$this->from_sql} {$this->join_sql} {$where_sql} ORDER BY {$this->order_by} {$this->sort}, a.id {$this->sort}";

		if ( ! empty( $per_page ) && ! empty( $page ) ) {
			// We query for $per_page + 1 items in order to
			// populate the has_more_items flag.
			$activity_ids_sql .= $wpdb->prepare( " LIMIT %d, %d", absint( ( $page - 1 ) * $per_page ), $per_page + 1 );
		}

		/**
		 * Filters the paged activities MySQL statement.
		 *
		 * @param string $activity_ids_sql MySQL statement used to query for Activity IDs.
		 * @param array  $r                Array of arguments passed into method.
		 */
		$activity_ids_sql = apply_filters( 'bpfblike_activity_paged_activities_sql', $activity_ids_sql, $r );

		return $activity_ids_sql;
	}



	/**
	 * Determine if parsing our scope.
	 *
	 * @param array $args args.
	 *
	 * @return bool
	 */
	private function is_our_scope( $args ) {
		return isset( $args['scope'] ) && $args['scope'] === $this->scope_name;
	}

	/**
	 * Get all the user ids whose activity is important for us
	 *
	 * @param int $user_id user id.
	 *
	 * @return array
	 */
	public function get_all_relavant_user_ids( $user_id ) {

		$friend_ids = $this->get_friends_ids( $user_id );

		$followers_ids = $this->get_followers_ids( $user_id );

		$following_ids = $this->get_following_ids( $user_id );

		$user_ids = array();

		if ( apply_filters( 'fblike_activity_include_friends', true ) ) {
			$user_ids = array_merge( $user_ids, $friend_ids );
		}

		// should we include following users? Yes, by default.
		if ( apply_filters( 'fblike_activity_include_following', true ) ) {
			$user_ids = array_merge( $user_ids, $following_ids );
		}

		if ( apply_filters( 'fblike_activity_include_followers', false, $user_id ) ) {
			$user_ids = array_merge( $user_ids, $followers_ids );
		}

		if ( apply_filters( 'fblike_activity_include_self', true, $user_id ) ) {
			array_push( $user_ids, $user_id );
		}

		$user_ids = array_unique( $user_ids );

		// keeping the filter name for backward compatibility.
		return apply_filters( 'fblike_activity_get_friend_ids', $user_ids, $user_id );
	}

	/**
	 * Get an array of user's friend user ids
	 *
	 * @param int $user_id user id.
	 *
	 * @return array
	 */
	private function get_friends_ids( $user_id ) {

		if ( function_exists( 'friends_get_friend_user_ids' ) ) {
			$user_ids = friends_get_friend_user_ids( $user_id );
		} else {
			$user_ids = array();
		}

		return $user_ids;
	}


	/**
	 *  Get the follower users ids of the user
	 *
	 * @param int $user_id numeric user id.
	 *
	 * @return array
	 */
	private function get_followers_ids( $user_id ) {

		if ( function_exists( 'bp_get_follower_ids' ) ) {
			$user_ids = bp_get_followers( array( 'user_id' => $user_id ) );
		} elseif ( function_exists( 'bp_follow_get_followers' ) ) {
			$user_ids = bp_follow_get_followers( array( 'user_id' => $user_id ) );
		} else {
			$user_ids = array();
		}

		return $user_ids;
	}

	/**
	 * Get all the users whom the given user is following
	 *
	 * @param int $user_id numeric user id.
	 *
	 * @return array
	 */
	private function get_following_ids( $user_id ) {

		if ( function_exists( 'bp_get_following_ids' ) ) {
			$user_ids = bp_get_following( array( 'user_id' => $user_id ) );
		} elseif ( function_exists( 'bp_follow_get_following' ) ) {
			$user_ids = bp_follow_get_following( array( 'user_id' => $user_id ) );
		} else {
			$user_ids = array();
		}

		return $user_ids;
	}


}

$query = new BPFBLike_Activity_Query2();
$query->setup();
