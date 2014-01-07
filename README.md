# Rich Snippets Ratings für modified eCommerce Shopsoftware
Dieses Modul ermöglicht die Einbindung der Bewertungssterne eines externen Dienstleisters im eigenen modified Shop.

## Unterstützte Dienste
- Trusted Shops
- eKomi
- Händlerbund

## Installation
Alle Zeilenangaben basieren auf einem nicht modifizierten Shop in der Version 1.06.

Alle Dateien an die entsprechend Stelle im Shop kopieren.

includes/modules/default.php, unterhalb der vorhandenen require-Anweisungen einfügen (Zeile 39):
	require_once (DIR_WS_MODULES."rating/rating.php");

lang/german/lang_german.conf, im Block [index] einfügen (Zeile 433):
	text_rated_with = 'ist mit'
	text_out_of = 'von'
	text_stars_based_on = 'Sternen basierend auf'
	text_opinions = 'Meinungen bewertet'

lang/english/lang_english.conf, im Block [index] einfügen (Zeile 440):
	text_rated_with = 'is rated with'
	text_out_of = 'out of'
	text_stars_based_on = 'stars based on'
	text_opinions = 'opinions'

templates/xtc4/module/main_content.html, am Ende einfügen:
	{if $RATING_MAX}
	<p class="textCenter clearBoth" itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
		<a target="_blank" href="{$RATING_URL}">
			<span itemprop="itemreviewed">{$smarty.const.STORE_NAME}</span> {#text_rated_with#} <span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating"><span itemprop="average">{$RATING_AVERAGE}</span> {#text_out_of#} <span itemprop="best">{$RATING_MAX}</span></span> {#text_stars_based_on#} <span itemprop="votes">{$RATING_AMOUNT}</span> {#text_opinions#}.
		</a>
	</p>
	{/if}

## Konfiguration

Die Konfiguration findet sich in includes/modules/rating/rating-config.php. Alle Konfigurationsvariablen sind kommentiert. 

