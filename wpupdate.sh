#!/usr/bin/env bash
set -e

if [[ $EUID -ne "0" ]]; then
	echo "This utility needs root privileges to modify content in /var/www"
	exit 1
fi

# Update all WordPress sites in /var/www, accounting for special directories

update_site() {
	wpcmd="/usr/bin/wp --allow-root"
	if [ -z $1 ]; then
		echo "No directory specified to upgrade"
		return 1
	fi
	pushd $1 || return 2
	sudo $wpcmd core update && sudo $wpcmd theme update-all && sudo $wpcmd plugin update-all
	popd
	return 0
}


possible_dirs=`find /var/www -mindepth 1 -maxdepth 1 -type d`
for dir in $possible_dirs; do
	if [[ -f "$dir/wp-config.php" ]]; then
		update_site $dir
	elif [[ -f "$dir/blog/wp-config.php" ]]; then
		update_site "$dir/blog"
	else
		echo "$dir does not appear to contain a WP site"
	fi
done

echo "Upgrade process done"


