
# Change Log

## [In Development](https://github.com/ppfeufer/eve-online-intel-tool/tree/development)
[Full Changelog](https://github.com/ppfeufer/eve-online-intel-tool/compare/v0.5.1...development)
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
