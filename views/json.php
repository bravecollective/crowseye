<?	
	require_once('classes/Wormhole.php');
	require_once('classes/IGB.php');
	function jsonWormholes () {
		$IGB=IGB::getInstance();
		if ($_SERVER['REQUEST_METHOD'] == "GET") {
    		
    		if (!isset($_COOKIE['pwd'])) {
      			echo("{}");
      			return;
      		}
    	
    		if ($_COOKIE['pwd'] != $GLOBALS['homePassword']) {
    		  echo("{}");
    		  return;
    		}

			$whs = Wormhole::getObjects();
			echo(json_encode($whs));
		} else if ($_SERVER['REQUEST_METHOD'] == "POST") {
			if (!$IGB->trusted) return;
			$wh = new Wormhole(-1, $_POST['systemName'], $_POST['wormholeName'], array(IGB::getInstance()->charID,IGB::getInstance()->charName,IGB::getInstance()->corpID), time(), Wormhole::parseScan($_POST['sites']), "", $_POST['sig']);
			$whid = $wh->save();
			if ($whid != -1) {
				if ($_POST['comment'] != "") {
					Wormhole::addComment(IGB::getInstance()->charID, $whid, $_POST['comment']);
				}
			}
			echo($whid);
		}

	}

	function jsonInformation($args) {
		$holes = explode(",",$args[1]);
		$after = 0;
		if (isset ($_POST['after'])) $after = $_POST['after'];
		//file_put_contens("log.error", $args[1], FILE_APPEND);
		$result = array(
			"kills" => jsonKills($holes, $after),
			"comments" => jsonGetComments($holes, $after),
			"sites" => jsonGetSites($holes, $after),
			"igbheaders" => $IGB=IGB::getInstance()
		);

		echo( json_encode( $result ) ) ;
	}

	function jsonUpdateSites ($args) {
		$hole = $args[1];
		if ($_SERVER['REQUEST_METHOD'] == "POST") {
			$sites = Wormhole::parseScan($_POST['sites']);
			Wormhole::saveSites($hole, $sites);
		}
	}

	function jsonDelete ($args) {
		if ($_POST['pw'] === $GLOBALS['directorPassword']) {
			Wormhole::removeHoleById($_POST['id']);
		}
	}




	function jsonKills ($systems, $after) {
		$IGB=IGB::getInstance();
		$kills = array();
		foreach ($systems as $system) {
			$cache_file = 'cache/dotlan/'.$system;
			if(file_exists($cache_file)) {
				$cache = file_get_contents($cache_file);
				$modified = substr($cache, 0, 10);

				if ($modified < $after) continue;

	  			if((time() - $modified) > 900) {
	  				$result = Database::filterBy("holes", ' rowid="'.SQLite3::escapeString($system).'"');
	  				$name = $result[0]['name'];
	    	 		$dotlan = @file_get_contents('http://evemaps.dotlan.net/system/'.$name);
	    	 		file_put_contents($cache_file, time().$dotlan);
	  			} else {
	  				$dotlan = $cache;
	  			}
			} else {
	  			$result = Database::filterBy("holes", ' rowid="'.SQLite3::escapeString($system).'"');
	  			$name = $result[0]['name'];
	    	 	$dotlan = @file_get_contents('http://evemaps.dotlan.net/system/'.$name);
	    	 	file_put_contents($cache_file, time().$dotlan);
			}
				
			if ($dotlan) {
	
				$ship_kills = '/<b>Ship Kills<\/b>.*\s*.*t">([0-9]*)<\/.*\s.*t">([0-9]*)</i';
				$npc_kills = '/<b>NPC Kills<\/b>.*\s*.*t">([0-9]*)<\/.*\s.*t">([0-9]*)</i';
				preg_match_all($ship_kills, $dotlan, $shipkills);
				preg_match_all($npc_kills, $dotlan, $npckills);

			} else {
				$shipkills = array("-1","-1","-1");
				$npckills = array("-1","-1","-1");
			}


			$kills[$system]['name'] = $system;
			$kills[$system]['ship'] = array($shipkills[1],$shipkills[2]);
			$kills[$system]['npc']  = array($npckills[1],$npckills[2]);
		}
		return $kills;

	}

	function jsonComments($args) {
		if (!isset($_POST['text'])) return;
		$hole = $args[1];
		$IGB=IGB::getInstance();
		if (!$IGB->trusted) return;
		Wormhole::addComment($IGB->charID, $hole, $_POST['text']);
	}

	function jsonGetComments($systems, $after) {
		$comments = array();
		foreach ($systems as $system) {
			$comment = Wormhole::getComments($system, $after);
			if (count($comment) != 0) $comments[$system] = $comment;
		}
		return $comments;
	}

	function jsonGetSites($systems, $after) {
		$sites = array();
		foreach ($systems as $system) {
			$sites[$system] = Wormhole::getSites($system, $after);
		}
		return $sites;
	}

