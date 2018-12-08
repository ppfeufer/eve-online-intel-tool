
# Change Log

## [In Development](https://github.com/ppfeufer/eve-online-intel-tool/tree/development)
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.5.0...development)
### Added
- Meta description tag as long as SEO tools don't interfere with it

### Changed
- German translation updated

## [v1.5.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.5.0) - 2018-12-02
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.4.2...v1.5.0)
### Added
- ESI status page
- ESI status short overview on Intel index page as an indicator to see if ESI is about to fall apart and parsing might fail
- More methods to the structure helper to be more granular if needed
- Destination system of an Ansiblex Jump Gate

### Changed
- System detection by Upwell structures when there is only (for what ever reason) an Ansiblex Jump Gate on grid where we can get the system from. Since these structures can have 2 systems in their name (origin » destination) we have to pick the right system here.
- Minimum needed ESI client version to the lastest version of the ESI client
- D-Scan Templates to give the links to dotlan and zkillboard their own line to deal with longer alliance and corp names and to be more in line with the chat scan appearance.

## [v1.4.2](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.4.2) - 2018-11-25
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.4.1...v1.4.2)
### Added
- Run time cache for less database queries

### Changed
- Minimum needed ESI client version to the lastest version of the ESI client

## [v1.4.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.4.1) - 2018-11-17
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.4.0...v1.4.1)
### Added
- New navigational structures (Pharolux Cyno Beacon, Ansiblex Jump Gate and Tenebrex Cyno Jammer) have been added to the list of structures that can have the system name in it, to help detect the system for a D-Scan.

## [v1.4.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.4.0) - 2018-11-01
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.3.1...v1.4.0)
### Added
- New category "Miscellaneous" to "interesting on grid". This category for now only covers probes that are on grid, but there will be more in the future, like drones, fighters and so on.

### Changed
- Simplified on grid detection
- Simplified D-Scan templates

## [v1.3.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.3.1) - 2018-10-08
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.3.0...v1.3.1)
### Changed
- Check if ZipArchive is available to extract the ESI client zip or if we have to use PclZip

## [v1.3.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.3.0) - 2018-10-06
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.2.1...v1.3.0)
### Changed
- Esi client again, so I can use one for all my plugins and don't have to tweak it for every plugin individually
- System information in d-scan are now nice to look at :-)
- Database names to fit in with WordPress' naming convention

### Removed
- Plugin settings as they don't make any sense at all
- Image cache, CCP has a good image CDN, let's use that
- Some older JavaScripts for some lazy loading attempts

### Fixed
- register_widget call made compatible for PHP 7.2 (create_function() is deprecated)

### Additional Info
This update has some major code changes including changes on the database cache tables and the ESI client. If you run into troubles after this update, please try to deactivate and activate this plugin again. If this doesn't help feel free to get in touch with me on my [Discord](https://discord.gg/YymuCZa) or open an [Issue on Github](https://github.com/ppfeufer/eve-online-intel-tool/issues)

## [v1.2.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.2.1) - 2018-10-03
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.2.0...v1.2.1)
### Fixed
- An issue where large chat scans were capped at 1000 results. Now you can also get the full list of Jita local, depending on your server settings :-)

## [v1.2.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.2.0) - 2018-10-01
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.1.1...v1.2.0)
### Changed
- Namespaces to match WordPress's folder structure (Plugin » Plugins)
- ESI client completely refactored
- Cache database refactored

## [v1.1.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.1.1) - 2018-09-14
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.1.0...v1.1.1)
### Fixed
- Activation hook is apparently not being fired on plugin update, so we have to apply a little workaround here. Thanks WordPress for removing that hook ...

## [v1.1.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.1.0) - 2018-09-13
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v1.0.0...v1.1.0)
### Added
- Links to dotlan and zkillboard in d-scan system information header (Issue #59)
- Links to dotlan and zkillboard on all alliance and corporation lists
- Links to evewho and zkillboard on all pilot lists
- Highlight NPC corps (Issue #69)

### Fixed
- Possible bug in system detection

### Removed
- Dashboard Widget as it doesn't hold any useful information, so no need to waste time loading the dashboard

## [v1.0.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v1.0.0) - 2018-07-17
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.7.0...v1.0.0)
### Added
- Versions to ESI calls

### Changed
- Image server URL
- ESI endpoint handling
- Simplified DataTable handling
- Ending test period after more than a year I guess it's stable for its first official release v1.0.0

## [v0.7.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.7.0) - 2018-06-20
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.6.3...v0.7.0)
### Added
- Quick Intel Sidebar Widget (Issue #62)

### Changed
- Replaced /search/ endpoint from local scan with /universe/ids/ endpoint
- Replaced /search/ endpoint from d-scan with /universe/ids/ endpoint
- Replaced /search/ endpoint from fleet scan with /universe/ids/ endpoint

### Removed
- Usage of SearchApi

## [v0.6.3](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.6.3) - 2018-06-18
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.6.2...v0.6.3)
### Added
- Faction Fortizars to structures that can hold the system name

### Changed
- Refactored the D-Scan pareser a little bit

## [v0.6.2](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.6.2) - 2018-05-29
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.6.1...v0.6.2)
### Changed
- Changed ESI URL to the new one

## [v0.6.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.6.1) - 2018-02-07
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.6.0...v0.6.1)
### Changed
- Drastically reduced the ESI Client to what we really need

## [v0.6.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.6.0) - 2017-12-24
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.5.1...v0.6.0)
### Added
- noindex and nofollow to the intel pages header. Google doesn't need to index or follow them.
- Proper ESI Client

### Changed
- D-Scan using ESI Client now
- Fleet Composition Scan using ESI Client now
- Chat Scan using ESI Client now
- Simplified the way to determin if we are on the right post type to make sure our styles and javascript will be loaded properly

### Removed
- A lot of unused variables and functions

## [v0.5.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.5.1) - 2017-11-17
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.5.0...v0.5.1)
### Added
- 30 days as option for image cache

### Removed
- Loot and salvage to D-Scan when on grid (to much to filter, to many stuff in that category ...)

## [v0.5.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.5.0) - 2017-11-17
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.9...v0.5.0)
### Added
- Upwell structures to D-Scan when on grid
- Deployable structures to D-Scan when on grid
- Starbases and modules to D-Scan when on grid
- Loot and salvage to D-Scan when on grid (wrecks and stuff / basically d-scan data Provi style :-P)

### Changed
- Database cache to 6 months instead of 1
- Simplified code to reduce the load on the affiliation endpoint

### Updated
- German translation

## [v0.4.9](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.9) - 2017-11-07
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.8...v0.4.9)
### Added
- Count of unaffiliated pilots (pilots who are not in any alliance) in alliance breakdown for chat scans
- Issue template for GitHub

### Updated
- German translation

## [v0.4.8](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.8) - 2017-11-04
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.7...v0.4.8)
### Fixed
- Region names in D-Scans

### Added
- Dashboard Widget - Cache Statistics
- Database cache for systems, constellations and regions to reduce the number of ESI calls for D-Scans over time

## [v0.4.7](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.7) - 2017-11-01
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.6...v0.4.7)
### Fixed
- Database prefix for multisite installations, we need only one cache database ...

## [v0.4.6](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.6) - 2017-10-31
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.5...v0.4.6)
### Fixed
- ESI :: End points now use their full path instead of adding the rest later ...
- ESI :: Affiliation end point now able to handle large numbers of pilots for chat scans. So even Jita local should be doable now, still might take a half an hour ...

## [v0.4.5](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.5) - 2017-10-24
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.4...v0.4.5)
### Added
- Athanor and Tatara as structures that hold the systems name

### Changed
- Plugin dir base name detection simplified

## [v0.4.4](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.4) - 2017-10-23
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.3...v0.4.4)
### Fixed
- Cached images will be renewed when file size is 0 (broken images)

### Added
- Warning to the image lazy load option to not use it when using a static page cache, can add some very heavy load to your server.

### Removed
- Call for non needed java script
- Unused information from the fleet scan

### Changed
- Templates reworked
- Reintroduced sticky highlight
- Dropped pagination on data tables (use the filter, it's a better way)

### Updated
- German translation

## [v0.4.3](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.3) - 2017-10-17
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.2...v0.4.3)
### Fixed
- Tackled emtpy response from character-affiliation end point / [Issue: #27](https://github.com/ppfeufer/eve-online-intel-tool/issues/27)
- Error while parsing duplicate names
- An issue with the templates that wouldn't load when no intel data is available
- Rewriting the permalinks on activation and deactivation
- Image API end point for ships (To many end points that do the same here ...), and this time we have the right images for T2 ships :-)

### Added
- Optional lazy loading for EVE related images on chat scan pages, when image cache is used

## [v0.4.2](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.2) - 2017-10-09
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.1...v0.4.2)
### Fixed
- Comparing cache time with current time for alliance cache

## [v0.4.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.1) - 2017-10-09
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.4.0...v0.4.1)
### Fixed
- Time for database entries. Using the month as hour doesn't really work great in the long run ...

## [v0.4.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.4.0) - 2017-10-09
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.3.2...v0.4.0)
### Changed
- Now using own database tables to cache entity ID for pilots, corporations, alliances and ship information. This should speed things up quite a bit after some time and drop the amount of API calls needed significantly.

## [v0.3.2](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.3.2) - 2017-10-07
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.3.1...v0.3.2)
### Changed
- Optimized how the data is written into the database
- ESI handling for pilot data (this should speed things a bit up)

## [v0.3.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.3.1) - 2017-10-04
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.3.0...v0.3.1)
### Fixed
- RegEx again to detect fleetcomp and not being a d-scan in some rare cases
- Settings headlines now reflect what the settings actually do

### Changed
- Getting alliance information from character data instead of corp data. It's more reliable since character data has a shorter cache time.
- Deactivated sticky highlight on click, doesn't work with the pagination of our data tables. Need to sort this out first.

### Updated
- German translation

## [v0.3.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.3.0) - 2017-09-25
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.2.2...v0.3.0)
### Added
- Settings for cache (Image and API cache)

## [v0.2.2](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.2.2) - 2017-09-16
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.2.1...v0.2.2)
### Fixed
- Translation stuff fixed, it works now as it is supposed to ...

## [v0.2.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.2.1) - 2017-09-16
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.2.0...v0.2.1)
### Added
- Issue a warning when intel coudn't be parsed

### Changed
- Optimized data handling to reduce duplicate code

### Fixed
- Some spelling mistakes

## [v0.2.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.2.0) - 2017-09-13
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.10...v0.2.0)
### Added
- Security check for the intel form to prevent [Cross-Site Request Forgery](https://en.wikipedia.org/wiki/Cross-site_request_forgery)

## [v0.1.10](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.10) - 2017-09-12
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.9...v0.1.10)
### Added
- German translation

### Changed
- Made data tables translatable (To create your own translation, use the [Loco Translate](https://wordpress.org/plugins/loco-translate/) plugin in your WordPress backend. Feel free to send me your translation files via the GitHub issue tracker so I can add them to the plugin.)

## [v0.1.9](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.9) - 2017-09-08
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.8...v0.1.9)
### Added
- Sticky highlight on click in one of the sortable table fields, another click removes it again

### Changed
- Optimized the JavaScript for highlighting the sortable table fields

## [v0.1.8](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.8) - 2017-09-02
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.7...v0.1.8)
### Added
- Visual association of pilots and corporations to their respective alliance in local and fleet composition scans.

### Changed
- Optimized the JavaSript to highlight table similar data.

## [v0.1.7](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.7) - 2017-09-01
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.6...v0.1.7)
### Added
- Some eyecandy for the sortable tables

### Changed
- Fleet information pushed into its own template

### Fixed
- "Unknown" number of pilots docked or in space in fleet composition scan should be 0 instead

## [v0.1.6](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.6) - 2017-09-01
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.5...v0.1.6)
### Fixed
- Removed duplicate label on some table header

## [v0.1.5](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.5) - 2017-09-01
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.4...v0.1.5)
### Added
- General Fleet information to the fleet scan, as in how many pilots in total, how many are docked, how many are in space.

### Fixed
- Regular Expression for detecting fleet scans. I really hate this stuff ...

## [v0.1.4](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.4) - 2017-08-31
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.3...v0.1.4)
### Fixed
- Undefined index notice
- Better differentiation between d-scan and local scan, so a local scan doesn't trigger the d-scan parsing in some special circumstances

## [v0.1.3](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.3) - 2017-08-30
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.2...v0.1.3)
### Fixed
- Table Header

## [v0.1.2](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.2) - 2017-08-30
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.1...v0.1.2)
### Fixed
- Github Updater ... hopefully ...

## [v0.1.1](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.1) - 2017-08-30
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.1.0...v0.1.1)
### Fixed
- width of dataTable should always be 100% (Firefox is definitely to slow with the JS stuff ...)

## [v0.1.0](https://github.com/ppfeufer/eve-online-intel-tool/releases/tag/v0.1.0) - 2017-08-30
### Changed
- First "unofficial" release, still not considered final or stable or what ever :-)
