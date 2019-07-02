docker run \
  -d \
  --name=ombi \
  -v /mnt/ssd/config/ombi:/config \
  -e PGID=1000 -e PUID=1000  \
  -e TZ="America/Toronto" \
  -p 3579:3579 \
  --restart unless-stopped \
  linuxserver/ombi
