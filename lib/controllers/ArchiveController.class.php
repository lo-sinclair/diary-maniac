<?php
class ArchiveController extends Page implements IController {
	private $maniac;

	public function __construct(){
		parent::__construct();
    }

	public function defaultAction() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();
		$regions = Array('content'=>$this->getinfoContent());	
		$view->build_page($regions);
	}


	public function getpostsAction() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();
		$regions = Array('content'=>$this->getpostsContent());	
		$view->build_page($regions);
	}

	public function getentrieAction() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();
		$regions = Array('content'=>$this->getentrieContent());	
		$view->build_page($regions);
	}


	public function getinfoContent() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();

		$user = Array();
		$vars_c = Array();

		if ($params['userid']){
			$user['id'] = $params['userid'];
			$user['name'] = $maniac->blog->get_username($params['userid']);
			$journal_data = $maniac->blog->get_journalinfo($params['userid']);
			$journal_data['last_update'] = date('d.m.Y в H:m:s', $journal_data['last_update']);
			$user += $journal_data;
		
			$vars_c['user'] = $user;
		}
		else {
			$maniac->error = "Не указан ID пользователя";
		}

		$region = $view->render('create_archive.tpl.php', $vars_c);
		return $region;
	}


	public function getpostsContent() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();
		$vars_c = Array();

		$current_page = isset($params['page']) ? $params['page'] : 1;
		$entries = $maniac->blog->get_entries($params['userid'], $current_page);
		$vars_c['entries'] = $entries;

		//Номера страниц
		$journal_data = $maniac->blog->get_journalinfo($params['userid']);
		$pades_count = $journal_data['pades_count'];
		$url = BASE_URL.'/archive/getposts/?userid='.$params['userid'];
		
		
		$vars_c['pager'] = $this->Paginator($current_page, $pades_count, 4, $url);

		$region = $view->render('elements/entries.tpl.php', $vars_c);
	
		return $region;
	}

	public function getentrieContent() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();
		$vars_c = Array();

		$entrie = Array();
		$comments = Array();

		if ($params['postid']){
			$entrie['id'] = $params['postid'];
			$comments = $maniac->blog->get_comments($entrie['id']);
		}
		else {
			$maniac->error = "Не указан ID записи";
		}
	}

}