<?php
/**
 * Welcher Bewertungsdienst soll eingebunden werden?
 * Unterstützte Dienste:
 * - TrustedShops
 * - eKomi
 * - Haendlerbund
 **/
$sService = 'ekomi';

/**
 * ID des Bewertungsprofils, das ausgelesen werden soll
 **/
$sServiceID = '44975';

/**
 * URL zur Bewertungsseite, nur bei eKomi nötig
 **/
$sServiceUrl = 'https://www.ekomi.de/bewertungen-alternatede.html';