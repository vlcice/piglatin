<?php declare(strict_types=1);

namespace Vlcice\PigLatin\Translator;


/**
 * Class Translator
 * @package Vlcice\PigLatin;
 */
class Translator
{
    const CONSONANTS = 'bcdfghjklmnpqrstuvwxz'; //y
    const VOWELS = 'aeiou'; //y
    const SEMIVOWEL = 'y';

    /**
     * A sillable added to the end of the word.
     */
    const SUFFIX_SYLLABLE = 'ay';

    /**
     * @var array
     */
    private $silent_consonants = [
        'mb', 'tle', 'gh', 'kn', 'wr', 'ght'
    ];

    /**
     * Input string.
     * @var string
     */
    private $input = '';

    /**
     * Output string.
     * @var string
     */
    private $output = '';

    /**
     * Error message if any.
     * @var string
     */
    private $errorMessage = '';

    /**
     * @param string $letter
     * @return bool
     */
    public function isConsonant(string $letter) : bool
    {
        return (strpos(self::CONSONANTS, $letter) !== false);
    }

    /**
     * @param string $letter
     * @return bool
     */
    public function isVowel(string $letter) : bool
    {
        return (strpos(self::VOWELS, $letter) !== false);
    }

    /**
     * @param string $letter
     * @return bool
     */
    public function isSemiVowel(string $letter) : bool
    {
        return $letter === self::SEMIVOWEL;
    }

    public function translate() : string
    {
        $matches = [];

        if ($this->isValid()) {
            $initialLetter = $this->input[0];   //faster than strpos

            preg_match('/(^['.self::CONSONANTS.']*)(.*)$/', $this->input, $matches, PREG_OFFSET_CAPTURE);
        }

        return json_encode($matches);
    }

    /**
     * Returns true if input string is valid.
     * @return bool
     */
    public function isValid() : bool
    {
        $this->errorMessage = '';

        if ($this->input === '') {
            $this->errorMessage = "Empty string";
        } elseif(!preg_match("/[a-z -\.]/i", $this->input)) {
            $this->errorMessage = "The input contains a non-alphabet character.";
        }

        return ($this->errorMessage !== '');
    }

    /**
     * Input setter.
     * @param $input
     * @return Translator
     */
    public function setInput($input) : self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * ErrorMessage getter.
     * @return string
     */
    public function getErrorMessage() : string
    {
        return $this->errorMessage;
    }
}
