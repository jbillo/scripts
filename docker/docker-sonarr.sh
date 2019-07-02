docker run \
    -d \
    --name sonarr \
    -p 8989:8989 \
    -e PUID=1000 -e PGID=1000 \
    -e TZ="America/Toronto" \
    -v /etc/localtime:/etc/localtime:ro \
    -v /mnt/ssd/config/sonarr:/config \
    -v /mnt/drobo5n:/mnt/drobo5n \
    -v /mnt/5n2:/mnt/5n2 \
    -v /mnt/drobos:/mnt/drobos \
    -v /mnt/seagate8tb:/mnt/seagate8tb \
    -v /mnt/5n2/Downloads/Complete:/downloads \
    --restart unless-stopped \
    linuxserver/sonarr
