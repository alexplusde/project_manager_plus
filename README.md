# Project Manager Plus

Fork des beliebten Forks des Addons `hello` für REDAXO.

Bietet Unterstützung bei der Verwaltung und Überprüfung der eigenen REDAXO-Installationen - fit für REDAXO 5.18++.

## Features

**Client** ist für den Abruf der einzelnen Parameter zuständig.

* Hinterlegen eines API-Keys in den Einstellungen
* Abruf von Parametern der Installation, z.B.
  * Aktuelle PHP-Version
  * Installierte und updatefähige REDAXO-Addons
  * Vorhandene Module
  * Verwendete YRewrite-Domains
  * Letzte Logins
  * Letzte Änderungen im Medienpool
  * Letzte Änderungen in der Struktur
  * Letzte Meldungen aus dem Syslog
  * weiter geplant: Medienpool-Verzeichnisgröße, Backup-Status
  * weiter geplant: EXTENSION_POINT, um eigene Prüfregeln zu hinterlegen

**Server** dient zur Verwaltung der REDAXO Projekte

* Verwaltung der REDAXO-Projekte
* Darstellung der wichtigsten Parameter in der Listenansicht
* Darstellung aller Parameter in der Detailansicht
* Abruf und Überwachung der Parameter von den Clients
* EXTENSION_POINT **project_manager_plus_SERVER_DETAIL_HOOK** zur Einbindung von weiteren Plugins und zur Darstellung in der Detailansicht
* Cronjob zum automatisierten Abruf aller Parameter
* Cronjob zum automatisierten Abruf der Favicons

**PageSpeed** dient zur Anzeige der Google PageSpeedwerte

* Abrufen der Desktop und Mobile PageSpeed Werte
* Darstellung der Werte in der Listenansicht
* Darstellung aller Parameter in der Detailansicht im **Server**
* Cronjob zum automatisierten Abruf der Werte

**Hosting** dient zur Anzeige von Hosting Informationen

* Abrufen von ISP, Organisation sowie die aktuelle IP Adresse über den IP-API.com Dienst
* Darstellung der Werte in der Listenansicht
* Darstellung aller Parameter in der Detailansicht im **Server**
* Cronjob zum automatisierten Abruf der Werte

## Installation

Voraussetzung für die aktuelle Version des Projekt Manager Addons: REDAXO 5.3, Cronjob-Addon, MarkItUp-Addon
Nach erfolgreicher Installation gibt es im Backend unter AddOns einen Eintrag "Projekt Manager".

## Server

Unter dem Reiter **Übersicht** werden REDAXO-Installationen verwaltet.

Es wird eine Übersicht der wichtigsten Parameter in der Listenansicht dargestellt.
Neue Projekte können angelegt und vorhandene Projekte geändert werden.

Die einzelnen Felder sind:

* Name des Projektes
* Website (Domain aus dem System oder Domain des YRewrite-Projekts, z.B. `domain.de`)
* SSL Verschlüsselung
* API-Key
* REDAXO Hauptversion (Wird für den entsprechenden Aufruf zum Client benötigt)

### Editiermodus

Im **Editiermodus** lässt sich das ausgewählte Projekt verwalten.

### Details

Unter Details kann das Projekt gewählt werden und alle relevanten Inhalte zum Projekt angezeigt werden.

### Sync-Cronjob

Um die Daten von den REDAXO Clients in den Projekt Manager zu laden, gibt es zwei Cronjobs welche im Cronjob Addon mit der Installation angelegt werden.

* Projekt Manager: Hole Domaindaten
* Projekt Manager: Hole Favicon

## Client

Unter dem Reiter **Client** wird der API Key für die REDAXO Instanz verwaltet.

Die einzelnen Felder sind:

* API-Key

Dieser wird beim Projekt anlegen im Server-Plugin erzeugt und kann hier ein eingetragen werden.

### Einstellungen

Unter dem Reiter **Einstellungen** lässt sich ein API-Key hinterlegen. Bei der Installation des Plugins wird automatisch ein API-Key voreingestellt. Anschließend lassen sich die Parameter über die URL abrufen:

```plaintext
http://www.domain.de/?rex-api-call=project_manager_plus&api_key=<api_key>
```

### REDAXO 4

REDAXO 4 wird nicht mehr unterstützt.

## PageSpeed

Unter dem Reiter **Einstellungen** wird der Google PageSpeed API Key verwaltet.

Die einzelnen Felder sind:

* API-Key

### Installation

Nach der Installation des Plugins muss in den Einstellungen der API-Key eingerichtet werden.

### Einstellungen

Unter dem Reiter **Einstellungen** lässt sich ein API-Key hinterlegen. Bei der Installation des Plugins wird automatisch ein API-Key voreingestellt. Anschließend lassen sich die Parameter über die URL abrufen:

### PageSpeed-Cronjob

Um die Daten von den REDAXO Projekten in den Projekt Manager zu laden, gibt es einen Cronjobs welcher im Cronjob Addon mit der Installation angelegt werden.

* Projekt Manager: PageSpeed Daten

## Hosting

Das Hosting-Plugin holt ISP, Organisation sowie die aktuelle IP Adresse über den IP-API.com Dienst. Achtung! Es exisitert eine Limitierung von 150 Calls/Minute, daher wurde ein Timing verbaut.

### Installation

Nach der Installation des Plugins sollte der Cronjob einmal ausgeführt werden.

### Hosting-Cronjob

Um die Hostingdaten von den REDAXO Projekten in den Projekt Manager zu laden, gibt es einen Cronjobs welcher im Cronjob Addon mit der Installation angelegt werden.

* Projekt Manager: Hosting Daten

## Weiteres

### Bug-Meldungen, Hilfe und Links

* Auf Github: <https://github.com/alexplusde/project_manager_plus/issues>

### Lizenz

siehe [LICENSE](https://github.com/alexplusde/project_manager_plus/blob/main/LICENSE)

### Autor

**Projekt-Lead**

* [Alexander Walther](https://github.com/alexplusde)

### Credits

**Friends Of REDAXO**

* <http://www.redaxo.org>
* <https://github.com/FriendsOfREDAXO>

**Ursprüngliches Entwickler-Team**

* [Ronny Kemmereit](https://github.com/rkemmere)
* [Pascal Schuchmann](https://github.com/pschuchmann)
* [Alexander Walther](https://github.com/alexplusde)  
