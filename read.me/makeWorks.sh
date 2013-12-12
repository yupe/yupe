#!/bin/bash

cd ..
chmod a+rw ./{public/assets,public/uploads,protected/runtime}
chmod a+rw ./protected/config/module{s,sBack}
cp ./protected/config/db.back.php ./protected/config/db.php
chmod a+rw ./protected/config/db.php
