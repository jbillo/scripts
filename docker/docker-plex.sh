docker run \
-d \
--restart unless-stopped \
--name plex \
--network=host \
-e TZ="America/Toronto" \
-e PLEX_CLAIM="CLAIM-IIHETL7WFHSHEJTPJ1CL" \
-v /mnt/ssd/config/plex:/config \
-v /mnt/ssd/transcode:/transcode \
-v /mnt/drobo5n:/mnt/drobo5n \
-v /mnt/5n2:/mnt/5n2 \
-v /mnt/drobos:/mnt/drobos \
-v /mnt/seagate8tb:/mnt/seagate8tb \
plexinc/pms-docker
