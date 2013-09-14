<?php
class View {

	public function render($tpl, $vars=Array(), $regions=Array()) {
		extract($vars);
		unset($vars);
		
		ob_start();
		
		include( TEMPLATE_DIR . '/' . $tpl);

		return ob_get_clean();
	}

	public function build_page($regions = Array()) {
		$maniac = Maniac::getInstance();
		$vars = Array();
		if ( $maniac->error ) {
			$vars_c = Array();
			$vars_c['error'] = $maniac->error;
			$regions['content'] = $this->render('error.tpl.php', $vars_c);
		}

		$result = $this->render('main.tpl.php', $vars, $regions);
		$maniac->setBody($result);
	}

}