<?php

namespace App\Tests\Util;

use App\Taxation\ComputeSalary;
use App\Repository\EdgeRepository;
use PHPUnit\Framework\TestCase;
use App\Entity\Edge;

final class ComputeSalaryTest extends TestCase
{
    public function testTaxationWithValue()
    {
        //Create edge entities
        $edges = [];
        $edge1 = new Edge();
        $edges[] = $edge1->setRate(0.05)->setStart(0)->setEnd(50000000)->setYear(2014);
        $edge2 = new Edge();
        $edges[] = $edge2->setRate(0.15)->setStart(50000000)->setEnd(250000000)->setYear(2014);
        $edge3 = new Edge();
        $edges[] = $edge3->setRate(0.25)->setStart(250000000)->setEnd(500000000)->setYear(2014);
        $edge4 = new Edge();
        $edges[] = $edge4->setRate(0.3)->setStart(500000000)->setYear(2014);

        //Create Stub
        $edgeRepository = $this->createMock(EdgeRepository::class);
        $edgeRepository->expects($this->any())->method('findBy')->willReturn($edges);
        
        //Create new instance of test
        $case1 = new ComputeSalary($edgeRepository,75000000);
        $case2 = new ComputeSalary($edgeRepository,750000000);

        //Return of test
        $this->assertEquals(6250000,$case1->compute());
        $this->assertEquals(170000000,$case2->compute());
    }
}