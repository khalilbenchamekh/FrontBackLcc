<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 20/04/2020
 * Time: 15:47
 */

namespace App\Http\Resources;


class GetFess
{
    public $from;
    public $to;
    public $orderBy;
    public $table;

    function set_from($from) {
        $this->from = $from;
    } function set_to($to) {
        $this->to = $to;
    } function set_orderBy($orderBy) {
        $this->orderBy = $orderBy;
    } function set_table($table) {
        $this->table = $table;
    }
    function get_from() {
        return $this->from;
    }function get_to() {
        return $this->to;
    }function get_orderBy() {
        return $this->orderBy;
    }function get_table() {
        return $this->table;
    }
}
