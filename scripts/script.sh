#!/usr/bin/env bash

block="This is some text,
    whose indentation should not
    be modified by dimplomat.
"

cat > "/home/sanuj/Projects/diplomat/scripts/temp.out" << EOF
${block}
EOF
