<?php

namespace Saeghe\Saeghe\Commands\Add;

use function Saeghe\Cli\IO\Read\argument;

function run()
{
    global $packagesDirectory;
    global $configPath;
    global $config;

    $package = argument('package');
    $version = argument('version');

    $packageMeta = add($packagesDirectory, $package, $version);

    $config['packages'][$package] = $packageMeta['version'];

    json_put($configPath, $config);
}

function add($packagesDirectory, $package, $version)
{
    global $metaFilePath;

    $owner = git_owner($package);
    $repo = git_repo($package);

    if ($version !== 'development' && git_has_release($owner, $repo)) {
        $version = $version ?: git_latest_version($owner, $repo);
        $hash = git_download($packagesDirectory, $owner, $repo, $version);
    } else {
        $version = 'development';
        $hash = git_clone($packagesDirectory, $owner, $repo);
    }

    $meta = json_to_array($metaFilePath);
    $meta['packages'][$package] = compact('owner', 'repo', 'version', 'hash');
    json_put($metaFilePath, $meta);

    $packagePath = $packagesDirectory . "/$owner/$repo/";
    $packageConfigPath = $packagePath . DEFAULT_CONFIG_FILENAME;

    if (file_exists($packageConfigPath)) {
        $packageConfig = json_to_array($packageConfigPath, ['packages' => []]);
        foreach ($packageConfig['packages'] as $subPackage => $subPackageVersion) {
            add($packagesDirectory, $subPackage, $subPackageVersion);
        }
    }

    return compact('owner', 'repo', 'version', 'hash');
}
