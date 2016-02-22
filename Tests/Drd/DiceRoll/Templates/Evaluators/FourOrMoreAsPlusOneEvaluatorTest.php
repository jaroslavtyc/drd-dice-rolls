<?php
namespace Drd\DiceRoll\Templates\Evaluators;

use Drd\DiceRoll\DiceRoll;
use Granam\Integer\IntegerObject;

class FourOrMoreAsPlusOneEvaluatorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function can_create_instance()
    {
        $instance = new FourOrMoreAsOneEvaluator();
        $this->assertNotNull($instance);
    }

    /**
     * @test
     * @depends can_create_instance
     */
    public function greater_than_three_value_is_considered_as_plus_one_zero_otherwise()
    {
        $evaluator = new FourOrMoreAsOneEvaluator(\Mockery::mock(DiceRoll::class));
        /** @var DiceRoll|\Mockery\MockInterface $diceRoll */
        $diceRoll = \Mockery::mock(DiceRoll::class);
        $diceRoll->shouldReceive('getRolledNumber')
            ->once()
            ->andReturn($rolledNumber = \Mockery::mock(IntegerObject::class));
        $rolledNumber->shouldReceive('getValue')
            ->atLeast()->once()
            ->andReturnValues($values = range(-4, 10, 1));
        foreach ($values as $value) {
            $evaluated = $evaluator->evaluateDiceRoll($diceRoll);
            if ($value > 3) {
                $this->assertSame(1, $evaluated->getValue(), "Value of $value should be 1, but was evaluated as {$evaluated->getValue()}");
            } else {
                $this->assertSame(0, $evaluated->getValue());
            }
        }
    }
}
