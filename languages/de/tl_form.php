<?php

/**
 * Fields
 */

$GLOBALS['TL_LANG']['tl_form']['addVoting'] = array('Voting hinzufügen', 'Wählen Sie die Option, wenn Sie es sich bei diesem Formular um ein Voting-Formular handelt.');
$GLOBALS['TL_LANG']['tl_form']['maxVoteCount'] = array('Maximale Anzahl an Votes', 'Bitte geben Sie hier an, wie viele Votes unter Angabe derselben E-Mail-Adresse möglich sein sollen. 0 bedeutet eine unbegrenzte Anzahl an Votes pro E-Mail-Adresse.');
$GLOBALS['TL_LANG']['tl_form']['jumpTo_activation'] = array('Weiterleitungsseite (Aktivierung)', 'Bitte wählen Sie hier die Seite aus, die durch einen Klick auf den Aktivierungslink in der Bestätigungsmail aufgerufen werden soll.');
$GLOBALS['TL_LANG']['tl_form']['formFieldToken'] = array('Token-Formularfeld', 'Bitte wählen Sie hier das Formularfeld aus, in dem das Token für die Aktivierung des Votes gespeichert werden soll. Der Inhalt kann dann in der Aktivierungs-E-Mail durch den Inserttag {{form::&lt;name&gt;}} eingefügt werden.');
$GLOBALS['TL_LANG']['tl_form']['formFieldTokenLink'] = array('Token-Link-Formularfeld', 'Bitte wählen Sie hier das Formularfeld aus, in dem der Token-Link für die Aktivierung des Votes gespeichert werden soll. Der Inhalt kann dann in der Aktivierungs-E-Mail durch den Inserttag {{form::&lt;name&gt;}} eingefügt werden.');
$GLOBALS['TL_LANG']['tl_form']['formFieldActivated'] = array('Aktiviert-Formularfeld', 'Bitte wählen Sie hier das Formularfeld aus, in dem der Status des Votings (aktiviert oder nicht aktiviert) gespeichert werden soll.');
$GLOBALS['TL_LANG']['tl_form']['formFieldNewsletter'] = array('Newsletter-Formularfeld', 'Bitte wählen Sie hier das Formularfeld aus, welches dem Benutzer ermöglichen soll, einen Newsletter zu abonnieren. WICHTIG: Dieses Feld muss ein Checkbox-Menü sein, welches den Wert "yes" setzt, sofern es angeklickt wurde.');
$GLOBALS['TL_LANG']['tl_form']['newsletters'] = array('Newsletterkanäle', 'Bitte wählen Sie hier die Newsletter aus, die der Benutzer abonniert, wenn das "Newsletter-Formularfeld" angeklickt wurde.');
$GLOBALS['TL_LANG']['tl_form']['newsletterSubscribeMailText'] = array('Abonnementbestätigung', 'Sie können die Platzhalter &lt;em&gt;##channels##&lt;/em&gt; (Name der Verteiler), &lt;em&gt;##domain##&lt;/em&gt; (Domainname) und &lt;em&gt;##link##&lt;/em&gt; (Aktivierungslink) verwenden.');
$GLOBALS['TL_LANG']['tl_form']['newsletterSubscribeJumpTo'] = array('Bestätigungsseite (Newsletter)', 'Wählen Sie hier die Bestätigungsseite aus, die nach dem Klick auf den Bestätigungslink aufgerufen werden soll.');