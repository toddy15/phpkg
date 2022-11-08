<?php

namespace Tests\FileManager\DirectoryAddress\PermissionTest;

use Saeghe\Saeghe\FileManager\DirectoryAddress;

test(
    title: 'it should return directory\'s permission',
    case: function () {
        $playGround = DirectoryAddress::from_string(root() . 'Tests/PlayGround');
        $regular = $playGround->subdirectory('regular');
        $regular->make(0774);
        assert_true(0774 === $regular->permission());

        $full = $playGround->subdirectory('full');
        $full->make(0777);
        assert_true(0777 === $full->permission());

        return [$regular, $full];
    },
    after: function (DirectoryAddress $regular, DirectoryAddress $full) {
        $regular->delete();
        $full->delete();
    }
);

test(
    title: 'it should not return cached permission',
    case: function () {
        $playGround = DirectoryAddress::from_string(root() . 'Tests/PlayGround');
        $directory = $playGround->subdirectory('regular');
        $directory->make(0775);
        assert_true(0775 === $directory->permission());
        chmod($directory->to_string(), 0774);
        assert_true(0774 === $directory->permission());

        return $directory;
    },
    after: function (DirectoryAddress $directory) {
        $directory->delete();
    }
);
