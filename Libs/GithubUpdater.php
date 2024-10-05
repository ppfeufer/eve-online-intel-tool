<?php

namespace WordPress\Plugins\EveOnlineIntelTool\Libs;

use stdClass;
use WP_Error;
use const WordPress\Plugins\EveOnlineIntelTool\WP_GITHUB_FORCE_UPDATE;

/**
 * @version 1.6
 * @author Joachim Kudish <info@jkudish.com>
 * @link http://jkudish.com
 * @package WP_GitHub_Updater
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @copyright Copyright (c) 2011-2013, Joachim Kudish
 *
 * GNU General Public License, Free Software Foundation
 * <http://creativecommons.org/licenses/GPL/2.0/>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */
class GithubUpdater {
    /**
     * GitHub Updater version
     */
    public const VERSION = 1.6;

    /**
     * @var array $config the config for the updater
     * @access public
     */
    public array $config;

    /**
     * @var array $missingConfig any config that is missing from the initialization of this instance
     * @access public
     */
    public array $missingConfig;

    /**
     * @var mixed|null $githubData temporarily store the data fetched from GitHub, allows us to only load the data once per class instance
     * @access private
     */
    private mixed $githubData;

    /**
     * Class Constructor
     *
     * @param array $config the configuration required for the updater to work
     * @return void
     * @see $this->hasMinimumConfig()
     * @since 1.0
     */
    public function __construct(array $config = []) {
        $defaults = [
            'slug' => plugin_basename(__FILE__),
            'proper_folder_name' => dirname(
                path: plugin_basename(file: __FILE__),
                levels: 2
            ),
            'sslverify' => true,
            'access_token' => '',
        ];

        $this->config = wp_parse_args($config, $defaults);

        // if the minimum config isn't set, issue a warning and bail
        if (!$this->hasMinimumConfig()) {
            $message = __(
                'The GitHub Updater was initialized without the minimum required configuration, please check the config in your plugin. The following params are missing: ',
                'eve-online-killboard-widget'
            );
            $message .= implode(separator: ',', array: $this->missingConfig);

            _doing_it_wrong(
                function_name: __CLASS__,
                message: $message,
                version: self::VERSION
            );

            return;
        }

        $this->setDefaults();
        $this->init();
    }

    /**
     * Check if the minimum configuration is given
     *
     * @return boolean
     */
    public function hasMinimumConfig(): bool {
        $this->missingConfig = [];

        $requiredParams = [
            'api_url',
            'raw_url',
            'github_url',
            'zip_url',
            'requires',
            'tested',
            'readme',
        ];

        foreach ($requiredParams as $requiredParameter) {
            if (empty($this->config[$requiredParameter])) {
                $this->missingConfig[] = $requiredParameter;
            }
        }

        return (empty($this->missingConfig));
    }

    /**
     * Set defaults
     *
     * @return void
     * @since 1.2
     */
    public function setDefaults(): void {
        if (!empty($this->config['access_token'])) {
            // See Downloading a zipball (private repo) https://help.github.com/articles/downloading-files-from-the-command-line
            $parsedUrl = parse_url(url: $this->config['zip_url']); // $scheme, $host, $path

            $zipUrl = $parsedUrl['scheme'] . '://api.github.com/repos' . $parsedUrl['path'];
            $zipUrl = add_query_arg(
                ['access_token' => $this->config['access_token']],
                $zipUrl
            );

            $this->config['zip_url'] = $zipUrl;
        }

        if (!isset($this->config['new_version'])) {
            $this->config['new_version'] = $this->getNewVersion();
        }

        if (!isset($this->config['last_updated'])) {
            $this->config['last_updated'] = $this->getDate();
        }

        if (!isset($this->config['description'])) {
            $this->config['description'] = $this->getDescription();
        }

        $pluginData = $this->getPluginData();
        if (!isset($this->config['plugin_name'])) {
            $this->config['plugin_name'] = $pluginData['Name'];
        }

        if (!isset($this->config['version'])) {
            $this->config['version'] = $pluginData['Version'];
        }

        if (!isset($this->config['author'])) {
            $this->config['author'] = $pluginData['Author'];
        }

        if (!isset($this->config['homepage'])) {
            $this->config['homepage'] = $pluginData['PluginURI'];
        }

        if (!isset($this->config['readme'])) {
            $this->config['readme'] = 'README.md';
        }
    }

    /**
     * Get the new version from GitHub
     *
     * @return float|false|int|string $version the version number
     * @since 1.0
     */
    public function getNewVersion(): float|false|int|string {
        $version = get_site_transient(
            transient: md5(string: $this->config['slug']) . '_new_version'
        );

        if ((!isset($version) || !$version) || $this->overruleTransients()) {
            $rawResponse = $this->remoteGet(
                query: trailingslashit(
                    $this->config['raw_url']
                ) . basename(path: $this->config['slug'])
            );

            if (is_array(value: $rawResponse) && !empty($rawResponse['body'])) {
                preg_match(
                    pattern: '/.*Version:\s*(.*)$/mi',
                    subject: $rawResponse['body'],
                    matches: $matches
                );
            }

            $version = false;
            if (!empty($matches[1])) {
                $version = $matches[1];
            }

            /**
             * back compat for older readme version handling
             * only done when there is no version found in file name
             */
            if ($version === false) {
                $rawResponse = $this->remoteGet(
                    query: trailingslashit(
                        $this->config['raw_url']
                    ) . $this->config['readme']
                );

                if (is_wp_error($rawResponse)) {
                    return false;
                }

                preg_match(
                    pattern: '#^\s*`*~Current Version:\s*([^~]*)~#im',
                    subject: $rawResponse['body'],
                    matches: $__version
                );

                if (isset($__version[1])) {
                    $version_readme = $__version[1];

                    if (version_compare(version1: false, version2: $version_readme) === -1) {
                        $version = $version_readme;
                    }
                }
            }

            // refresh every 6 hours
            if ($version !== false) {
                set_site_transient(
                    transient: md5(string: $this->config['slug']) . '_new_version',
                    value: $version,
                    expiration: 60 * 60 * 6
                );
            }
        }

        return $version;
    }

    /**
     * Check wether or not the transients need to be overruled and API needs to be called for every single page load
     *
     * @return bool overrule or not
     */
    public function overruleTransients(): bool {
        return (defined(constant_name: '\WordPress\Plugins\EveOnlineIntelTool\WP_GITHUB_FORCE_UPDATE') && WP_GITHUB_FORCE_UPDATE);
    }

    /**
     * Interact with GitHub
     *
     * @param string $query
     *
     * @return array|\WP_Error
     * @since 1.6
     */
    public function remoteGet(string $query): array|WP_Error {
        if (!empty($this->config['access_token'])) {
            $query = add_query_arg(
                ['access_token' => $this->config['access_token']],
                $query
            );
        }

        return wp_remote_get(url: $query, args: [
            'sslverify' => $this->config['sslverify']
        ]);
    }

    /**
     * Get update date
     *
     * @return string|bool $date the date
     * @since 1.0
     */
    public function getDate(): bool|string {
        $githubData = $this->getGithubData();

        return (!empty($githubData->updated_at))
            ? date(
                format: 'Y-m-d',
                timestamp: strtotime(datetime: $githubData->updated_at)
            )
            : false;
    }

    /**
     * Get GitHub Data from the specified repository
     *
     * @return bool|stdClass|null $github_data the data or false
     * @since 1.0
     */
    public function getGithubData(): bool|stdClass|null {
        $githubData = null;

        if (!empty($this->githubData)) {
            $githubData = $this->githubData;
        }

        if ($githubData === null) {
            $githubData = get_site_transient(
                transient: md5(string: $this->config['slug']) . '_github_data'
            );

            if ((!isset($githubData) || !$githubData) || $this->overruleTransients()) {
                $githubRemoteData = $this->remoteGet(query: $this->config['api_url']);

                if (is_wp_error(thing: $githubRemoteData)) {
                    return false;
                }

                $githubData = json_decode(json: $githubRemoteData['body']);

                // refresh every 6 hours
                set_site_transient(
                    transient: md5(string: $this->config['slug']) . '_github_data',
                    value: $githubData,
                    expiration: 60 * 60 * 6
                );
            }

            // Store the data in this class instance for future calls
            $this->githubData = $githubData;
        }

        return $githubData;
    }

    /**
     * Get plugin description
     *
     * @return string|bool $description the description
     * @since 1.0
     */
    public function getDescription(): bool|string {
        $githubData = $this->getGithubData();

        return (!empty($githubData->description)) ? $githubData->description : false;
    }

    /**
     * Get Plugin data
     *
     * @return array $data the data
     * @since 1.0
     */
    public function getPluginData(): array {
        include_once ABSPATH . '/wp-admin/includes/plugin.php';

        return get_plugin_data(plugin_file: WP_PLUGIN_DIR . '/' . $this->config['slug']);
    }

    /**
     * Fire all WordPress actions
     */
    public function init(): void {
        add_filter(
            hook_name: 'pre_set_site_transient_update_plugins',
            callback: [$this, 'apiCheck']
        );

        // Hook into the plugin details screen
        add_filter(
            hook_name: 'plugins_api',
            callback: [$this, 'getPluginInfo'],
            accepted_args: 3
        );
        add_filter(
            hook_name: 'upgrader_post_install',
            callback: [$this, 'upgraderPostInstall'],
            accepted_args: 3
        );

        // set timeout
        add_filter(
            hook_name: 'http_request_timeout',
            callback: [$this, 'httpRequestTimeout']
        );

        // set sslverify for zip download
        add_filter(
            hook_name: 'http_request_args',
            callback: [$this, 'httpRequestSslVerify'],
            accepted_args: 2
        );
    }

    /**
     * Callback fn for the http_request_timeout filter
     *
     * @return int timeout value
     * @since 1.0
     */
    public function httpRequestTimeout(): int {
        return 2;
    }

    /**
     * Callback fn for the http_request_args filter
     *
     * @param array $args
     * @param string $url
     *
     * @return array
     */
    public function httpRequestSslVerify(array $args, string $url): array {
        if ($this->config['zip_url'] === $url) {
            $args['sslverify'] = $this->config['sslverify'];
        }

        return $args;
    }

    /**
     * Hook into the plugin update check and connect to GitHub
     *
     * @param object $transient the plugin data transient
     * @return object $transient updated plugin data transient
     * @since 1.0
     */
    public function apiCheck(object $transient): object {
        /**
         * Check if the transient contains the 'checked' information
         * If not, just return its value without hacking it
         */
        if (empty($transient->checked)) {
            return $transient;
        }

        // check the version and decide if it's new
        $update = version_compare(
            version1: $this->config['new_version'],
            version2: $this->config['version']
        );

        if ($update === 1) {
            $response = new stdClass;
            $response->new_version = $this->config['new_version'];
            $response->slug = $this->config['proper_folder_name'];
            $response->url = add_query_arg(
                ['access_token' => $this->config['access_token']],
                $this->config['github_url']
            );
            $response->package = $this->config['zip_url'];

            $transient->response[$this->config['slug']] = $response;
        }

        return $transient;
    }

    /**
     * Get Plugin info
     *
     * @param bool $false always false
     * @param string $action the API function being performed
     * @param object $response
     * @return object|bool
     * @since 1.0
     */
    public function getPluginInfo(bool $false, string $action, object $response): object|bool {
        // Check if this call API is for the right plugin
        if (!isset($response->slug) || $response->slug !== $this->config['slug']) {
            return false;
        }

        /**
         * These are not used, but propagated by Wordress
         */
        unset($false, $action);

        $response->slug = $this->config['slug'];
        $response->plugin_name = $this->config['plugin_name'];
        $response->version = $this->config['new_version'];
        $response->author = $this->config['author'];
        $response->homepage = $this->config['homepage'];
        $response->requires = $this->config['requires'];
        $response->tested = $this->config['tested'];
        $response->downloaded = 0;
        $response->last_updated = $this->config['last_updated'];
        $response->sections = ['description' => $this->config['description']];
        $response->download_link = $this->config['zip_url'];

        return $response;
    }

    /**
     * Upgrader/Updater
     * Move & activate the plugin, echo the update message
     *
     * @param boolean $true always true
     * @param mixed $hookExtra not used
     * @param array $result the result of the move
     * @return array $result the result of the move
     * @since 1.0
     */
    public function upgraderPostInstall(
        bool $true,
        mixed $hookExtra,
        array $result
    ): array {
        global $wp_filesystem;

        /**
         * These are not used, but propagated by Wordress
         */
        unset($true, $hookExtra);

        // Move & Activate
        $proper_destination = WP_PLUGIN_DIR . '/' . $this->config['proper_folder_name'];
        $wp_filesystem->move($result['destination'], $proper_destination);
        $result['destination'] = $proper_destination;
        $activate = activate_plugin(plugin: WP_PLUGIN_DIR . '/' . $this->config['slug']);

        // Output the update message
        $fail = __(
            'The plugin has been updated, but could not be reactivated. Please reactivate it manually.',
            'eve-online-intel-tool'
        );
        $success = __('Plugin reactivated successfully.', 'eve-online-intel-tool');

        echo is_wp_error(thing: $activate) ? $fail : $success;

        return $result;
    }
}
