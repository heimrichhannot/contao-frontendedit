<?php


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['hideFilter']							= array('Filter verstecken', 'Klicken Sie hier, um den Filter zu verstecken.');
$GLOBALS['TL_LANG']['tl_module']['showItemCount']						= array('Ergebnisanzahl anzeigen', 'Klicken Sie hier, um die Anzahl der gefundenen Objekte anzuzeigen.');
$GLOBALS['TL_LANG']['tl_module']['addEditCol']							= array('Bearbeiten-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Editieren hinzuzufügen.');
$GLOBALS['TL_LANG']['tl_module']['jumpToEdit']							= array('Weiterleitungsseite (Bearbeiten)', 'Wählen Sie hier die Seite aus, zu der weitergeleitet wird, wenn die Instanz bearbeitet wird.');
$GLOBALS['TL_LANG']['tl_module']['addDeleteCol']						= array('Löschen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Löschen hinzuzufügen.');
$GLOBALS['TL_LANG']['tl_module']['addPublishCol']						= array('Veröffentlichen-Spalte hinzufügen', 'Klicken Sie hier, um jeder Zeile einen Button zum Veröffentlichen hinzuzufügen.');
$GLOBALS['TL_LANG']['tl_module']['instanceSorting']						= array('Initiale Sortierung', 'Wählen Sie hier eine initiale Sortierung aus.');
$GLOBALS['TL_LANG']['tl_module']['instanceSorting']['asc']				= ' (aufsteigend)';
$GLOBALS['TL_LANG']['tl_module']['instanceSorting']['desc']				= ' (absteigend)';
$GLOBALS['TL_LANG']['tl_module']['instanceSorting']['random']			= 'Zufällige Reihenfolge';
$GLOBALS['TL_LANG']['tl_module']['addUpdateDeleteConditions']  			= array('Bedingungen für das Bearbeiten & Löschen hinzufügen', 'Wählen Sie hier aus, ob es Bedingungen für das Bearbeiten und Löschen von Datensätzen geben soll.');
$GLOBALS['TL_LANG']['tl_module']['updateDeleteConditions']  			= array(' ', 'Wählen Sie hier aus, unter welchen Bedingungen das Bearbeiten und Löschen von Datensätzen möglich sein soll.');
$GLOBALS['TL_LANG']['tl_module']['addUpdateConditions']  				= array('Bedingungen für das Bearbeiten hinzufügen', 'Wählen Sie hier aus, ob es Bedingungen für das Bearbeiten von Datensätzen geben soll.');
$GLOBALS['TL_LANG']['tl_module']['updateConditions']  					= array(' ', 'Wählen Sie hier aus, unter welchen Bedingungen das Bearbeiten von Datensätzen möglich sein soll.');
$GLOBALS['TL_LANG']['tl_module']['formHybridAddDefaultFilterValues']	= array('Initiale Filter hinzufügen', 'Wählen Sie diese Option, um initiale Filter für das Modul hinzuzufügen.');
$GLOBALS['TL_LANG']['tl_module']['formHybridDefaultFilterValues']		= array(' ', 'Definieren Sie hier initiale Filter für das Modul.');
$GLOBALS['TL_LANG']['tl_module']['addCustomFilterFields']				= array('Alternative Felder zur Filterung verwenden', 'Wählen Sie diese Option, wenn die Filterfelder von den zuvor definierten Feldern abweichen.');
$GLOBALS['TL_LANG']['tl_module']['customFilterFields']					= array('Alternative Felder zur Filterung', 'Wählen Sie hier Ihre alternativen Filterfelder.');
$GLOBALS['TL_LANG']['tl_module']['setPageTitle']						= array('Instanzfeld als Seitentitel setzen', 'Wählen Sie diese Option, wenn nach dem Anlegen einer Instanz ein Feld als Seitentitel gesetzt werden soll (bspw. der Titel).');
$GLOBALS['TL_LANG']['tl_module']['pageTitleField']						= array('Seitentitelfeld', 'Wählen Sie das Feld aus aus, dass dem Seitentitel zugewiesen werden soll.');
$GLOBALS['TL_LANG']['tl_module']['additionalSql']						= array('Zusätzliches SQL', 'Geben Sie hier SQL ein, welches nach dem SELECT-Statement eingefügt wird (bspw. INNER JOIN tl_tag ON tl_calendar_events.id = tl_tag.tid).');
$GLOBALS['TL_LANG']['tl_module']['hideUnpublishedInstances']			= array('Unveröffentlichte Instanzen verstecken', 'Wählen Sie diese Option, um unveröffentlichte Instanzen zu verstecken.');
$GLOBALS['TL_LANG']['tl_module']['emptyText']							= array('Meldung bei leerer Ergebnismenge', 'Geben Sie hier die Meldung ein, die erscheinen soll, wenn keine Ergebnisse gefunden wurden (mit ##<Feldname>## können Filtereingaben eingefügt werden).');
$GLOBALS['TL_LANG']['tl_module']['createBehavior']						= array('Verhalten beim Erstellen neuer Instanzen', 'Wählen Sie hier das Verhalten des Moduls aus, wenn eine neue Instanz erstellt wird.');
$GLOBALS['TL_LANG']['tl_module']['createBehavior']['create']			= 'Neue Instanz erstellen';
$GLOBALS['TL_LANG']['tl_module']['createBehavior']['create_until']		= 'Neue Instanz erstellen, sofern es noch keine gibt';
$GLOBALS['TL_LANG']['tl_module']['createBehavior']['redirect']			= 'Zu bestehender Instanz umleiten';
$GLOBALS['TL_LANG']['tl_module']['redirectId']							= array('Bestehende Instanz', 'Wählen Sie die Instanz zu der weitergeleitet werden soll, wenn kein ID-Parameter verfügbar ist..');
$GLOBALS['TL_LANG']['tl_module']['existingConditions']					= array('Bedingungen für das Auffinden bestehender Instanzen', 'Geben Sie hier Bedingungen ein, die für das Auffinden bestehender Instanzen gelten müssen.');
$GLOBALS['TL_LANG']['tl_module']['addCreateButton']						= array('"Neu"-Button hinzufügen', 'Wählen Sie diese Option, um einen Button zum Erstellen von neuen Instanzen einzufügen.');
$GLOBALS['TL_LANG']['tl_module']['jumpToCreate']						= array('Weiterleitungsseite (Neu)', 'Wählen Sie hier die Seite aus, zu der weitergeleitet wird, wenn eine neue Instanz erstellt wird.');
$GLOBALS['TL_LANG']['tl_module']['createButtonLabel']					= array('Beschriftung des "Neu"-Buttons', 'Überschreiben Sie hier hier die standardmäßige Beschriftung des "Neu"-Buttons.');
$GLOBALS['TL_LANG']['tl_module']['defaultArchive']						= array('Standardarchiv', 'Wählen Sie hier das Archiv aus, das neuen Instanzen zugeordnet werden soll.');

// events
$GLOBALS['TL_LANG']['tl_module']['filterArchives']						= array('Archive', 'Wählen Sie hier die Archive aus, deren Elemente in der Liste sichtbar sein sollen.');

// members
$GLOBALS['TL_LANG']['tl_module']['filterGroups']						= array('Mitgliedergruppen', 'Wählen Sie hier die Mitgliedergruppen aus, deren Mitglieder in der Liste sichtbar sein sollen.');