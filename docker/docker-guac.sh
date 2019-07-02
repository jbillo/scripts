docker run \
  -d \
  --name=guac \
  -v /mnt/ssd/config/guac:/config \
  -e PGID=1000 -e PUID=1000  \
  -e TZ="America/Toronto" \
  -p 8081:8080 \
  --restart unless-stopped \
  oznu/guacamole
