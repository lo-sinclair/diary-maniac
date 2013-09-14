<?php
abstract class Page {


	public function __construct(){

    }


	public function ajaxAction() {
		$maniac = Maniac::getInstance();
		$params = $maniac->getParams();

		if (!empty($params['flags'])) {
			$act = $params['flags'][0].'Content';
			$output = $this->$act();
		}
		else {
			$output = false;
		}
			
		echo $output;
	}


   public function Paginator($current, $count, $nums_count, $url) {
	   if($nums_count % 2 == 0)
	     $nums_count++;

	    $output = "";

	    $pages = Array();
	 	
	    if ($count <= $nums_count) {
			$start = 1;
			$end = $count;
	    }
    	elseif($current<$nums_count ) {
    		$start = 1;
    		$end = $nums_count;	
    	}
    	elseif($current>$count-$nums_count){
			$start = ($count-$nums_count)+1;
			$end = $count;	
    	}
    	else {
    		$start = $current - floor($nums_count/2);
    		$end = $current + floor($nums_count/2);
    	}

		for ($i=$start; $i <= $end; $i++) {
			$href = $this->addQueryURL($url, "page=$i");
		    $pages[$i] = $this->l($i, $this->addQueryURL($url, "page=$i"));
		}
		$pages[$current] = $current;

		//первая-последняя
		if ($start > floor($nums_count/2) ) {
			array_unshift( $pages, $this->l('...', $this->addQueryURL($url, "page=".($start-1))) );
			array_unshift( $pages, $this->l('1', $this->addQueryURL($url, "page=1")) );
		}
		if ($end < $count -  floor($nums_count/2)) {
			array_push( $pages, $this->l('...', $this->addQueryURL($url, "page=".($end+1))) );
			array_push( $pages, $this->l($count, $this->addQueryURL($url, "page=$count")) );
		}
		//вперед-назад
		if ($current > 1) {
			array_unshift( $pages, $this->l('<<', $this->addQueryURL($url, "page=".($current-1))) );
		}
		if ($current < $count) {
			array_push( $pages, $this->l('>>', $this->addQueryURL($url, "page=".($current+1))) );
		}
	
	    $output = implode(' ', $pages);
	   
	    return $output;
	}


	public function addQueryURL($url, $q_str) {
		$parse_url = parse_url($url);
		if(isset($parse_url['query'])) {
			$parse_url['query'] .= '&'.$q_str;
		}
		else 
			$parse_url['query'] = $q_str;

		return $parse_url['path'].'?'.$parse_url['query'];
	}



	public function l($text, $href) {
		return "<a href=\"$href\">$text</a>";
	}


}