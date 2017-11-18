docker run \
-d \
--restart unless-stopped \
--name plex \
--network=host \
-e TZ="America/Toronto" \
-e PLEX_CLAIM="plex.tv/claim" \
-v /mnt/ssd/config/plex:/config \
-v /mnt/ssd/transcode:/transcode \
-v /mnt/drobo5n:/mnt/drobo5n \
-v /mnt/5n2:/mnt/5n2 \
plexinc/pms-docker

