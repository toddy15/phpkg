<?php

namespace Tests\System\UpdateCommand\UpdateWhenGithubTokenIsSetTest;

use PhpRepos\FileManager\JsonFile;
use function Phpkg\Providers\GitHub\github_token;
use function PhpRepos\FileManager\Resolver\root;
use function PhpRepos\TestRunner\Assertions\Boolean\assert_true;
use function PhpRepos\TestRunner\Runner\test;
use function Tests\Helper\reset_empty_project;
use const Phpkg\Providers\GitHub\GITHUB_DOMAIN;


test(
    title: 'it should not show error message if the credential file is not exist and GITHUB_TOKEN is set',
    case: function () {
        $output = shell_exec('php ' . root() . 'phpkg update git@github.com:php-repos/released-package.git --project=TestRequirements/Fixtures/EmptyProject');

        $expected = <<<EOD
\e[39mUpdating package git@github.com:php-repos/released-package.git to latest version...
\e[39mSetting env credential...
\e[39mLoading configs...
\e[39mFinding package in configs...
\e[39mSetting package version...
\e[39mLoading package's config...
\e[39mDeleting package's files...
\e[39mDetecting version hash...
\e[39mDownloading the package with new version...
\e[39mUpdating configs...
\e[39mCommitting new configs...
\e[92mPackage git@github.com:php-repos/released-package.git has been updated.\e[39m

EOD;

        assert_true($expected === $output, 'Output is not correct:' . PHP_EOL . $expected . PHP_EOL . $output);
    },
    before: function () {
        shell_exec('php ' . root() . 'phpkg init --project=TestRequirements/Fixtures/EmptyProject');
        shell_exec('php ' . root() . 'phpkg add git@github.com:php-repos/released-package.git --version=v1.0.1 --project=TestRequirements/Fixtures/EmptyProject');
        $credential = JsonFile\to_array(root() . 'credentials.json');
        github_token($credential[GITHUB_DOMAIN]['token']);
        rename(root() . 'credentials.json', root() . 'credentials.json.back');
    },
    after: function () {
        reset_empty_project();
        rename(root() . 'credentials.json.back', root() . 'credentials.json');
    }
);
