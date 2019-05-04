# EVE Online Intel Tool for WordPress

An easy way to parse D-Scans, fleet compositions and your local, and get all the data you might need.

### Screenshots
#### D-Scan
![](images/d-scan.jpg)

#### Chat Scan (Local for example)
![](images/chat-scan.jpg)

#### Fleet Composition
![](images/fleet-comp-top.jpg)
![](images/fleet-comp-bottom.jpg)

### Hint
This plugin works best with WordPress themes utilizing the Bootstrap Framework. If your Theme doesn't use it, you might end up having to tweak it here and there a bit.
Works best with the [EVE Online WordPress Theme](https://github.com/ppfeufer/eve-online-wordpress-theme)

### Requirements
- WordPress 4.7 or newer
- PHP 7.1 or newer

### Installation
- Simply [download the archive](https://github.com/ppfeufer/eve-online-intel-tool/archive/master.zip) or one of the [releases](https://github.com/ppfeufer/eve-online-intel-tool/releases)
- Unzip it
- Rename the folder to `eve-online-intel-tool` (This is important, otherwise automatic updates might not work as expected)
- Copy the folder into your plugin directory in your WordPress installation.

### Set Up
- Create a page called "Intel" and set the "EVE Intel" Template to it. You can leave this page empty, whatever you write on it, it won't show up anyways.
- Now go to Settings » Permalinks and click "Save Changes" button to make sure the new links will be generated.

### Troubleshooting:
#### Intel page can't be published with the Intel template selected (latest WordPress)
This is, unfortunately, an issue with WordPress' new editor called "Gutenberg". This one can't handle page templates yet. The workaround is described in issue [#88](https://github.com/ppfeufer/eve-online-intel-tool/issues/88) is, for now, your only chance to get it working.

### Additional Information
- [License](LICENSE)
- [Changelog](CHANGELOG.md)
- [Discord](https://discord.gg/YymuCZa)

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/97ad9ac1b1c84efeacd1f59dfd115c37)](https://www.codacy.com/app/ppfeufer/eve-online-intel-tool?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ppfeufer/eve-online-intel-tool&amp;utm_campaign=Badge_Grade)
