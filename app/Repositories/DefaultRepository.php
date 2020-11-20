<?php
/**
 * Created by PhpStorm.
 * User: irinash
 * Date: 17/11/2020
 * Time: 18:21
 */

namespace Alice\Repositories;


class DefaultRepository extends Repository {

    public $setModel;

    public function __construct($model) {
        $this->model = $model;
        $this->setModel = $model;
    }
}