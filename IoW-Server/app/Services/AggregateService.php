<?php

namespace App\Services;

use Illuminate\Support\Collection;

class AggregateService{

    # Avarage of values
    public function avg($values) : float{

        if($values instanceof Collection){
            return $values->avg();
        }

        if(is_array($values)){
            $count = count($values);

            if($count === 0){
                return 0;
            }

            return array_sum($values) / $count;
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    # Sum of values
    public function sum($values) : float{

        if($values instanceof Collection){
            return $values->sum();
        }

        if(is_array($values)){
            return  empty($values) ? 0 : array_sum($values);
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    public function max($values) : float{

        if($values instanceof Collection){
            return $values->max();
        }

        if(is_array($values)){
            return  empty($values) ? 0 : max($values);
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    public function min($values) : float{

        if($values instanceof Collection){
            return $values->min();
        }

        if(is_array($values)){
            return  empty($values) ? 0 : min($values);
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    public function median($values) : float{

        if($values instanceof Collection){
            return $values->median();
        }

        if(is_array($values)){
            $count = count($values);

            if($count === 0){
                return 0;
            }

            sort($values);

            $middle = (int) floor($count / 2);

            if($count % 2 === 1){
                return $values[$middle];
            }else{
                return ($values[$middle - 1] + $values[$middle]) / 2;
            }
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    public function mode($values) : float{
        if($values instanceof Collection){
            return array_sum($values->mode()) / count($values->mode());
        }

        if(is_array($values)){

            if(empty($values)){
                return 0;
            }

            $counts = array_count_values($values);

            $maxCount = max($counts);

            $modes = array_keys($counts, $maxCount);

            return array_sum($modes) / count($modes);
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    public function count($values) : int{
        if($values instanceof Collection){
            return $values->count();
        }

        if(is_array($values)){
            return count($values);
        }

        throw new \InvalidArgumentException('Values must be an array or Collection');
    }

    public function aggregate($array_of_values,string $type)
    {
        if (!method_exists($this, $type)) {
            throw new \InvalidArgumentException("Invalid aggregate type");
        }

        $result = [];

        foreach ($array_of_values as $values) {
            $result[] = $this->$type($values);
        }

        return $result;
    }

}
