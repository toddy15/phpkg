<?php

namespace Tests\FileManager\Directory\MakeRecursiveTest;

use Saeghe\Saeghe\FileManager\Address;
use Saeghe\Saeghe\FileManager\Directory;

test(
    title: 'it should create directory recursively',
    case: function () {
        $directory = Address::from_string(root() . 'Tests/PlayGround/Origin/MakeRecursive');

        assert_true(Directory\make_recursive($directory->to_string()));
        assert_true(Directory\exists($directory->parent()->to_string()));
        assert_true(Directory\exists($directory->to_string()));

        return $directory;
    },
    after: function (Address $directory) {
        Directory\delete_recursive($directory->parent()->to_string());
    }
);

test(
    title: 'it should create directory recursively with given permission',
    case: function () {
        $directory = Address::from_string(root() . 'Tests/PlayGround/Origin/MakeRecursive');

        assert_true(Directory\make_recursive($directory->to_string(), 0777));
        assert_true(Directory\exists($directory->parent()->to_string()));
        assert_true(0777 === Directory\permission($directory->parent()->to_string()));
        assert_true(Directory\exists($directory->to_string()));
        assert_true(0777 === Directory\permission($directory->to_string()));

        return $directory;
    },
    after: function (Address $directory) {
        Directory\delete_recursive($directory->parent()->to_string());
    }
);
