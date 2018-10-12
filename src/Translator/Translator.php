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
     * Delimiter for strings initiated with consonants.
     */
    const C_DELIMITER = '-';

    /**
     * Delimiter for strings initiated with vowels.
     */
    const V_DELIMITER = '\'';

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
     * Translated string.
     * @var string
     */
    private $translation = '';

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

    /**
     * Translates string and returns translation.
     * @param string $input
     * @return string
     */
    public function translate(string $input) : string
    {
        $matches = [];
        $translatedWords = [];

        $this->setInput($input);

        if ($this->isValid()) {
            foreach (explode(' ', $this->input) as $word) {
                $initialLetter = $word[0];
                if ($this->isConsonant($initialLetter)) {

                    $pattern = '/^([' . self::CONSONANTS . ']*)([^' . self::CONSONANTS . '].)(.*)$/';
                    preg_match($pattern, $word, $matches);

                    $first = $matches[2] . $matches[3];
                    $second = self::C_DELIMITER;
                    $middle = $matches[1];
                } else {
                    $pattern = '/^([' . self::VOWELS . ']*)([^' . self::VOWELS . '].)(.*)$/';
                    preg_match($pattern, $word, $matches);

                    $first = $matches[0];
                    $second = self::V_DELIMITER;
                    $middle = self::CONSONANTS[rand(0, strlen(self::CONSONANTS) - 1)];   //extra consonant
                }
                $translatedWords[] = $first . $second . $middle . self::SUFFIX_SYLLABLE;
            }

            $this->translation = implode(' ', $translatedWords);
        }

        return $this->translation;
    }

    /**
     * Returns true if input string is valid.
     * @return bool
     */
    public function isValid() : bool
    {
        if ($this->input === '') {
            $this->errorMessage = "Empty string";
        } elseif(preg_match("/[^\w ]+/i", $this->input)) {
            $this->errorMessage = "The input contains a non-alphabet character! Please check input.";
        }

        return ($this->errorMessage === '');
    }

    /**
     * Input setter.
     * @param string $input
     * @return Translator
     */
    public function setInput(string $input) : self
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Input getter.
     * @return string
     */
    public function getInput() : string
    {
        return $this->input;
    }

    /**
     * Translated string getter.
     * @return string
     */
    public function getTranslation() : string
    {
        return $this->translation;
    }

    /**
     * Error message setter.
     * @param string $errorMessage
     * @return Translator
     */
    public function setErrorMessage(string $errorMessage) : self
    {
        $this->errorMessage = $errorMessage;

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
