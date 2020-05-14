#!/usr/bin/env python3

# pipe output of `find . -name '*.mkv' -path '*S04E*'` to this script
# when already in 'TV' directory

import fileinput
import os

for line in fileinput.input():
    pathparts = line.rstrip().split('/', 2)
    if len(pathparts) != 3:
        print("Unexpected path parts: {}".format(pathparts))
        continue

    if pathparts[0] != '.':
        print("{} did not have current directory prefix".format(pathparts))
        continue

    extension = os.path.splitext(pathparts[2])[1]
    curfile = os.path.join(pathparts[1], pathparts[2])
    newfile = '{dir}{extension}'.format(dir=pathparts[1], extension=extension)
    print(
        "Renaming {} to {}".format(curfile, newfile)
    )
    os.rename(curfile, newfile)

print("Done")
