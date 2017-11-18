docker run \
    --name nzbget \
    -p 6789:6789 \
    -e PUID=1000 -e PGID=1000 \
    -e TZ="America/Toronto" \
    -v /mnt/ssd/config/nzbget:/config \
    -v /scratch/nzbget/downloads:/downloads \
    --restart unless-stopped \
    linuxserver/nzbget
