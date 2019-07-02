docker run \
    -d \
    --name nzbget \
    -p 6789:6789 \
    -e PUID=1000 -e PGID=1000 \
    -e TZ="America/Toronto" \
    -v /mnt/ssd/config/nzbget:/config \
    -v /scratch/nzbget/downloads:/scratch/nzbget/downloads \
    -v /mnt/5n2:/mnt/5n2 \
    -v /mnt/drobo5n:/mnt/drobo5n \
    -v /mnt/seagate8tb:/mnt/seagate8tb \
    --restart unless-stopped \
    linuxserver/nzbget
