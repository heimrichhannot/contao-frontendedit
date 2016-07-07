<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_module'];

/**
 * Fields
 */
$arrLang['addEditCol']							= array('Bearbeiten-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Editieren hinzuzufügen.');
$arrLang['jumpToEdit']							= array('Weiterleitungsseite (Bearbeiten)', 'Wählen Sie hier die Seite aus, zu der weitergeleitet wird, wenn die Instanz bearbeitet wird.');
$arrLang['addDeleteCol']						= array('Löschen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Löschen hinzuzufügen.');
$arrLang['addPublishCol']						= array('Veröffentlichen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Veröffentlichen hinzuzufügen.');
$arrLang['addUpdateConditions']  				= array('Bedingungen für das Bearbeiten hinzufügen', 'Wählen Sie hier aus, ob es Bedingungen für das Bearbeiten von Datensätzen geben soll.');
$arrLang['updateConditions']					= array(' ', 'Wählen Sie hier aus, unter welchen Bedingungen das Bearbeiten von Datensätzen möglich sein soll.');
$arrLang['allowDelete']							= array('Löschen erlauben', 'Wählen Sie hier aus, ob es durch Angabe des Paramaters act="delete" möglich sein soll, Datensätze zu löschen.');
$arrLang['addDeleteConditions']					= array('Bedingungen für das Löschen hinzufügen', 'Wählen Sie hier aus, ob es Bedingungen für das Löschen von Datensätzen geben soll.');
$arrLang['deleteConditions']					= array(' ', 'Wählen Sie hier aus, unter welchen Bedingungen das Löschen von Datensätzen möglich sein soll.');
$arrLang['setPageTitle']						= array('Instanzfeld als Seitentitel setzen', 'Wählen Sie diese Option, wenn nach dem Anlegen einer Instanz ein Feld als Seitentitel gesetzt werden soll (bspw. der Titel).');
$arrLang['addClientsideValidation']				= array('Clientseitige Validierung hinzufügen (erfordert jquery-validation)', 'Wählen Sie diese Option, wenn das Formular auch clientseitig validiert werden soll.');
$arrLang['pageTitleField']						= array('Seitentitelfeld', 'Wählen Sie das Feld aus aus, dass dem Seitentitel zugewiesen werden soll.');
$arrLang['noIdBehavior']						= array('Verhalten beim Fehlen eines ID-Parameters', 'Wählen Sie hier das Verhalten des Moduls aus, wenn keine Instanz übergeben wurde (kein GET-Parameter "id", keine Heringabe durch das Modul, ...).');
$arrLang['noIdBehavior']['create']				= 'Neue Instanz erstellen';
$arrLang['noIdBehavior']['create_until']		= 'Neue Instanz erstellen, sofern es noch keine gibt';
$arrLang['noIdBehavior']['redirect']			= 'Zu bestehender Instanz umleiten';
$arrLang['noIdBehavior']['error']				= 'Fehlermeldung ausgeben (kein Erzeugen erlauben)';
$arrLang['redirectId']							= array('Bestehende Instanz-ID', 'Geben Sie hier die ID der Instanz aus, zu der weitergeleitet werden soll, wenn kein ID-Parameter verfügbar ist.');
$arrLang['addCreateButton']						= array('"Neu"-Button hinzufügen', 'Wählen Sie diese Option, um einen Button zum Erstellen von neuen Instanzen einzufügen.');
$arrLang['jumpToCreate']						= array('Weiterleitungsseite (Neu)', 'Wählen Sie hier die Seite aus, zu der weitergeleitet wird, wenn eine neue Instanz erstellt wird.');
$arrLang['createButtonLabel']					= array('Beschriftung des "Neu"-Buttons', 'Überschreiben Sie hier hier die standardmäßige Beschriftung des "Neu"-Buttons.');
$arrLang['createMemberGroups']					= array('"Neu"-Button schützen', 'Legen Sie hier Mitgliedergruppen fest, die Voraussetzung dafür sind, dass der Button angezeigt wird.');
$arrLang['defaultArchive']						= array('Standardarchiv', 'Wählen Sie hier das Archiv aus, das neuen Instanzen zugeordnet werden soll.');
$arrLang['addDeleteCol']						= array('Löschen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Löschen hinzuzufügen.');
$arrLang['jumpToSuccess']						= array('Weiterleitung nach dem Speichern', 'Wählen Sie hier eine Seite aus, zu der nach dem erfolgreichen Speichern weitergeleitet werden soll.');
$arrLang['jumpToSuccessPreserveParams']			= array('Parameter beibehalten', 'Wählen Sie diese Option, wenn die Weiterleitungsseite (nach dem Speichern) wieder ein Frontendedit-Leser-Modul enthält. Dadurch werden die aktuelle Action sowie die ID beibehalten.');
$arrLang['deleteNotification']					= array('Benachrichtigung nach dem Löschen verschicken', 'Wählen Sie hier eine Nachricht aus, die nach dem Löschen von Datensätzen verschickt werden soll.');

/**
 * Legends
 */
$arrLang['security_legend']						= 'Sicherheit';
$arrLang['action_legend']						= 'Actionhandling';