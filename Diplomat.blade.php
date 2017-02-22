@servers(['web' => ['127.0.0.1']])

@task('foo', ['on' => 'web'])
block="This is some text,
    whose indentation should not
    be modified by diplomat.
"

cat > "/home/sanuj/Projects/diplomat/examples/temp.out" << EOF
${block}
EOF

@endtask
