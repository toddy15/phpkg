<?php

namespace Tests\System\HelpCommandTest;

$helpContent = <<<'EOD'
usage: saeghe [-v | --version] [-h | --help] [--man]
           <command> [<args>]

These are common Saeghe commands used in various situations:

start a working area
    init                Initialize an empty project or reinitialize an existing one
    migrate             Migrate from a composer project

work with packages
    credential          Add credential for given provider 
    add                 Add a git repository as a package
    remove              Remove a git repository from packages
    update              Update the version of given package
    install             Installs package dependencies
    
work on an existing project
    build               Build the project
    watch               Watch file changes and build the project for each change
    flush               Flush files in build directory
EOD;

test(
    title: 'it should show help output',
    case: function () use ($helpContent) {
        $output = shell_exec($_SERVER['PWD'] . '/saeghe -h');

        assert(str_contains($output, $helpContent), 'Help output is not what we want!' . $output);
    }
);

test(
    title: 'it should show help output when help option passed',
    case: function () use ($helpContent) {
        $output = shell_exec($_SERVER['PWD'] . '/saeghe --help');

        assert(str_contains($output, $helpContent), 'Help output is not what we want!' . $output);
    }
);

test(
    title: 'it should show help output when no command passed',
    case: function () use ($helpContent) {
        $output = shell_exec($_SERVER['PWD'] . '/saeghe');

        assert(str_contains($output, $helpContent), 'Help output is not what we want!' . $output);
    }
);