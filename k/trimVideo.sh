#!/bin/bash
ffmpeg -i "$1" -ss $2 -t $3 -c:v libx264 "$4"
