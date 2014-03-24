#!/usr/bin/php
    <?php

    // Wechsel in Verzeichnis der Domain
    chdir($argv[1]);

    // Domainname ist HTTP_HOST. Benötigt für Multisite Installationen
    $_SERVER['HTTP_HOST'] = $argv[2];

    // Zentraler include wichtiger Files - erst ab neueren Versionen vorhanden
    if (file_exists('./wp-load.php')) {
        require_once('./wp-load.php');
    } else {
        // Version zu alt, keine wp-load.php vorhanden
        echo "Version zu alt. Unverzueglich Update durchfuehren!";
        exit(8);
    }

    // Variablen
    global $wp_version;
    $core_updates = 0;
    $plugin_updates = 0;
    $theme_updates = 0;

    wp_version_check();
    wp_update_plugins();
    wp_update_themes();

    //Funktionsnamen haben sich bei v2.9 geändert, daher Abfrage.
    if ($wp_version > 2.9){
        $core = get_site_transient('update_core');
        $plugins = get_site_transient('update_plugins');
        $themes = get_site_transient('update_themes');
    }else{
        $core = get_transient('update_core');
        $plugins = get_transient('update_plugins');
        $themes = get_transient('update_themes');
    }

    //Core Updates verfügbar?
    if (isset ( $core->updates) && is_array( $core->updates)){
        foreach($core->updates as $update) {
            if($update->current != $wp_version) {
            $core_new = $update->current;
                $core_updates = 1;
            }
        }
    }

    //Plugin Updates verfügbar?
    if (isset ( $plugins->response ) && is_array( $plugins->response ) ) {
        foreach($plugins->response as $plgupd) {
            $plugin_updates = 1;
        }
    }

    //Theme Updates verfügbar?
    if ( isset ( $themes->response ) && is_array( $themes->response ) ) {
        foreach($themes->response as $theupd) {
            $theme_updates = 1;
        }
    }

    if(!$core_updates && !$plugin_updates && !$theme_updates) {
        echo "OK - WordPress is up to date";
        exit (0);
    }elseif (!$core_updates && !$plugin_updates && $theme_updates) {
        echo "WARNING - Theme Updates required";
        exit(1);
    }elseif (!$core_updates && $plugin_updates && !$theme_updates) {
        echo "WARNING - Plugin Updates required";
        exit(1);
    }elseif (!$core_updates && $plugin_updates && $theme_updates) {
        echo "WARNING - Plugin and Theme Updates required";
        exit(1);
    }elseif ($core_updates && !$plugin_updates && !$theme_updates) {
        echo "WARNING - Core Updates required";
        exit(1);
    }elseif ($core_updates && !$plugin_updates && $theme_updates) {
        echo "WARNING - Core and Theme Updates required";
        exit(1);
    }elseif ($core_updates && $plugin_updates && !$theme_updates) {
        echo "WARNING - Core and Plugin Updates required";
        exit(1);
    }else {
        echo "CRITICAL - Core, Plugin and Theme Updates required";
        exit(2);
    }
    echo "CRITICAL - Unknown error";
    exit(2);

