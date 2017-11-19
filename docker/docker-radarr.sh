/usr/bin/docker run \
                              -d \
                              --name=radarr \
                              -v /opt/radarr/config:/config \
                              -v /mnt/drobo5n:/mnt/drobo5n \
                              -v /mnt/5n2:/mnt/5n2 \
                              -e PGID=1000 -e PUID=1000  \
                              -e TZ="America/Toronto" \
                              -p 7878:7878 \
                              --restart unless-stopped \
                              linuxserver/radarr
