<?php
class IndexController extends Page implements IController {
	private $maniac;

	public function __construct(){
		
    }


	public function defaultAction() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		$view = new View();


		$vars_c = Array();
		if ($maniac->login) { 

			$fav_readers = $maniac->blog->get_fav_readers();
			$vars_c['favorites'] = $fav_readers['favorites'];
			$vars_c['readers'] = $fav_readers['readers'];
			$vars_c['login'] = $maniac->login;
			$content_tpl = 'index.tpl.php';
		}
		else {
			$content_tpl = 'form_user_login.tpl.php';
		}
		
		$regions = Array('content'=>$view->render($content_tpl, $vars_c));

		$view->build_page($regions);
	}


}