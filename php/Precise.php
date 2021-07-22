<?php

namespace ccxt;

use BI\BigInteger;

class Precise {
    public $integer;
    public $decimals;
    public $base;

    public function __construct($number, $decimals = null) {
        if ($decimals === null) {
            $modifier = 0;
            $number = strtolower($number);
            if (strpos($number, 'e') > -1) {
                list($number, $modifier) = explode('e', $number);
                $modifier = intval($modifier);
            }
            $decimalIndex = strpos($number, '.');
            $this->decimals = ($decimalIndex > -1) ? strlen($number) - $decimalIndex - 1 : 0;
            $integerString = str_replace('.', '', $number);
            $this->integer = new BigInteger($integerString);
            $this->decimals = $this->decimals - $modifier;
        } else {
            $this->integer = $number;
            $this->decimals = $decimals;
        }
        $this->base = new BigInteger (10);
        $this->reduce();
    }

    public function mul($other) {
        $integerResult = $this->integer->mul($other->integer);
        return new Precise($integerResult, $this->decimals + $other->decimals);
    }

    public function div($other, $precision = 18) {
        $distance = $precision - $this->decimals + $other->decimals;
        if ($distance === 0) {
            $numerator = $this->integer;
        } elseif ($distance < 0) {
            $exponent = $this->base->pow(new BigInteger(-$distance));
            $numerator = $this->integer->div($exponent);
        } else {
            $exponent = $this->base->pow(new BigInteger($distance));
            $numerator = $this->integer->mul($exponent);
        }
        $result = $numerator->div($other->integer);
        return new Precise($result, $precision);
    }

    public function add($other) {
        if ($this->decimals === $other->decimals) {
            $integerResult = $this->integer->add($other->integer);
            return new Precise($integerResult, $this->decimals);
        } else {
            list($smaller, $bigger) =
                ($this->decimals > $other->decimals) ? array( $other, $this ) : array( $this, $other );
            $exponent = new BigInteger($bigger->decimals - $smaller->decimals);
            $normalised = $smaller->integer->mul($this->base->pow($exponent));
            $result = $normalised->add($bigger->integer);
            return new Precise($result, $bigger->decimals);
        }
    }

    public function sub($other) {
        $negative = new Precise($other->integer->neg(), $other->decimals);
        return $this->add($negative);
    }

    public function abs() {
        return new Precise($this->integer->abs(), $this->decimals);
    }

    public function neg() {
        return new Precise($this->integer->neg(), $this->decimals);
    }

    public function mod($other) {
        $rationizerNumerator = max(-$this->decimals + $other->decimals, 0);
        $numerator = $this->integer->mul($this->base->pow(new BigInteger($rationizerNumerator)));
        $denominatorRationizer = max(-$other->decimals + $this->decimals, 0);
        $denominator = $other->integer->mul($this->base->pow(new BigInteger($denominatorRationizer)));
        $result = $numerator->mod($denominator);
        return new Precise($result, $denominatorRationizer + $other->decimals);
    }

    public function pow($other) {
        $result = $this->integer->pow($other->integer);
        return new Precise($result, $this->decimals * $other->integer->toBase(10));
    }

    public function reduce() {
        $zero = new BigInteger(0);
        if ($this->integer->equals($zero)) {
            $this->decimals = 0;
            return $this;
        }
        $div = $this->integer->div($this->base);
        $mod = $this->integer->mod($this->base);
        while ($mod->equals($zero)) {
            $this->integer = $div;
            $this->decimals--;
            $div = $this->integer->div($this->base);
            $mod = $this->integer->mod($this->base);
        }
        return $this;
    }

    public function equals ($other) {
        return ($this->decimals === $other->decimals) && $this->integer->equals($other->integer);
    }

    public function __toString() {
        $sign = $this->integer->sign() === -1 ? '-' : '';
        $integerArray = str_split(str_pad($this->integer->abs()->toString(), $this->decimals, '0', STR_PAD_LEFT));
        $index = count($integerArray) - $this->decimals;
        if ($index === 0) {
            // if we are adding to the front
            $item = '0.';
        } else if ($this->decimals < 0) {
            $item = str_repeat('0', -$this->decimals);
        } else if ($this->decimals === 0) {
            $item = '';
        } else {
            $item = '.';
        }
        array_splice($integerArray, $index, 0, $item);
        return $sign . implode('', $integerArray);
    }

    public static function string_mul($string1, $string2) {
        if (($string1 === null) || ($string2 === null)) {
            return null;
        }
        return strval((new Precise($string1))->mul(new Precise($string2)));
    }

    public static function string_div($string1, $string2, $precision = 18) {
        if (($string1 === null) || ($string2 === null)) {
            return null;
        }
        return strval((new Precise($string1))->div(new Precise($string2), $precision));
    }

    public static function string_add($string1, $string2) {
        if (($string1 === null) && ($string2 === null)) {
            return null;
        }
        if ($string1 === null) {
            return $string2;
        } elseif ($string2 === null) {
            return $string1;
        }
        return strval((new Precise($string1))->add(new Precise($string2)));
    }

    public static function string_sub($string1, $string2) {
        if (($string1 === null) || ($string2 === null)) {
            return null;
        }
        return strval((new Precise($string1))->sub(new Precise($string2)));
    }

    public static function string_abs($string) {
        if ($string === null) {
            return null;
        }
        return strval((new Precise($string))->abs());
    }

    public static function string_neg($string) {
        if ($string === null) {
            return null;
        }
        return strval((new Precise($string))->neg());
    }

    public static function string_mod($string1, $string2) {
        if (($string1 === null) || ($string2 === null)) {
            return null;
        }
        return strval((new Precise($string1))->mod(new Precise($string2)));
    }

    public static function string_pow($string1, $string2) {
        if (($string1 === null) || ($string2 === null)) {
            return null;
        }
        return strval((new Precise($string1))->pow(new Precise($string2)));
    }
}
