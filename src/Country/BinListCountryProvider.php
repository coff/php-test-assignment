<?php

namespace Coff\TestAssignment\Country;

use Coff\TestAssignment\Enum\CountryIso3166Aplha2Enum;

class BinListCountryProvider implements CountryProviderInterface
{
    /**
     * Default setters and getters here
     */
    use CountryProviderTrait;

    /** @var mixed */
    protected $data;

    /**
     * In case we had to switch to another bin provider we just add another class implementing
     * CountryProviderInterface and add authentication etc. via proper setters called on bootstrap
     */

    /**
     * @return self
     * @throws \Exception
     */
    public function fetch(): self
    {
        $result = file_get_contents('https://lookup.binlist.net/' .$this->bin);

        if ($result === false) {
            throw new \Exception('Unable to perform country lookup!');
        }

        $this->data = json_decode($result);

        if ($this->data === null) {
            throw new \Exception('Bad response from country lookup!');
        }

        try {
            $this->country = CountryIso3166Aplha2Enum::fromValue($this->data->country->alpha2);
        } catch (\UnexpectedValueException $e) {
            throw new \Exception('Unknown country discovered!');
        }

        return $this;
    }


}