docker run \
    -d \
    --name=plexrequests \
    -v /etc/localtime:/etc/localtime:ro \
    -v /mnt/ssd/config/plexrequests:/config \
    -e PGID=1000 -e PUID=1000  \
    -e URL_BASE=/ \
    -p 3000:3000 \
    --restart unless-stopped \
    linuxserver/plexrequests
