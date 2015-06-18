<?php


use TripleI\bus\App\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     * @group calculator-test1
     * @group calculator
     **/
    public function test1 ()
    {
        $fee = new Calculator(210);

        $this->assertEquals(210, $fee->execute('A', 'n'));
        $this->assertEquals(110, $fee->execute('C', 'n'));
        $this->assertEquals(110, $fee->execute('I', 'n'));

        $this->assertEquals(110, $fee->execute('A', 'w'));
        $this->assertEquals(60, $fee->execute('C', 'w'));
        $this->assertEquals(60, $fee->execute('I', 'w'));

        $this->assertEquals(0, $fee->execute('I', 'p'));
    }

}

