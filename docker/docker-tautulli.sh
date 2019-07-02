docker run \
  -d \
  --name=tautulli \
  -v /mnt/ssd/config/plexpy:/config \
  -v "/mnt/ssd/config/plex/Library/Application Support/Plex Media Server/Logs":/logs:ro \
  -e PGID=1000 -e PUID=1000  \
  -e TZ="America/Toronto" \
  -p 8181:8181 \
  --restart unless-stopped \
  linuxserver/tautulli
