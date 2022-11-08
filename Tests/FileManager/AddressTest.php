<?php

namespace Tests\FileManager\AddressTest;

use Saeghe\Saeghe\FileManager\Address;
use Saeghe\Saeghe\FileManager\DirectoryAddress;

test(
    title: 'it should create path from string',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('\user\home/directory     '))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('     \user\home/directory     '))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('\user\home/directory'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('\user\\\\home//directory'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('\user\\\\home//directory/'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('\user\home\../middle-directory\directory'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (new Address('\user\home\.././middle-directory/directory'))->to_string()
        );
    }
);

test(
    title: 'it should create path by calling fromString method',
    case: function () {
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Address::from_string('\user\home/directory')->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Address::from_string('\user\\\\home///directory')->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Address::from_string('\user\\\\home///directory/')->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Address::from_string('\user\home\../middle-directory\directory')->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'middle-directory' . DIRECTORY_SEPARATOR . 'directory'
            ===
            Address::from_string('\user\home\.././middle-directory/directory')->to_string()
        );
    }
);

test(
    title: 'it should append and return a new path instance',
    case: function () {
        $path = Address::from_string('/user/home');
        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            $path->append('directory')->to_string()
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home'
            ===
            $path->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (Address::from_string('/user/home')->append('\directory'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            (Address::from_string('/user/home')->append('\directory\\'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            (Address::from_string('\user/home')->append('directory\filename.extension'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            (Address::from_string('\user/home')->append('directory\filename.extension/'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            (Address::from_string('\user////home')->append('directory\\\\filename.extension'))->to_string()
        );

        assert_true(
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            (Address::from_string('\user/home/..\./')->append('./another-directory/../directory\\\\filename.extension'))->to_string()
        );
    }
);

test(
    title: 'it should return new instance of parent directory for the given path',
    case: function () {
        $path = Address::from_string('/user/home/directory/filename.extension');

        assert_true(
            $path->parent() instanceof DirectoryAddress
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory'
            ===
            $path->parent()->to_string()
            &&
            DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR . 'directory' . DIRECTORY_SEPARATOR . 'filename.extension'
            ===
            $path->to_string()
        );
    }
);

test(
    title: 'it should check if the given file exists',
    case: function () {
        assert_true(Address::from_string(__FILE__)->exists());
        assert_false(Address::from_string(__FILE__)->append('not_exists.txt')->exists());

        assert_true(Address::from_string(__DIR__)->exists());
        assert_false(Address::from_string(__DIR__)->append('not_exists')->exists());
    }
);

test(
    title: 'it should detect the leaf',
    case: function () {
        assert_true(Address::from_string('/')->to_string() === Address::from_string('/')->leaf());
        assert_true('AddressTest.php' === Address::from_string(__FILE__)->leaf());
        assert_true('FileManager' === Address::from_string(__DIR__)->leaf());
    }
);
