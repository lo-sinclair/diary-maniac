<?php

class Diary extends Blog {
	private $_settings;
    private $_login;
    private $_password;
    private $_sid = NULL;
    public $name;
	public function __construct(){
        $this->name = 'diary';
		$this->_settings = parse_ini_file('conf/diary.ini');
		//$this->user_login = urlencode($maniac->login);
		//$this->user_pass = $maniac->password;

    }

   private function query ($method, $params=NULL) {
        //$q = "?method=user.auth&username=".$login."&password=".$password."&appkey=".$o_k;
        $out = $this->get_from_diary($method, $params);

        if($out->result == 12 ) { //sid устарел
            $this->auth();
            $out = $this->get_from_diary($method, $params);
        }
        return $out;
    } 

    private function get_from_diary($method, $params) {

        if ($method != 'user.auth') {
            $params['sid'] = $this->get_sid();
        }
        $q = 'method='.$method;
        foreach($params as $k=>$v) {
            $q .= '&'.$k.'='.$v;
        }

        $url = "www.diary.ru/api/?".$q;
        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            curl_close($curl);
            return json_decode($out);
         }
         else
            return Array();
    }


    public function auth($login=NULL, $password=NULL) {
        $maniac = Maniac::getInstance();

        if (empty($login)){
            $login = $maniac->login;
        }
        if (empty($password)){
            $password = $maniac->password;
        }

        $login = urlencode(iconv("utf-8", "windows-1251", $login));
      
    	$params = Array('username' => $login,
    					'password' => $password,
    					'appkey' => $this->_settings['open_key']);

    	$result =  $this->query('user.auth', $params);
    	if($result->result>0){
            $maniac->error = $result->error;
            $maniac->login = NULL;
            $maniac->password = NULL;
    		return false;
    	}
    	else {
            $this->_sid = $result->sid;
    		$_SESSION['sid'] = $result->sid;
    	}
    	return true;

    }


    public function get_fav_readers($f=1, $r=1) { 

        $params = Array('sid' => $this->get_sid(),
                        'fields' => 'favs2,readers2');
        $result =  $this->query('user.get', $params);

        $favs = Array();
        if(!empty($result->user->favs2)) {
            foreach ($result->user->favs2 as $id=>$name) {
                $user = Array();
                $user['id'] = $id;
                $user['name'] = $name;
                //$last_update = $this->get_last_update($id);
                $last_update = "00";
                $user['last_update'] = !empty($last_update) ? $last_update : NULL;
                $favs[] = $user;
            } 
        }

        $readers = Array();
        if(!empty($result->user->readers2)) {
            foreach ($result->user->readers2 as $id=>$name) {
                $user = Array();
                $user['id'] = $id;
                $user['name'] = $name;
                //$last_update = $this->get_last_update($id);
                $last_update = "00";
                $user['last_update'] = !empty($last_update) ? $last_update : NULL;
                $readers[] = $user;
            } 
        }

        

        if ($r == 0 ) { return $favs;}
        if ($r == 0 ) { return $readers;}
        return Array('favorites'=>$favs, 'readers'=>$readers);
    }


    public function get_username($id){
        $params = Array('userid' => $id,
                            'fields' => 'username');
        $res = $this->query('user.get', $params);
        if (!$res->result>0) {
            return $res->user->username;
        }
        return NULL;
    }

    public function get_last_update($id){
        $params = Array('userid' => $id,
                        'fields' => 'last_post');

        $res = $this->query('journal.get', $params);
        return (!$res->result>0) ? $res->journal->last_post : NULL;
    }

    public function get_journalinfo($id){
        $journal = Array();
        $params = Array('userid' => $id,
                        'fields' => 'last_post, posts');

        $res = $this->query('journal.get', $params);

        if (!$res->result>0) {
            $journal['last_update']=$res->journal->last_post;
            $journal['posts_count']=$res->journal->posts;
            $journal['pades_count'] = ceil($journal['posts_count']/20);
        }
        return $journal;
    }


    public function get_entries($userid, $cur_page){
        $from=($cur_page-1)*20;
        $params = Array('type' => 'diary',
                        'juserid' => $userid,
                        'from'=>$from
                        );
        $res = $this->query('post.get', $params);

        $entries = Array();
        if (!$res->result>0) {
           foreach($res->posts as $post) {
              $entr = Array();
              $entr['id'] = $post->postid;
              $entr['body'] = $post->message_html;
              $entr['title'] = $post->title;
              $last_update = $post->comments_count_data;
              $entr['comments_count'] = !empty($last_update) ? $last_update : 0;
              $entr['date'] = date('d.m.Y - H:m:s', $post->dateline_date);

              $entries[] = $entr;
           }
        }

        return $entries;
    }


    public function get_comments($postid) {
        $post = Array();
        $params = Array('postid' => $postid);
        $res = $this->query('comment.get', $params);

        $post['comments'] = Array();
        if (!$res->result>0) {
            foreach($res->comments as $comment) {
                $comm = Array();
                $comm['date'] = date('d.m.Y - H:m:s', $comment->dateline);
                $comm['author'] = $comment->author_username;
                $comm['author_id'] = $comment->author_userid;
                $comm['avatar'] = $comment->author_avatar;
                $comm['body'] = $comment->message_html;
                $post['comments'][] = $comm;
            }
        }
        return $post;
    }


    private function get_sid() {
        if ( !isset($_SESSION['sid']) ) {
            $this->auth();
            return $this->_sid;
        }
        return $_SESSION['sid'];
    }

    public function create_password($pass) {
        $pass = iconv("utf-8", "windows-1251", $pass);
    	return (md5($this->_settings['closed_key'].$pass));
    }

}

?>