<?php
if(strstr($_SERVER['PHP_SELF'], 'index') && empty($_GET['cPath']) && empty($_GET['manufacturers_id'])) {
	require_once("rating-config.php");
	require_once(DIR_FS_INC."xtc_output_warning.inc.php");
	$bUrlFopen = ini_get('allow_url_fopen');
	if($bUrlFopen!=true) {
		xtc_output_warning('<em>allow_url_fopen</em> ist nicht aktiv. Dieses Modul funktioniert nur mit aktiviertem <em>allow_url_fopen.</em>');
	}
	if(!empty($sService) && $bUrlFopen==true) {
		$sService = strtolower($sService);
		$bCreate = checkRatingCache($sService);

		if(!$bCreate) {
			switch($sService) {
				case "trustedshops":
					$oXML = simplexml_load_file("https://www.trustedshops.com/bewertung/show_xml.php?tsid=".$sServiceID);
					$aData['max'] = 5;
					foreach($oXML->ratings->result as $oResult) {
						if($oResult['name'][0]=='average') {
							$aData['average'] = (float)$oResult;
							break;
						}
					}
					$aData['amount'] = (int)$oXML->ratings['amount'];
					$aData['url'] = "https://www.trustedshops.com/bewertung/seite/info_".$sServiceID.".html";
				break;
				case "haendlerbund":
					require_once(DIR_WS_CLASSES."simple_html_dom.php");
					$aData['url'] = "https://www.kaeufersiegel.de/bewertung/shop/".$sServiceID;
					$oHTML = file_get_html($aData['url']);
					$oAverage = $oHTML->find('meta[itemprop=ratingValue]', 0);
					$aData['average'] = (float)$oAverage->content;
					$oMax = $oHTML->find('meta[itemprop=bestrating]', 0);
					$aData['max'] = (int)$oMax->content;
					$oAmount = $oHTML->find('meta[itemprop=ratingcount]', 0);
					$aData['amount'] = (int)$oAmount->content;
				break;
				case "ekomi-legacy":
				require_once(DIR_WS_CLASSES."simple_html_dom.php");
					$aData['url'] = "https://www.ekomi.de/bewertungen-".$sServiceID.".html";
					$oHTML = file_get_html($aData['url']);
					$oAverage = $oHTML->find('.ratingGrade .average', 0);
					$aData['average'] = (float)str_replace("&nbsp;", "", $oAverage->plaintext);
					$oMax = $oHTML->find('.ratingGrade .bestOuter .best', 0);
					$aData['max'] = (int)str_replace("&nbsp;", "", $oMax->plaintext);
					$oAmount = $oHTML->find('.count', 0);
					$aData['amount'] = (int)$oAmount->plaintext;
				break;
				case "ekomi":
					$aData['url'] = $sServiceUrl;
					$sContent = file_get_contents("http://www.ekomi.de/widgets/".$sServiceID."/bewertung.txt");
					$aContent = explode("|", $sContent);
					$aData['max'] = 5;
					$aData['average'] = $aContent[0];
					$aData['amount'] = $aContent[1];
				break;
			}
			file_put_contents(DIR_FS_CATALOG."cache/rating-".$sService.".json", json_encode($aData));
		}
		$oData = json_decode(file_get_contents(DIR_FS_CATALOG."cache/rating-".$sService.".json"));

		$default_smarty->assign('RATING_URL', $oData->url);
		$default_smarty->assign('RATING_MAX', $oData->max);
		$default_smarty->assign('RATING_AVERAGE', $oData->average);
		$default_smarty->assign('RATING_AMOUNT', $oData->amount);
	}
}

function checkRatingCache($sService, $iTimeout=86400) {
	if(!file_exists(DIR_FS_CATALOG."cache/rating-".$sService.".json")) {
		return false;
	}

	$iTimestamp = filemtime(DIR_FS_CATALOG."cache/rating-".$sService.".json");
	if(time() - $iTimestamp < $iTimeout) {
		return true;
	} else {
		return false;
	}
}