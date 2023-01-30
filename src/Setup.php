<?php

declare(strict_types=1);

namespace Dakword\WBWebAPI;

/**
 * @method array regions()
 * @method array dest()
 * @method array couponsgeo()
 * @method int reg()
 * @method int spp()
 * @method string pricemargincoeff()
 * @method string locale()
 * @method string lang()
 * @method string curr()
 * 
 * @method self withRegions(array $regions) default empty
 * @method self withDest(array $dest) default empty
 * @method self withCouponsGeo(array $couponsGeo) default empty
 * @method self withReg(int $reg) default 0
 * @method self withSpp(int $spp) default 0
 * @method self withPricemarginCoeff(string $pricemarginCoeff) default "1.0"
 * @method self withLocale(string $locale) default "ru"
 * @method self withLang(string $lang) default "ru"
 * @method self withCurr(string $curr) default "rub"
 * 
 * @method void setRegions(array $regions)
 * @method void setDest(array $dest)
 * @method void setCouponsGeo(array $couponsGeo)
 * @method void setReg(int $reg)
 * @method void setSpp(int $spp)
 * @method void setPricemarginCoeff(string $pricemarginCoeff)
 * @method void setLocale(string $locale)
 * @method void setLang(string $lang)
 * @method void setCurr(string $curr)
 */
class Setup
{
    private array $options = [
        'regions' => [],
        'dest' => [],
        'couponsgeo' => [],
        'reg' => 0,
        'spp' => 0,
        'pricemargincoeff' => '1.0',
        'locale' => 'ru',
        'lang' => 'ru',
        'curr' => 'rub',
    ];

    function __get($name)
    {
        if (array_key_exists(strtolower($name), $this->options)) {
            return $this->options[strtolower($name)];
        } else {
            return null;
        }
    }

    function __construct(array $options = [])
    {
        foreach ($options as $option => $value) {
            if (array_key_exists($option, $this->options)) {
                $this->options[$option] = $value;
            }
        }
    }

    function __call($name, $arguments)
    {
        // withOption()
        if (strtolower(substr($name, 0, 4)) == 'with') {
            $option = strtolower(substr($name, 4));
            if (array_key_exists($option, $this->options)) {
                $this->options[$option] = $arguments[0];
                return $this;
            }
        // setOption()
        } elseif (strtolower(substr($name, 0, 3)) == 'set') {
            $option = strtolower(substr($name, 3));
            if (array_key_exists($option, $this->options)) {
                $this->options[$option] = $arguments[0];
                return;
            }
        } elseif (array_key_exists(strtolower($name), $this->options)) {
            return $this->options[strtolower($name)];
        }

        throw new \BadMethodCallException("Undefined method $name");
    }

}
