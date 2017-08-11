<?php

$arrLang = &$GLOBALS['TL_LANG']['tl_module'];

/**
 * Fields
 */
$arrLang['addEditCol']                   = ['Bearbeiten-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Editieren hinzuzufügen.'];
$arrLang['jumpToEdit']                   = ['Weiterleitungsseite (Bearbeiten)', 'Wählen Sie hier die Seite aus, zu der weitergeleitet wird, wenn die Instanz bearbeitet wird.'];
$arrLang['addDeleteCol']                 = ['Löschen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Löschen hinzuzufügen.'];
$arrLang['addPublishCol']                = ['Veröffentlichen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Veröffentlichen hinzuzufügen.'];
$arrLang['addUpdateConditions']          = ['Bedingungen für das Bearbeiten hinzufügen', 'Wählen Sie hier aus, ob es Bedingungen für das Bearbeiten von Datensätzen geben soll.'];
$arrLang['updateConditions']             = [' ', 'Wählen Sie hier aus, unter welchen Bedingungen das Bearbeiten von Datensätzen möglich sein soll.'];
$arrLang['allowDelete']                  = ['Löschen erlauben', 'Wählen Sie hier aus, ob es durch Angabe des Paramaters act="delete" möglich sein soll, Datensätze zu löschen.'];
$arrLang['jumpToAfterDelete']            = ['Weiterleitung nach dem Löschen', 'Wählen Sie hier eine Seite aus, zu der nach dem erfolgreichen Löschen weitergeleitet werden soll.'];
$arrLang['addDeleteConditions']          = ['Bedingungen für das Löschen hinzufügen', 'Wählen Sie hier aus, ob es Bedingungen für das Löschen von Datensätzen geben soll.'];
$arrLang['deleteConditions']             = [' ', 'Wählen Sie hier aus, unter welchen Bedingungen das Löschen von Datensätzen möglich sein soll.'];
$arrLang['setPageTitle']                 = ['Instanzfeld als Seitentitel setzen', 'Wählen Sie diese Option, wenn nach dem Anlegen einer Instanz ein Feld als Seitentitel gesetzt werden soll (bspw. der Titel).'];
$arrLang['addClientsideValidation']      = ['Clientseitige Validierung hinzufügen (erfordert jquery-validation)', 'Wählen Sie diese Option, wenn das Formular auch clientseitig validiert werden soll.'];
$arrLang['pageTitleField']               = ['Seitentitelfeld', 'Wählen Sie das Feld aus aus, dass dem Seitentitel zugewiesen werden soll.'];
$arrLang['noIdBehavior']                 = ['Verhalten beim Fehlen eines ID-Parameters', 'Wählen Sie hier das Verhalten des Moduls aus, wenn keine Instanz übergeben wurde (kein GET-Parameter "id", keine Heringabe durch das Modul, ...).'];
$arrLang['noIdBehavior']['create']       = 'Neue Instanz erstellen';
$arrLang['noIdBehavior']['create_until'] = 'Neue Instanz erstellen, sofern es noch keine gibt';
$arrLang['noIdBehavior']['redirect']     = 'Zu bestehender Instanz umleiten';
$arrLang['noIdBehavior']['error']        = 'Fehlermeldung ausgeben (kein Erzeugen erlauben)';
$arrLang['redirectId']                   = ['Bestehende Instanz-ID', 'Geben Sie hier die ID der Instanz aus, zu der weitergeleitet werden soll, wenn kein ID-Parameter verfügbar ist.'];
$arrLang['addCreateButton']              = ['"Neu"-Button hinzufügen', 'Wählen Sie diese Option, um einen Button zum Erstellen von neuen Instanzen einzufügen.'];
$arrLang['jumpToCreate']                 = ['Weiterleitungsseite (Neu)', 'Wählen Sie hier die Seite aus, zu der weitergeleitet wird, wenn eine neue Instanz erstellt wird.'];
$arrLang['createButtonLabel']            = ['Beschriftung des "Neu"-Buttons', 'Überschreiben Sie hier hier die standardmäßige Beschriftung des "Neu"-Buttons.'];
$arrLang['createMemberGroups']           = ['"Neu"-Button schützen', 'Legen Sie hier Mitgliedergruppen fest, die Voraussetzung dafür sind, dass der Button angezeigt wird.'];
$arrLang['defaultArchive']               = ['Standardarchiv', 'Wählen Sie hier das Archiv aus, das neuen Instanzen zugeordnet werden soll.'];
$arrLang['addDeleteCol']                 = ['Löschen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Löschen hinzuzufügen.'];
$arrLang['deleteNotification']           = ['Benachrichtigung nach dem Löschen verschicken', 'Wählen Sie hier eine Nachricht aus, die nach dem Löschen von Datensätzen verschickt werden soll.'];
$arrLang['disableSessionCheck']          = ['Session-Überprüfung deaktivieren', 'Nicht überprüfen ob die Session ID des aktuellen Nutzers mit der Session ID im Datensatz übereinstimmen. Die Aktivierung wird nicht empfohlen.'];
$arrLang['disableAuthorCheck']           = ['Author-Überprüfung deaktivieren', 'Nicht überprüfen ob die User::ID des aktuellen Nutzers mit der Author ID im Datensatz übereinstimmen. Die Aktivierung wird nicht empfohlen.'];
$arrLang['publishOnValid']               = ['Instanz nach erfolgreicher Validierung veröffentlichen', 'Wählen Sie diese Option, wenn die Instanz nach erfolgreicher Validierung veröffentlicht werden soll.'];

/**
 * Legends
 */
$arrLang['security_legend'] = 'Sicherheit';
$arrLang['action_legend']   = 'Actionhandling';
$arrLang['optin_legend']   = 'Opt-In Handling';