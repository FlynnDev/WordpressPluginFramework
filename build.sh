#!/bin/bash

if [[ `git status --porcelain -uno | grep -i "MM"` ]]; then

    versiony package.json --patch
    grunt

    else
    echo "No Changes"

fi;
 
git add .