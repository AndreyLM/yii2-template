<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 12/22/17
 * Time: 11:25 AM
 */

namespace domain\services;

use domain\exceptions\DomainException;

interface IConfigService
{
    const HEADER_MENU = 'Header menu';
    const FRONT_MENU = 'Frontend main-page menu';

    public function getAll();

    public function getOne($title);

    /* @param $settings array Setting[]
     * @throws DomainException
     * @return bool
     */
    public function save(array $settings);
}