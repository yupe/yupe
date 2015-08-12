#!/usr/bin/env bash

init() {
    chmod a+rw ./public/assets ./public/uploads ./protected/runtime
    chmod a+rw ./protected/config/modules ./protected/config/modulesBack
    cp ./protected/config/db.back.php ./protected/config/db.php
    chmod a+rw ./protected/config/db.php
}

clean() {
    rm -R protected/runtime/cache/*
    rm -R protected/runtime/CSS/*
    rm -R protected/runtime/HTML/*
    rm -R protected/runtime/debug/*
    rm -R protected/runtime/URI/*
    rm -R protected/runtime/application.log*

    rm -R public/assets/*
    rm -R protected/config/modules/*
}

showHelp() {
    echo "supported commands:"
    echo "init - proxy to init php"
    echo "clean - proxy to remove project runtime files"
}

case "$1" in
-h|--help)
    showHelp
    ;;
*)
    if [ ! -z $(type -t $1 | grep function) ]; then
        $1 $2
    else
        showHelp
    fi
    ;;
esac