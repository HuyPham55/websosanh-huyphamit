<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class NestedSetService
{
    public $table = '';
    public $data = null;
    public $checked = null;
    public $count = 0;
    public $count_level = 0;
    public $lft = null;
    public $rgt = null;
    public $level = null;

    public function __construct($tableName)
    {
        $this->table = $tableName;
    }

    public function get(): void
    {
        $this->data = DB::table($this->table)
            ->select('id', 'parent_id', 'lft', 'rgt', 'level')
            ->orderBy('lft', 'ASC')
            ->get();
    }

    public function set()
    {
        $arr = null;
        if (!empty($this->data)) {
            foreach ($this->data as $key => $val) {
                $arr[$val->id][$val->parent_id] = 1;
                $arr[$val->parent_id][$val->id] = 1;
            }
        }

        return $arr;
    }

    public function recursive($start = 0, $arr = null): void
    {
        $this->lft[$start] = ++$this->count;
        $this->level[$start] = $this->count_level;

        if (isset($arr) && is_array($arr)) {
            foreach ($arr as $key => $val) {
                if ((isset($arr[$start][$key]) || isset($arr[$key][$start])) && (!isset($this->checked[$key][$start]) && !isset($this->checked[$start][$key]))) {
                    $this->count_level++;
                    $this->checked[$start][$key] = 1;
                    $this->checked[$key][$start] = 1;
                    $this->recursive($key, $arr);
                    $this->count_level--;
                }
            }
        }
        $this->rgt[$start] = ++$this->count;
    }

    function action(): void
    {
        if (isset($this->level) && is_array($this->level) && isset($this->lft) && is_array($this->lft) && isset($this->rgt) && is_array($this->rgt)) {
            $data = null;
            foreach ($this->level as $key => $val) {
                $data[] = array(
                    'id' => $key,
                    'level' => $val,
                    'lft' => $this->lft[$key],
                    'rgt' => $this->rgt[$key],
                );
            }
            if (!empty($data) && is_array($data)) {
                $num_key = count($data);
                for ($i = 1; $i < $num_key; $i++) {
                    DB::table($this->table)
                        ->where('id', $data[$i]['id'])
                        ->update($data[$i]);
                }
            }
        }
    }

    public function doNested(): void
    {
        $this->get();
        $this->recursive(0, $this->set());
        $this->action();
    }

}
