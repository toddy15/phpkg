<?php

namespace Tests\FlushCommandTest;

test(
    title: 'it should flush builds',
    case: function () {
        $output = shell_exec($_SERVER['PWD'] . '/saeghe --command=flush --project=TestRequirements/Fixtures/ProjectWithTests');

        assert_development_build_is_empty('Development build directory is not empty.' . $output);
        assert_production_build_is_empty('Production build directory is not empty.' . $output);
    },
    before: function () {
        shell_exec($_SERVER['PWD'] . '/saeghe --command=build --project=TestRequirements/Fixtures/ProjectWithTests');
        shell_exec($_SERVER['PWD'] . '/saeghe --command=build --project=TestRequirements/Fixtures/ProjectWithTests --environment=production');
    },
    after: function () {
        shell_exec('rm -fR ' . $_SERVER['PWD'] . '/TestRequirements/Fixtures/ProjectWithTests/builds');
    }
);

function assert_development_build_is_empty($message)
{
    assert(['.', '..'] === scandir($_SERVER['PWD'] . '/TestRequirements/Fixtures/ProjectWithTests/builds/development'), $message);
}

function assert_production_build_is_empty($message)
{
    assert(['.', '..'] === scandir($_SERVER['PWD'] . '/TestRequirements/Fixtures/ProjectWithTests/builds/production'), $message);
}