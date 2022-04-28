#!/bin/bash
if [ -z ${1} ]; then
  echo "Need version param";
  exit 1;
else
  ver=$1;
fi

docker build -t autocrud-cms:$ver .
docker tag autocrud-cms:$ver autocrud-cms:latest
docker image prune --filter label=stage=builder --force

