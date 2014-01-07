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
<pre>
	require_once (DIR_WS_MODULES."rating/rating.php");
</pre>

lang/german/lang_german.conf, im Block [index] einfügen (Zeile 433):
<pre>
	text_rated_with = 'ist mit'
	text_out_of = 'von'
	text_stars_based_on = 'Sternen basierend auf'
	text_opinions = 'Meinungen bewertet'
</pre>

lang/english/lang_english.conf, im Block [index] einfügen (Zeile 440):
<pre>
	text_rated_with = 'is rated with'
	text_out_of = 'out of'
	text_stars_based_on = 'stars based on'
	text_opinions = 'opinions'
</pre>

templates/xtc5/module/main_content.html, am Ende einfügen:
<pre>
	{if $RATING_MAX}
	&lt;p class="textCenter clearBoth" itemscope itemtype="http://data-vocabulary.org/Review-aggregate"&gt;
		&lt;a target="_blank" href="{$RATING_URL}"&gt;
			&lt;span itemprop="itemreviewed"&gt;{$smarty.const.STORE_NAME}&lt;/span&gt; {#text_rated_with#} &lt;span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating"&gt;&lt;span itemprop="average"&gt;{$RATING_AVERAGE}&lt;/span&gt; {#text_out_of#} &lt;span itemprop="best"&gt;{$RATING_MAX}&lt;/span&gt;&lt;/span&gt; {#text_stars_based_on#} &lt;span itemprop="votes"&gt;{$RATING_AMOUNT}&lt;/span&gt; {#text_opinions#}.
		&lt;/a&gt;
	&lt;/p&gt;
	{/if}
</pre>
## Konfiguration

Die Konfiguration findet sich in includes/modules/rating/rating-config.php. Alle Konfigurationsvariablen sind kommentiert. 

