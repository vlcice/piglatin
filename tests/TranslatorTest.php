<?php

namespace Vlcice\PigLatin\Translator;

/**
 * Class TranslatorTest
 */
class TranslatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Translator
     */
    protected $translator;

    /**
     * TranslatorTest constructor.
     */
    public function setUp()
    {
        $this->translator = new Translator();
    }

    public function testTranslateWord()
    {
        $string = "banana";
        $expectedResult = "anana-bay";

        $this->assertEquals($expectedResult, $this->translator->translate($string));
    }

    public function testTranslateString()
    {
        $string = "beast dough happy question star three";
        $expectedResult = "east-bay ough-day appy-hay estion-quay ar-stay ee-thray";

        $this->assertEquals($expectedResult, $this->translator->translate($string));
    }
}
