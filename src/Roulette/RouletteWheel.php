<?php
namespace DFredriksen\Roulette;

class RouletteWheel
{
    public $slots;

    public function __construct()
    {
        $this->slots = $this->generateRouletteWheelSlots();
        die(print_r($this->slots));
    }


    public function spin()
    {
      
        $num=rand(1, 38);

        //they are putting bet on either red or black
        if($num==1 || $num==3 || $num==5 || $num==7 || $num==9 || $num==12 || $num==14 || $num==16 || $num==18 || $num==19 || $num==21 || $num==23 || $num==25 || $num==27 || $num==30 || $num==32 || $num==34 || $num==36)
        {     
            $winningcolor="red";
        }
        else if($num==37 || $num==38)
        {     
            $winningcolor="green";
        }
        else
        {        
            $winningcolor="black";
        }

        return ['num'=>$num, 'color' => $winningcolor, 'type' => $num % 2 == 0 ? 'even' : 'odd'];
    }

    public function generateRouletteWheelSlots()
    {
        $slots = 
        [
            '0'  => [
                'color' => 'green'
                ,'type' => 'zero'
                ,'number' => '00'
            ],
            '00' => [
                'color' => 'green'
                ,'type' => 'zero'
                ,'number' => '00'
            ]
        ];      

        for($index = 1; $index < 37; $index++)
        {
            $slots[$index] = [
                'color' => $index % 2 == 0 ? ($index < 10 || $index >  18 ? 'black' : 'red') : ($index > 9 || $index <  27 ? 'red' : 'black')
                ,'type' => $index % 2 == 0 ? 'even' : 'odd'
                ,'number' => $index
            ];

            if($index == 10 || $index == 28)
                $slots[$index]['color'] = 'black';
        }

        return $slots;
    }

}

