<?php

/**
 * @author crouyre
 */

namespace App\Taxation;

use App\Repository\EdgeRepository;
use App\Entity\Edge;

final class ComputeSalary
{
    /**
     * @var int $salary
     */
    private $salary;

    /**
     * @var EdgeRepository $edgeRepository
     */
    private $edgeRepository;


    public function __construct(EdgeRepository $edgeRepository, int $salary)
    {
        $this->edgeRepository = $edgeRepository;
        $this->salary = $salary;
    }
    
    /**
     * @return float
     */
    public function compute() :float
    {
        //Declare
        $taxation = 0;
        $edges = $this->edgeRepository->findBy(['year'=>Edge::EXERCISE_YEAR]);
    
        //Execution
        foreach($edges as $edge)
        {
            if((($edge->getEnd() !== null) && ($this->salary - ($edge->getEnd() - $edge->getStart()) <= 0)) || ($edge->getEnd() === null) )
            {
                $taxation += $this->salary * $edge->getRate();
                break;
            }

            $taxation += ($edge->getEnd() - $edge->getStart()) * $edge->getRate();
            $this->salary -= $edge->getEnd() - $edge->getStart();
        }

        //Return
        return $taxation;
    }
}