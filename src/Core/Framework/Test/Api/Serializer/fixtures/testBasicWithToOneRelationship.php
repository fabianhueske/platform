<?php declare(strict_types=1);

use Shopware\Core\Content\Media\MediaEntity;
use Shopware\Core\System\User\UserEntity;

$userId = '6f51622e-b381-4c75-ae02-63cece27ce72';

$user = new UserEntity();
$user->setId($userId);
$user->setName('Manufacturer');
$user->setPassword('password');
$user->setUsername('user1');
$user->setActive(true);
$user->setEmail('user1@shop.de');
$user->setFailedLogins(0);
$user->setLastLogin(date_create_from_format(\DateTime::ATOM, '2018-01-15T08:01:16+00:00'));
$user->setCreatedAt(date_create_from_format(\DateTime::ATOM, '2018-01-15T08:01:16+00:00'));

$media = new MediaEntity();
$media->setId('548faa1f-7846-436c-8594-4f4aea792d96');
$media->setUserId($userId);
$media->setMimeType('image/jpg');
$media->setFileExtension('jpg');
$media->setFileSize(93889);
$media->setTitle('2');
$media->setCreatedAt(date_create_from_format(\DateTime::ATOM, '2012-08-31T00:00:00+00:00'));
$media->setUpdatedAt(date_create_from_format(\DateTime::ATOM, '2017-11-21T11:25:34+00:00'));
$media->setUser($user);

return $media;
