#!/usr/local/bin/python3

# Given a directory of files, seek in one level only. Determine those that have a close-but-not-quite ISO date prefix
# (eg: 20190615 rather than 2019-06-15) and rename them appropriately.
import argparse
import logging
import os
import re


class FileRenamer(object):
    def __init__(self, subject_dir):
        self.subject_dir = subject_dir
        logging.basicConfig(level=logging.DEBUG)

    def rename(self, dry_run=False):
        logging.debug(f"Going to rename files with 8-digit prefix in {self.subject_dir}")
        for candidate in os.scandir(self.subject_dir):
            if not candidate.is_file() or not re.match(r'\d{8}_', candidate.name):
                logging.debug(f"Did not match {candidate.name}")
                continue

            logging.info(f"Matched {candidate.name}")
            # date format: first 4 characters, dash, next 2 characters, dash, next 2 characters, underscore, the rest
            # 20190615_Document.pdf --> 2019-06-15_Document.pdf
            new_file_name = f"{candidate.name[0:4]}-{candidate.name[4:6]}-{candidate.name[6:8]}_{candidate.name[9:]}"
            logging.debug(f"Renaming to {new_file_name}")

            if not dry_run:
                os.rename(candidate, os.path.join(self.subject_dir, new_file_name))


def _main():
    parser = argparse.ArgumentParser()
    parser.add_argument('subject_dir', help='Directory to rename files in')
    parser.add_argument('--dry-run', action='store_true', default=False, help="Don't actually rename files")

    args = parser.parse_args()

    FileRenamer(args.subject_dir).rename(dry_run=args.dry_run)


if __name__ == '__main__':
    _main()